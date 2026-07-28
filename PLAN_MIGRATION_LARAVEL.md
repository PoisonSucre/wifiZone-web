# PLAN DE MIGRATION — PHP → Laravel 13 + Livewire

## PHASE 0 : Initialisation du Projet

### Structure cible

```
hotspot_sass_laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Livewire/
│   │   │   ├── Vendor/
│   │   │   ├── Admin/
│   │   │   ├── Auth/
│   │   │   ├── Shop/
│   │   │   └── Api/
│   │   └── Middleware/
│   ├── Models/
│   ├── Services/
│   │   ├── LigdiCashService.php
│   │   ├── MikrotikService.php
│   │   ├── MikrotikRestClient.php
│   │   ├── TicketService.php
│   │   └── EncryptionService.php
│   ├── Observers/
│   └── Console/Commands/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   ├── vendor/
│   │   ├── admin/
│   │   ├── auth/
│   │   ├── shop/
│   │   ├── pages/
│   │   └── components/
│   └── css/ + js/
├── routes/
│   ├── web.php
│   └── api.php
└── config/
```

### Étape 0.1 — Créer le projet

```bash
composer create-project laravel/laravel hotspot_sass_laravel
composer require livewire/livewire
```

### Étape 0.2 — Installer les dépendances

```bash
composer require php-http/guzzle-adapter
```

---

## PHASE 1 : Base de Données (Migrations)

Recréer toutes les migrations dans l'ordre logique :

| # | Migration | Table | Colonnes clés |
|---|-----------|-------|---------------|
| 1 | `create_vendeurs_table` | `vendeurs` | nom, prenom, email (unique), telephone, password, adresse, ville, statut (enum), commission_pct, couleur, logo, message_bienvenue |
| 2 | `create_mikrotik_configs_table` | `mikrotik_config` | vendeur_id (FK cascade), ip_router, mac_address, nom_routeur, ssh_port, api_port, api_user, api_pass (encrypted), routeros_version (enum), statut, last_error, last_sync, polling_secret, polling_active, polling_last_check, polling_last_count |
| 3 | `create_vendor_forfaits_table` | `vendor_forfaits` | vendeur_id (FK cascade), label, montant, duree_minutes, actif, ordre |
| 4 | `create_tickets_table` | `ticket` | vendeur_id (FK), user, password, forfait, montant, token, status (enum), mikrotik_id, source (enum) |
| 5 | `create_transactions_table` | `transactions` | vendeur_id (FK), token, transaction_id, montant, statut, ticket_id, phone_number, verification_status, commission |
| 6 | `create_import_batches_table` | `import_batches` | vendeur_id (FK cascade), filename, format_file (enum), total_tickets, statut |
| 7 | `create_withdrawals_table` | `withdrawals` | vendeur_id (FK), montant_brut, commission_pct, montant_commission, montant_net, statut (enum), phone_number, note, date_traitement, traite_par |
| 8 | `create_settings_table` | `settings` | setting_key (unique), setting_value, description |

**Améliorations Laravel :**
- Ajouter `created_at` / `updated_at` sur toutes les tables
- Ajouter des index sur toutes les FK
- Utiliser `$table->enum()` au lieu de raw SQL
- Seeder les données admin + settings

---

## PHASE 2 : Models & Relations

| Model | Table | Relations |
|-------|-------|-----------|
| `Vendeur` | `vendeurs` | hasOne(MikrotikConfig), hasMany(Forfait), hasMany(Ticket), hasMany(Transaction), hasMany(Withdrawal) |
| `MikrotikConfig` | `mikrotik_config` | belongsTo(Vendeur) |
| `Forfait` | `vendor_forfaits` | belongsTo(Vendeur) |
| `Ticket` | `ticket` | belongsTo(Vendeur), belongsTo(Transaction) |
| `Transaction` | `transactions` | belongsTo(Vendeur), belongsTo(Ticket) |
| `ImportBatch` | `import_batches` | belongsTo(Vendeur) |
| `Withdrawal` | `withdrawals` | belongsTo(Vendeur) |
| `Setting` | `settings` | — (key-value store) |

