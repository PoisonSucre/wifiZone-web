# WiFi Hotspot SaaS — Plateforme de gestion de tickets WiFi MikroTik

Plateforme SaaS permettant à des vendeurs de configurer des portails captifs MikroTik,
gérer leurs hotspots et forfaits, vendre des tickets WiFi en ligne via LigdiCash,
et télécharger un package MikroTik prêt à installer sur leur routeur.

## Sommaire

- [Aperçu](#aperçu)
- [Technologies](#technologies)
- [Prérequis](#prérequis)
- [Installation](#installation)
- [Configuration](#configuration)
- [Architecture](#architecture)
- [Modèles de données](#modèles-de-données)
- [Flux de paiement](#flux-de-paiement)
- [Import de tickets Mikhmon](#import-de-tickets-mikhmon)
- [Package MikroTik](#package-mikrotik)
- [Walled Garden](#walled-garden)
- [Administration](#administration)
- [API](#api)
- [Tests](#tests)

---

## Aperçu

La plateforme connecte trois acteurs :

| Acteur | Rôle |
|--------|------|
| **Admin** | Gère les vendeurs, valide les retraits, configure la plateforme (commission, devise, packs). |
| **Vendeur** | Crée ses hotspots, configure son portail (couleurs, logo, message), définit ses forfaits, importe ses tickets Mikhmon, reçoit les paiements. |
| **Client** | Visite la boutique publique du vendeur, choisit un forfait, paie via LigdiCash, reçoit ses identifiants WiFi. |

### Fonctionnalités principales

- **Portail captif personnalisable** : couleurs, logo, nom, message de bienvenue par hotspot.
- **Gestion multi-hotspots** : packs d'abonnement (A/B/C) avec quotas de slots.
- **Forfaits** : label, montant, durée, activation/désactivation.
- **Import de tickets Mikhmon** : assistant en 3 étapes (hotspot → forfait → upload CSV/Excel).
- **Paiement en ligne LigdiCash** : intégration complète avec callback webhook.
- **Package MikroTik** : téléchargement d'un ZIP contenant `login.html` personnalisé + assets.
- **Walled Garden** : génération automatique des commandes MikroTik pour autoriser la plateforme et LigdiCash.
- **Retraits** : demande de retrait avec calcul automatique de la commission.
- **Tableau de bord** : statistiques de ventes, tickets disponibles, revenus, graphiques.
- **Mode sombre** : basculement clair/sombre via cookie.

---

## Technologies

| Technologie | Version | Usage |
|-------------|---------|-------|
| PHP | 8.3+ | Langage serveur |
| Laravel | 13.x | Framework backend |
| Livewire | 4.x | Composants réactifs |
| Alpine.js | — | Interactions frontend |
| Tailwind CSS | — | Styles utilitaires |
| PhpSpreadsheet | 5.x | Lecture Excel (import tickets) |
| MySQL | — | Base de données |
| Vite | 8.x | Build des assets |
| LigdiCash API | — | Passerelle de paiement |

---

## Prérequis

- PHP >= 8.3 avec extensions : `pdo_mysql`, `mbstring`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`, `zip`
- MySQL 8.x / MariaDB 10.x
- Composer
- Node.js >= 18 et npm
- Serveur web (Nginx/Apache) ou `php artisan serve`

---

## Installation

```bash
# 1. Cloner le dépôt
git clone <url-du-depot> hotspot_sass_laravel
cd hotspot_sass_laravel

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances JS
npm install

# 4. Copier le fichier d'environnement
cp .env.example .env

# 5. Générer la clé d'application
php artisan key:generate

# 6. Configurer la base de données dans .env (voir section Configuration)

# 7. Exécuter les migrations
php artisan migrate

# 8. (Optionnel) Seeder des données de démonstration
php artisan db:seed --class=DemoVendeursSeeder

# 9. Créer le lien symbolique pour le storage public
php artisan storage:link

# 10. Compiler les assets
npm run build

# 11. Démarrer le serveur
php artisan serve
```

---

## Configuration

### Fichier `.env`

Variables clés à configurer :

```env
APP_NAME="WiFi Hotspot SaaS"
APP_URL=http://localhost:8000
APP_KEY=

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotspot_saas
DB_USERNAME=root
DB_PASSWORD=

# Plateforme
PLATFORM_NAME="Wifi Pour Tous"
PLATFORM_CURRENCY=XOF
PLATFORM_COMMISSION_PCT=10
PLATFORM_SUPPORT_EMAIL=support@example.com

# LigdiCash
LIGDICASH_API_KEY=your_api_key
LIGDICASH_API_TOKEN=your_api_token
LIGDICASH_BASE_URL=https://app.ligdicash.com/pay/v01/redirect/checkout-invoice

# URLs de paiement
BASE_URL=http://localhost:8000
CALLBACK_URL=http://localhost:8000/api/payment-callback
RETURN_URL=http://localhost:8000/merci
CANCEL_URL=http://localhost:8000/annule

# API
APP_API_KEY=your_api_key_for_webhooks
```

### Fichier `config/platform.php`

Centralise la configuration de la plateforme :

```php
return [
    'name' => env('PLATFORM_NAME', 'Wifi Pour Tous'),
    'currency' => env('PLATFORM_CURRENCY', 'XOF'),
    'commission_pct' => (float) env('PLATFORM_COMMISSION_PCT', 10),
    'ligdicash' => [
        'api_key'  => env('LIGDICASH_API_KEY'),
        'api_token' => env('LIGDICASH_API_TOKEN'),
        'base_url' => env('LIGDICASH_BASE_URL', ...),
    ],
    'urls' => [
        'base' => env('BASE_URL'),
        'callback' => env('CALLBACK_URL'),
        'return' => env('RETURN_URL'),
        'cancel' => env('CANCEL_URL'),
    ],
];
```

---

## Architecture

### Structure des dossiers

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php          # Authentification vendeur
│   │   ├── AdminAuthController.php     # Authentification admin
│   │   ├── ForgotPasswordController.php
│   │   ├── EmailVerificationController.php
│   │   ├── ShopController.php          # Boutique publique
│   │   ├── PaymentInitController.php   # Initiation paiement LigdiCash
│   │   ├── PackPaymentController.php   # Paiement pack hotspot
│   │   ├── TemplateDownloadController.php  # ZIP MikroTik
│   │   ├── PageController.php          # Pages publiques
│   │   └── Api/
│   │       └── PaymentApiController.php    # Webhook LigdiCash
│   ├── Livewire/
│   │   ├── Admin/      # Composants admin
│   │   ├── Auth/       # Composants auth
│   │   ├── Vendor/     # Composants vendeur
│   │   └── Shop/       # Boutique publique
│   └── Middleware/
│       ├── ApplyThemeMiddleware.php
│       ├── EnsureAdmin.php
│       ├── EnsureApiKey.php
│       └── EnsureVendeurIsActive.php
├── Models/
├── Services/
│   ├── LigdiCashService.php
│   ├── HotspotService.php
│   ├── TicketService.php
│   └── StatsService.php
└── ...

config/
├── platform.php        # Configuration de la plateforme

routes/
├── web.php             # Routes web (vendor, admin, public)
└── api.php             # Routes API (webhook paiement)
```

### Routes principales

#### Publiques

| Méthode | URI | Description |
|---------|-----|-------------|
| GET | `/` | Page d'accueil |
| GET | `/shop/{id}` | Boutique publique d'un vendeur |
| POST | `/payment/init` | Initiation d'un paiement LigdiCash |
| GET | `/merci` | Page de remerciment après paiement |
| GET | `/annule` | Page d'annulation de paiement |
| GET | `/recuperer-ticket` | Récupération de ticket par téléphone |
| GET | `/installation` | Guide d'installation MikroTik |

#### Vendeur (préfixe `/vendeur`, middleware `auth`)

| URI | Description |
|-----|-------------|
| `/` | Tableau de bord |
| `/hotspot` | Gestion des hotspots |
| `/hotspot/{id}` | Détails d'un hotspot |
| `/boutique` | Personnalisation du portail + forfaits |
| `/boutique/download` | Téléchargement du package MikroTik |
| `/import` | Import de tickets Mikhmon |
| `/tickets` | Liste des tickets |
| `/transactions` | Transactions |
| `/retraits` | Demandes de retrait |
| `/profil` | Profil vendeur |
| `/alertes` | Transactions sans ticket assigné |

#### Admin (préfixe `/raider`, middleware `auth:admin`)

| URI | Description |
|-----|-------------|
| `/` | Tableau de bord admin |
| `/vendeurs` | Gestion des vendeurs |
| `/tickets` | Tous les tickets |
| `/transactions` | Toutes les transactions |
| `/retraits` | Validation des retraits |
| `/admins` | Gestion des admins |
| `/parametres` | Configuration de la plateforme |
| `/journal` | Journal des actions admin |

---

## Modèles de données

### Vendeur (`vendeurs`)

| Champ | Type | Description |
|-------|------|-------------|
| `nom`, `prenom` | string | Nom du vendeur |
| `email` | string (unique) | Email de connexion |
| `telephone` | string | Téléphone |
| `password` | string | Mot de passe hashé |
| `statut` | enum | `actif`, `en_attente`, `suspendu` |
| `commission_pct` | float | Commission de la plateforme |
| `couleur`, `couleur_top` | string | Couleurs du portail |
| `nom_portail` | string | Nom affiché sur le portail |
| `logo` | string | Chemin du logo |
| `message_bienvenue` | text | Message d'accueil |
| `card_number` | string (unique) | Numéro de carte |

### Hotspot (`hotspots`)

| Champ | Type | Description |
|-------|------|-------------|
| `vendeur_id` | FK | Vendeur propriétaire |
| `name` | string | Nom du hotspot |
| `statut` | enum | `actif`, `inactif` |
| `slot_type` | enum | `gratuit`, `abonnement` |
| `mikrotik_url` | string | URL du routeur MikroTik |
| `couleur`, `couleur_top` | string | Couleurs spécifiques au hotspot |
| `logo` | string | Logo spécifique au hotspot |

### Forfait (`vendor_forfaits`)

| Champ | Type | Description |
|-------|------|-------------|
| `vendeur_id` | FK | Vendeur |
| `hotspot_id` | FK (nullable) | Hotspot spécifique ou global |
| `label` | string | Nom du forfait (ex: "1 Heure") |
| `montant` | integer | Prix en FCFA |
| `duree_minutes` | integer | Durée de validité |
| `actif` | boolean | Activé/désactivé |
| `ordre` | integer | Ordre d'affichage |

### Ticket (`ticket`)

| Champ | Type | Description |
|-------|------|-------------|
| `vendeur_id` | FK | Vendeur |
| `hotspot_id` | FK (nullable) | Hotspot rattaché |
| `user` | string | Nom d'utilisateur WiFi |
| `password` | string | Mot de passe WiFi |
| `forfait` | string | Label du forfait |
| `montant` | integer | Prix |
| `status` | enum | `disponible`, `vendu` |
| `source` | enum | `import`, `manual` |
| `token` | string | Jeton d'achat |

### Transaction (`transactions`)

| Champ | Type | Description |
|-------|------|-------------|
| `vendeur_id` | FK | Vendeur |
| `transaction_id` | string | ID LigdiCash |
| `montant` | integer | Montant |
| `statut` | string | `pending`, `completed`, `notcompleted` |
| `type` | string | `ticket`, `pack` |
| `ticket_id` | FK (nullable) | Ticket assigné après paiement |
| `commission` | float | Commission calculée |
| `phone_number` | string | Téléphone du client |

### Autres tables

| Table | Description |
|-------|-------------|
| `hotspot_subscriptions` | Abonnements packs (A/B/C) avec slots et expiration |
| `withdrawals` | Demandes de retrait vendeur |
| `import_batches` | Historique des imports de tickets |
| `admins` | Comptes administrateurs |
| `admin_logs` | Journal des actions admin |
| `settings` | Paramètres de la plateforme (clé-valeur) |

---

## Flux de paiement

```
Client visite /shop/{vendeur_id}
       │
       ▼
Choisit un forfait → POST /payment/init
       │
       ▼
PaymentInitController
  ├── Valide vendeur + forfait
  ├── Vérifie HotspotService::saleBlockReason()
  ├── Crée une Transaction (statut: pending)
  ├── Appelle LigdiCashService::createInvoice()
  └── Redirige vers la page de paiement LigdiCash
       │
       ▼
Client paie sur LigdiCash (Mobile Money, etc.)
       │
       ▼
LigdiCash envoie un callback → POST /api/payment-callback
       │
       ▼
PaymentApiController@callback
  ├── Confirme le paiement via LigdiCashService::confirmPayment()
  ├── Met à jour la Transaction (statut: completed)
  ├── Si type = ticket → TicketService::assignTicket()
  │     └── Marque un ticket comme "vendu", génère un token
  ├── Si type = pack → HotspotService::activatePack() ou renewSubscription()
  ├── Calcule la commission
  └── Envoie un email de confirmation
       │
       ▼
Client redirigé vers /merci → voit ses identifiants WiFi
```

### Paiement de packs hotspot

Le vendeur peut acheter un pack d'abonnement (A: 1 slot, B: 3 slots, C: 10 slots) via `PackPaymentController`. Le flux est identique mais `type = pack` et le callback active l'abonnement au lieu d'assigner un ticket.

---

## Import de tickets Mikhmon

L'import se fait via un assistant en 3 étapes :

### Étape 1 — Sélection du hotspot
- Si l'URL contient `?hotspot=X`, le hotspot est pré-sélectionné et l'étape est sautée.
- Sinon, le vendeur choisit parmi ses hotspots.

### Étape 2 — Sélection du forfait
- Le vendeur choisit un forfait parmi ceux qu'il a configurés.
- **Si aucun forfait n'existe** : redirection vers la page boutique pour en créer un, avec un bouton "Retour à l'import" pour revenir ensuite.
- Le montant des tickets proviendra du forfait sélectionné, pas du fichier Mikhmon.

### Étape 3 — Upload du fichier Mikhmon
- Format Mikhmon : `Username,Password,Profile,Time Limit,Data Limit,Comment`
- **Seules les 2 premières colonnes sont obligatoires** (Username, Password).
- Les colonnes Profile, Time Limit, Data Limit, Comment sont ignorées.
- Si Password est vide, Username est utilisé comme mot de passe (mode VC Mikhmon).
- Détection automatique de l'en-tête (si la première ligne contient "Username", "User", etc.).
- Délimiteur auto : virgule ou point-virgule.
- Formats acceptés : `.csv`, `.xlsx`, `.xls` (max 5 Mo).
- Limite : 500 tickets par import.
- Doublons : les usernames déjà existants sont ignorés.

### Service : `TicketService::importFromMikhmon()`

```php
app(TicketService::class)->importFromMikhmon(
    vendeurId: $vendeur->id,
    file: $file,
    forfaitId: $forfaitId,
    hotspotId: $hotspotId
);
```

---

## Package MikroTik

### Téléchargement

**Route :** `GET /vendeur/boutique/download`

`TemplateDownloadController` génère un ZIP contenant :

| Fichier | Description |
|---------|-------------|
| `login.html` | Portail captif personnalisé (couleurs, logo, forfaits) |
| `style.css` | Styles du portail |
| `logo.<ext>` | Logo du vendeur (si configuré) |
| `orange.png`, `moov.png`, `wave.png` | Logos moyens de paiement |

Le `login.html` est personnalisé avec :
- L'URL de la plateforme (pour les requêtes de paiement)
- Les couleurs et le nom du portail du vendeur
- Les forfaits actifs du vendeur
- Le logo du vendeur/hotspot

### Installation côté MikroTik

1. Télécharger le ZIP depuis la page **Mon Portail**.
2. Extraire les fichiers.
3. Uploader `login.html` et les assets dans le dossier `hotspot` du routeur MikroTik (via Winbox → Files).
4. Configurer le Walled Garden (voir section suivante).

---

## Walled Garden

Le Walled Garden permet aux clients non authentifiés d'accéder à la plateforme de paiement sans être connectés à Internet.

### Génération

Sur la page **Mes Hotspots**, un bouton "Walled Garden" ouvre un popup avec les commandes MikroTik prêtes à copier-coller.

**Composant :** `WalledGardenModal` (écoute l'événement `open-walled-garden`)

### Configuration générée

```mikrotik
/ip hotspot walled-garden
add dst-host=plateforme.com comment="Plateforme"
add dst-host=*.plateforme.com comment="Sous-domaines plateforme"
add dst-address=IP_SERVEUR comment="IP plateforme"
add dst-host=ligdicash.com comment="LigdiCash"
add dst-host=*.ligdicash.com comment="LigdiCash sous-domaines"
add dst-host=cdnjs.cloudflare.com comment="FontAwesome / CDN"
```

### Installation

1. Copier les commandes depuis le popup.
2. Ouvrir Winbox → New Terminal.
3. Coller les commandes.
4. Tester : un client non connecté doit pouvoir ouvrir le lien de paiement.

---

## Administration

### Tableau de bord admin

- Statistiques globales : vendeurs, tickets vendus, revenus, commissions.
- Graphiques d'évolution sur 7 jours.
- Gestion des vendeurs (activation, suspension, suppression, commission).
- Validation des retraits (approbation, paiement, rejet).
- Gestion des tickets et transactions.
- Journal des actions admin.
- Paramètres de la plateforme (nom, devise, commission, packs hotspot).
- Gestion des administrateurs.

### Packs hotspot

| Pack | Slots | Type |
|------|-------|------|
| A | 1 hotspot | Abonnement |
| B | 3 hotspots | Abonnement |
| C | 10 hotspots | Abonnement |

Les abonnements expirent et peuvent être gelés automatiquement si non renouvelés (`HotspotService::freezeExpiredSubscriptions`).

---

## API

### Webhook LigdiCash

**Route :** `POST /api/payment-callback`

Reçoit le callback de LigdiCash après un paiement. Le webhook :
1. Extrait les `custom_data` (transaction_id, vendeur_id).
2. Confirme le paiement via l'API LigdiCash.
3. Met à jour la transaction.
4. Assigne un ticket ou active un pack selon le type.

### Middleware API

`EnsureApiKey` valide le header `X-API-Key` pour les routes API protégées.

---

## Services

### LigdiCashService

- `createInvoice()` : crée une facture de paiement LigdiCash.
- `confirmPayment($token)` : vérifie le statut d'un paiement.
- `buildPayload()` : construit le payload pour l'API LigdiCash.
- `generateTransactionId()` : génère un ID unique.

### HotspotService

- `canCreate($vendeur)` : vérifie le quota de hotspots.
- `freezeExpiredSubscriptions($vendeur)` : gèle les abonnements expirés.
- `saleBlockReason($vendeur, $hotspot)` : raison de blocage des ventes.
- `activatePack($vendeur, $packKey)` : active un pack d'abonnement.
- `renewSubscription($subscription)` : renouvelle un abonnement.

### TicketService

- `assignTicket($vendeurId, $montant, $token)` : assigne un ticket disponible à un paiement.
- `importFromMikhmon($vendeurId, $file, $forfaitId, $hotspotId)` : import depuis Mikhmon.
- `importFromCsv(...)` : import CSV legacy (non utilisé par l'UI actuelle).
- `generateBatch($vendeurId, $params)` : génération manuelle de tickets.

### StatsService

- Statistiques de revenus et commissions (avec cache).
- Données pour graphiques.
- Calculs d'évolution.

---

## Tests

```bash
# Lancer les tests
php artisan test

# Tests avec couverture
php artisan test --coverage
```

### Seeders

```bash
# Données de démonstration
php artisan db:seed --class=DemoVendeursSeeder
```

---

## Build des assets

```bash
# Développement (watch)
npm run dev

# Production
npm run build
```

---

## Commandes utiles

```bash
# Vider le cache
php artisan optimize:clear

# Vider les vues compilées
php artisan view:clear

# Vider le cache de configuration
php artisan config:clear

# Recréer le lien storage
php artisan storage:link

# Migrations
php artisan migrate
php artisan migrate:fresh --seed  # Reset complet
```

---

## Licence

Ce projet est un logiciel propriétaire. Tous droits réservés.