**Scopes utiles :**
- `Ticket::vendus()`, `Ticket::disponibles()`
- `Transaction::completed()`
- `Withdrawal::pending()`

---

## PHASE 3 : Authentification

| Guard | Model | Middleware |
|-------|-------|------------|
| `web` (vendeur) | `Vendeur` | `auth` + `vendeur.status` |
| `admin` | `Vendeur` | `auth:admin` + `admin` |

**Éléments à migrer :**
- Login vendeur : email + password, bcrypt, vérification statut `actif`
- Login admin : email + password (haché avec bcrypt, pas en clair !)
- Inscription vendeur : formulaire 3 étapes, statut `en_attente`
- Middleware `EnsureVendeurIsActive` : vérifie `statut = 'actif'` à chaque requête
- CSRF : automatique avec Laravel `@csrf`
- Rate limiting : `throttle:login` middleware

---

## PHASE 4 : Services (Logique métier extraite)

### 4.1 LigdiCashService

```php
class LigdiCashService {
    public function createInvoice(array $data): array  // POST checkout-invoice/create
    public function confirmPayment(string $token): array  // GET confirm
    private function request(string $method, string $url, array $data): array
}
```

### 4.2 MikrotikService

```php
class MikrotikService {
    public function connect(array $config): mixed
    public function testConnection(array $config): array
    public function detectSettings(array $config): array
    public function preflightCheck(string $host, int $port): array
    public function listUsers(mixed $api, array $filters = []): array
    public function createUser(mixed $api, string $user, string $pass, string $profile): bool
    public function deleteUser(mixed $api, string $mikrotikId): bool
    public function syncFromRouter(int $vendeurId): array
    public function pushUsers(int $vendeurId, string $secret, array $users): array
    public function cronSync(int $vendeurId): array
    public function encrypt(string $text): string
    public function decrypt(string $encrypted): string
    public function generatePollingSecret(): string
    public function generateScript(int $vendeurId, string $secret): string
}
```

### 4.3 MikrotikRestClient (RouterOS v7)

```php
class MikrotikRestClient {
    public function connect(string $host, int $port, string $user, string $pass): void
    public function get(string $path): array
    public function put(string $path, array $data): array
    public function patch(string $path, array $data): array
    public function del(string $path): bool
    public function disconnect(): void
}
```

### 4.4 TicketService

```php
class TicketService {
    public function assignTicket(int $vendeurId, int $montant, string $token): ?Ticket
    public function importFromCsv(int $vendeurId, UploadedFile $file): array
    public function generateBatch(int $vendeurId, array $params): int
    public function getAvailableCount(int $vendeurId): int
    public function getSoldCount(int $vendeurId): int
}
```

### 4.5 EncryptionService

```php
class EncryptionService {
    public function encrypt(string $text): string  // AES-128-CBC
    public function decrypt(string $encrypted): string
}
```

---

## PHASE 5 : Routes & Contrôleurs

### 5.1 Routes Web (routes/web.php)

```php
// Public
Route::get('/', [LandingController::class, 'index']);
Route::get('/shop/{vendeur}', [ShopController::class, 'show'])->name('shop');
Route::get('/contact', [PageController::class, 'contact']);
Route::get('/recuperer-ticket', [PageController::class, 'recupererTicket']);
Route::post('/recuperer-ticket', [PageController::class, 'recupererTicket']);

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/auth/register', [AuthController::class, 'showRegister']);
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::get('/auth/login', [AuthController::class, 'showLogin']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::get('/raider/login', [AdminController::class, 'showLogin']);
    Route::post('/raider/login', [AdminController::class, 'login']);
});

// Vendor
Route::middleware(['auth', 'vendeur.status'])->prefix('vendeur')->name('vendor.')->group(function () {
    Route::get('/', [VendorDashboard::class, 'index']);
    Route::get('/tickets', [VendorTickets::class, 'index']);
    Route::get('/boutique', [VendorBoutique::class, 'index']);
    Route::get('/profil', [VendorProfil::class, 'index']);
    Route::get('/mikrotik', [VendorMikrotik::class, 'index']);
    Route::get('/walled-garden', [VendorWalledGarden::class, 'index']);
    Route::get('/retraits', [VendorRetraits::class, 'index']);
});

// Admin
Route::middleware(['auth:admin', 'admin'])->prefix('raider')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboard::class, 'index']);
    Route::get('/vendeurs', [AdminVendeurs::class, 'index']);
    Route::get('/transactions', [AdminTransactions::class, 'index']);
    Route::get('/tickets', [AdminTickets::class, 'index']);
    Route::get('/ajouter-ticket', [AdminTickets::class, 'create']);
    Route::get('/boutique', [AdminBoutique::class, 'index']);
    Route::get('/parametres', [AdminParametres::class, 'index']);
    Route::get('/retraits', [AdminRetraits::class, 'index']);
});
```

### 5.2 Routes API (routes/api.php)

```php
// Payment (public webhook)
Route::post('/payment-process', [PaymentApiController::class, 'process']);
Route::post('/payment-callback', [PaymentApiController::class, 'callback']);

// MikroTik (authenticated)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/mikrotik/test', [MikrotikApiController::class, 'test']);
    Route::post('/mikrotik/detect', [MikrotikApiController::class, 'detect']);
    Route::get('/mikrotik/preflight', [MikrotikApiController::class, 'preflight']);
    Route::post('/mikrotik/import', [MikrotikApiController::class, 'import']);
    Route::get('/mikrotik/template', [MikrotikApiController::class, 'template']);
});

// MikroTik Polling (secret-based auth)
Route::get('/mikrotik/poll', [MikrotikPollController::class, 'poll']);
Route::post('/mikrotik/push-users', [MikrotikPollController::class, 'pushUsers']);
Route::post('/mikrotik/poll-confirm', [MikrotikPollController::class, 'pollConfirm']);
Route::get('/mikrotik/cron-sync', [MikrotikPollController::class, 'cronSync']);
```

### 5.3 Route Pages

```php
Route::get('/merci', [PageController::class, 'merci']);
Route::get('/annule', [PageController::class, 'annule']);
```

---

## PHASE 6 : Livewire Components

### 6.1 Auth (app/Livewire/Auth/)

| Component | Page | Description |
|-----------|------|-------------|
| `RegisterForm` | `/auth/register` | Formulaire 3 étapes (identity → contact → security) |
| `LoginForm` | `/auth/login` | Email + password, rate limiting |
| `AdminLoginForm` | `/raider/login` | Login admin |

### 6.2 Vendor Dashboard (app/Livewire/Vendor/)

| Component | Page | Description |
|-----------|------|-------------|
| `Dashboard` | `/vendeur/` | Stats, chart (Chart.js via wire:init), ventes récentes |
| `TicketList` | `/vendeur/tickets` | Liste tickets, filtres, recherche, toggle password |
| `BoutiqueManager` | `/vendeur/boutique` | CRUD forfaits, couleur, logo, message, aperçu live |
| `ProfilEditor` | `/vendeur/profil` | Édition profil + changement mot de passe |
| `MikrotikConfig` | `/vendeur/mikrotik` | Config connexion, polling, sync, import (2 onglets) |
| `WalledGarden` | `/vendeur/walled-garden` | Affichage script MikroTik (lecture seule) |
| `RetraitManager` | `/vendeur/retraits` | Demande retrait, historique, calcul commission |

### 6.3 Admin (app/Livewire/Admin/)

| Component | Page | Description |
|-----------|------|-------------|
| `Dashboard` | `/raider/` | Stats globales, derniers vendeurs/transactions |
| `VendeurManager` | `/raider/vendeurs` | CRUD vendeurs, commission, boutique, forfaits |
| `TransactionList` | `/raider/transactions` | Liste filtrable, 200 max |
| `TicketList` | `/raider/tickets` | Liste filtrable, 500 max |
| `TicketCreator` | `/raider/ajouter-ticket` | Création unitaire + batch (500 max) |
| `BoutiqueEditor` | `/raider/boutique` | Boutique admin-as-vendor |
| `ParametreManager` | `/raider/parametres` | Settings plateforme + creds admin |
| `RetraitManager` | `/raider/retraits` | Approve/reject/payer retraits |

### 6.4 Shop (app/Livewire/Shop/)

| Component | Page | Description |
|-----------|------|-------------|
| `ShopPage` | `/shop/{vendeur}` | Forfaits, sélection, redirection paiement |

### 6.5 Shared Components (resources/views/components/)

| Composant | Description |
|-----------|-------------|
| `<x-navbar>` | Navbar responsive (vendor/admin variants) |
| `<x-mobile-nav>` | Menu mobile hamburger |
| `<x-footer>` | Footer avec branding Raider Corporation |
| `<x-theme-toggle>` | Bouton dark/light mode |
| `<x-confirm-modal>` | Modal de confirmation réutilisable |
| `<x-stat-card>` | Carte de statistiques |
| `<x-data-table>` | Table de données responsive |
| `<x-badge>` | Badge statut (success/warning/error/info) |
| `<x-alert>` | Alerte flash |

---

## PHASE 7 : Blade Layouts

| Layout | Fichier | Usage |
|--------|---------|-------|
| `app.blade.php` | `resources/views/layouts/app.blade.php` | Layout principal (vendor + admin) |
| `auth.blade.php` | `resources/views/layouts/auth.blade.php` | Pages de login/register |
| `public.blade.php` | `resources/views/layouts/public.blade.php` | Pages publiques (landing, shop, merci) |
| `admin.blade.php` | `resources/views/layouts/admin.blade.php` | Layout admin (extends app) |

---

## PHASE 8 : CSS & Design System

**Approche : Tailwind CSS + Alpine.js**

```bash
npm install -D tailwindcss @tailwindcss/forms postcss autoprefixer livewire/livewire
```

**Fichiers CSS à migrer :**

| CSS existant | Destination Laravel |
|-------------|---------------------|
| `assets/css/vendeur.css` | `resources/css/dashboard.css` → compilé via Vite |
| `assets/css/auth.css` | `resources/css/auth.css` → compilé via Vite |
| `assets/css/landing.css` | Abandonné (remplacé par Tailwind inline) |
| `index.php` (inline Tailwind) | `resources/views/pages/landing.blade.php` + config Tailwind |
| `shop.php` (inline CSS) | `resources/views/livewire/shop/shop-page.blade.php` + config dynamique |

**Améliorations à apporter :**
- Unifier la police (Inter partout)
- Unifier la couleur brand (`#10B981` / emerald-500)
- Système de design tokens via CSS variables Tailwind
- Dark mode : utiliser `darkMode: 'class'` dans `tailwind.config.js`

---

## PHASE 9 : Configuration & Environnement

**Fichier `.env` Laravel :**

```env
# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=paiement
DB_USERNAME=root
DB_PASSWORD=

# LigdiCash
LIGDICASH_API_KEY=...
LIGDICASH_API_TOKEN=...
LIGDICASH_BASE_URL=https://app.ligdicash.com/pay/v01/redirect/checkout-invoice

# Platform
PLATFORM_NAME="Wifi Pour Tous"
PLATFORM_CURRENCY=XOF
PLATFORM_COMMISSION_PCT=10

# Admin
ADMIN_EMAIL=admin@wifipourtous.com
ADMIN_PASSWORD=...

# MikroTik Encryption
MIKROTIK_ENC_KEY=...
MIKROTIK_ENC_IV=...
```

**Fichier `config/platform.php` :**

```php
return [
    'name' => env('PLATFORM_NAME', 'Wifi Pour Tous'),
    'currency' => env('PLATFORM_CURRENCY', 'XOF'),
    'commission_pct' => env('PLATFORM_COMMISSION_PCT', 10),
    'admin_email' => env('ADMIN_EMAIL'),
    'ligdicash' => [
        'api_key' => env('LIGDICASH_API_KEY'),
        'api_token' => env('LIGDICASH_API_TOKEN'),
        'base_url' => env('LIGDICASH_BASE_URL'),
    ],
    'mikrotik' => [
        'enc_key' => env('MIKROTIK_ENC_KEY'),
        'enc_iv' => env('MIKROTIK_ENC_IV'),
    ],
];
```

---

## PHASE 10 : Commands Artisan

| Commande | Description | Fréquence |
|----------|-------------|-----------|
| `mikrotik:sync` | Synchronise les users MikroTik pour tous les vendeurs actifs | Toutes les minutes (cron) |
| `platform:seed` | Seed les données admin + settings | Une fois |

```php
// app/Console/Commands/MikrotikSync.php
class MikrotikSync extends Command {
    protected $signature = 'mikrotik:sync';
    protected $description = 'Sync MikroTik hotspot users for all active vendors';

    public function handle(MikrotikService $mikrotik) {
        $configs = MikrotikConfig::where('polling_active', true)->get();
        foreach ($configs as $config) {
            $result = $mikrotik->cronSync($config->vendeur_id);
            $this->info("Vendor {$config->vendeur_id}: {$result['imported']} imported");
        }
    }
}
```

**Cron :**

```
* * * * * cd /path/to/project && php artisan mikrotik:sync >> /var/log/wpt_cron.log 2>&1
```

---

## PHASE 11 : Seeders

| Seeder | Contenu |
|--------|---------|
| `VendeurSeeder` | Crée le vendeur admin par défaut |
| `SettingSeeder` | Insert les 5 settings par défaut (plateforme_nom, devise, commission, admin_email, admin_pass_hash) |
| `ForfaitSeeder` | Forfaits par défaut (1h/5h/24h/3j/7j) |

---

## PHASE 12 : Testing

| Type | Outil | Portée |
|------|-------|--------|
| Unit Tests | PHPUnit | Services (LigdiCash, Mikrotik, Ticket, Encryption) |
| Feature Tests | PHPUnit | Auth flow, payment callback, API endpoints |
| Livewire Tests | Livewire Testing | Composants (CRUD forfaits, profil, retraits) |

---

## ORDRE D'IMPLÉMENTATION

| Étape | Module | Jours est. |
|-------|--------|------------|
| 1 | Setup Laravel + Migrations + Models + Seeders | 1-2j |
| 2 | Auth (vendeur + admin) + Layouts Blade | 1-2j |
| 3 | Services (LigdiCash, Mikrotik, Ticket, Encryption) | 2-3j |
| 4 | Vendor Dashboard + Tickets + Boutique + Profil | 3-4j |
| 5 | Shop publique + Flux paiement | 2j |
| 6 | MikroTik Config + Polling + API endpoints | 2-3j |
| 7 | Admin Dashboard + Vendeurs + Transactions | 2-3j |
| 8 | Admin Tickets + Boutique + Parametres + Retraits | 2-3j |
| 9 | Pages publiques (merci, annule, récupération, contact) | 1j |
| 10 | CSS/Design unifié + Dark mode | 1-2j |
| 11 | Tests | 2j |
| **Total** | | **18-26 jours** |

---

## BUGS À CORRIGER pendant la migration

1. **Admin password en clair** → Utiliser `Hash::make()` et `Hash::check()`
2. **`traite_par = 0` hardcodé** → Utiliser `Auth::id()` ou ID admin
3. **Pas de pagination** → Ajouter `->paginate()` sur les listes
4. **Recherche vendeurs bug** (perte du filtre admin email) → Corriger la logique de requête
5. **Double inclusion `theme-toggle.php`** dans `retraits.php` → Éviter avec les layouts
6. **Font Awesome version mismatch** → Unifier sur FA 6.4.0+
