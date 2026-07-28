# Plan d'Integration Complet — MikroTik + VPN WifiPourTous

**Projet:** Wifi Pour Tous (hotspot_sass_laravel)
**Date:** 2026-07-16
**Statut:** EN ATTENTE D'APPROBATION

---

## Table des matieres

1. Resume executeif
2. Etat actuel du codebase
3. Phase 1 — Base de donnees & Models
4. Phase 2 — Services Core
5. Phase 3 — VPN WifiPourTous
6. Phase 4 — Routes API
7. Phase 5 — UI Vendeur
8. Phase 6 — Artisan Commands
9. Phase 7 — Nettoyage & Finalisation
10. Fichiers a creer
11. Dependances & Configuration
12. Estimation de travail

---

## 1. Resume executeif

L'objectif est de connecter les routeurs MikroTik des vendeurs a la plateforme Laravel pour :
- **Creer automatiquement** les users hotspot quand un ticket est vendu
- **Synchroniser** les tickets entre la plateforme et le MikroTik
- **Offrir un VPN WireGuard** (WifiPourTous) pour acceder a distance aux routeurs sans IP publique
- **Monitorer** l'etat de connexion des routeurs

L'integration supporte RouterOS v6 (Socket API) et v7 (REST API) avec detection automatique.

---

## 2. Etat actuel du codebase

### Ce qui existe

| Composant | Fichier | Statut |
|---|---|---|
| Import CSV tickets | MikrotikConfig.php (Livewire, 46 lignes) | Fonctionnel mais basique |
| Walled Garden script | WalledGarden.php | Fonctionnel (copier-coller) |
| Chiffrement .env | MIKROTIK_ENC_KEY, MIKROTIK_ENC_IV | Definis, jamais utilises |
| Champ mikrotik_id | Migration ticket | Existe, jamais rempli |
| source = mikrotik | Enum ticket | Existe, jamais utilise |

### Ce qui manque (tout le reste)

| Composant | Statut |
|---|---|
| Migration mikrotik_config | NON EXISTANT |
| Model MikrotikConfig | NON EXISTANT |
| MikrotikService.php | NON EXISTANT |
| MikrotikRestClient.php (v7) | NON EXISTANT |
| MikrotikRos6/Client.php (v6) | NON EXISTANT |
| EncryptionService.php | NON EXISTANT |
| MikrotikApiController.php | NON EXISTANT |
| MikrotikPollController.php | NON EXISTANT |
| Routes API MikroTik | 0 routes (9 documentees) |
| MikrotikSync.php (Artisan) | NON EXISTANT |
| Migration vpn_config | NON EXISTANT |
| Model VpnConfig | NON EXISTANT |
| VpnService.php | NON EXISTANT |
| VpnController.php | NON EXISTANT |
| Systeme de credits VPN | NON EXISTANT |
| Template CSV/Excel API | LIEN MORT (route 404) |

---

## 3. Phase 1 — Base de donnees & Models

### 3.1 Migration : create_mikrotik_config_table.php

Schema::create('mikrotik_config', function (Blueprint $table) {
    $table->id();
    $table->foreignId('vendeur_id')->constrained()->cascadeOnDelete();
    $table->string('ip_router');
    $table->string('nom_routeur')->nullable();
    $table->integer('api_port')->default(443);
    $table->string('api_user');
    $table->text('api_pass');              // Chiffre AES
    $table->enum('routeros_version', ['6', '7'])->nullable();
    $table->enum('statut', ['connecte', 'deconnecte', 'erreur'])->default('deconnecte');
    $table->text('last_error')->nullable();
    $table->timestamp('last_sync')->nullable();
    $table->string('polling_secret', 64);
    $table->boolean('polling_active')->default(false);
    $table->timestamp('polling_last_check')->nullable();
    $table->integer('polling_last_count')->default(0);
    $table->timestamps();
    $table->unique('vendeur_id');
});

### 3.2 Migration : create_vpn_config_table.php

Schema::create('vpn_config', function (Blueprint $table) {
    $table->id();
    $table->foreignId('vendeur_id')->constrained()->cascadeOnDelete();
    $table->string('zone_name');
    $table->string('subnet');
    $table->enum('duration', ['1m', '3m', '6m', '1an']);
    $table->enum('status', ['pending', 'active', 'expired'])->default('pending');
    $table->string('vpn_ip');
    $table->text('public_key');
    $table->text('private_key_enc');
    $table->string('server_endpoint');
    $table->text('rsc_script')->nullable();
    $table->text('wg_config')->nullable();
    $table->string('qr_code_path')->nullable();
    $table->timestamp('activated_at')->nullable();
    $table->timestamp('expires_at');
    $table->timestamp('last_handshake')->nullable();
    $table->timestamps();
});

### 3.3 Migration : create_vpn_credits_tables.php

Schema::create('vpn_credits', function (Blueprint $table) {
    $table->id();
    $table->foreignId('vendeur_id')->constrained()->cascadeOnDelete();
    $table->integer('solde')->default(0);
    $table->timestamps();
});

Schema::create('vpn_credit_transactions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('vendeur_id')->constrained()->cascadeOnDelete();
    $table->enum('type', ['achat', 'debit']);
    $table->integer('montant');
    $table->string('description')->nullable();
    $table->timestamps();
});

### 3.4 Models

**app/Models/MikrotikConfig.php**
- fillable: ip_router, api_port, api_user, api_pass, routeros_version, nom_routeur
- casts: api_pass -> encrypted, polling_active -> boolean
- belongsTo(Vendeur::class)
- scopeByStatut($query, $statut)

**app/Models/VpnConfig.php**
- fillable: zone_name, subnet, duration
- casts: private_key_enc -> encrypted, expires_at -> datetime
- belongsTo(Vendeur::class)
- scopeActive($query), scopeExpired($query)

---

## 4. Phase 2 — Services Core

### 4.1 app/Services/EncryptionService.php

Utilise les variables .env MIKROTIK_ENC_KEY et MIKROTIK_ENC_IV.

Methods:
  encrypt(string $plaintext): string    // AES-128-CBC -> base64
  decrypt(string $ciphertext): string   // base64 -> AES-128-CBC -> plaintext

### 4.2 app/Services/MikrotikRestClient.php

Client HTTP REST pour RouterOS v7. Zero dependance externe (PHP pur).

Methods:
  connect(host, user, pass, port=443, verifySsl=false)
  get(path, params): array
  put(path, data): array
  patch(path, data): array
  del(path): array
  disconnect()
  isAlive(): bool

Retry: 3 tentatives avec delai de 2s.
Timeout: 30s par defaut, configurable.
Erreurs: Gestion speciale pour 401, 403, 404, 429, 500.

### 4.3 app/Services/MikrotikRos6/Client.php

Client Socket API pour RouterOS v6. PHP pur.

Methods:
  connect(host, user, pass, port=8728)
  write(commands): void
  read(): array
  close()
  query(command, params): array

Auth: MD5 challenge-response (pre-v6.43) + login clair (post-v6.43).

### 4.4 app/Services/MikrotikService.php

Service principal.

Methods:
  detectVersion(ip, port, user, pass): '6'|'7'|null
  testConnection(config): array
  preflightCheck(ip, port): array
  createHotspotUser(config, user, pass, profile): array
  deleteHotspotUser(config, mikrotikId): bool
  listHotspotUsers(config): array
  listActiveHotspotUsers(config): array
  createHotspotProfile(config, name, rateLimit, sessionTimeout): array
  syncFromRouter(config): array
  pushUsers(config, users): array
  cronSync(): array
  generatePollScript(config): string
  healthCheckAll(): array
  isAlive(config): bool

### 4.5 config/mikrotik.php

- api_timeout: 30
- api_retries: 3
- default_api_port_v6: 8728
- default_api_port_v7: 443
- polling_interval: 60
- vpn.server_host, vpn.server_port, vpn.ip_pool_start/end, vpn.default_dns

---

## 5. Phase 3 — VPN WifiPourTous

### 5.1 app/Services/VpnService.php

Methods:
  createVpn(vendeur, zoneName, subnet, duration): VpnConfig
  generateWireGuardKeys(): array
  assignVpnIp(subnet): string
  generateRscScript(vpn): string
  generateWgConfig(vpn): string
  generateQrCode(wgConfig, path): string
  renewVpn(vpn, duration): VpnConfig
  checkExpired(): int
  getVpnStatus(vpn): string
  getBalance(vendeur): int
  debitCredits(vendeur, amount, description): bool
  addCredits(vendeur, amount, description): bool

### 5.2 Script .rsc genere

- /interface wireguard add name="wg-client-{zone}"
- /interface wireguard peers add (endpoint, public-key, allowed-address)
- /ip address add address="{vpn_ip}/24"
- /ip route add dst-address="10.8.0.0/24"

### 5.3 Credits VPN

| Duree | Prix | Credits |
|---|---|---|
| 1 mois | 700 XOF | 700 |
| 3 mois | 2 000 XOF | 2 000 |
| 6 mois | 3 500 XOF | 3 500 |
| 1 an | 6 500 XOF | 6 500 |

---

## 6. Phase 4 — Routes API

### 6.1 Routes MikroTik (routes/api.php)

POST /api/mikrotik/test         — Test connexion
POST /api/mikrotik/detect       — Detection version
GET  /api/mikrotik/poll         — Polling (MikroTik -> plateforme)
POST /api/mikrotik/push-users   — Push users depuis MikroTik
GET  /api/mikrotik/template     — Download template CSV/Excel
POST /api/mikrotik/poll-confirm — Confirmation sync
POST /api/mikrotik/cron-sync    — Sync cron

### 6.2 Routes VPN (routes/api.php)

GET  /api/vpn/poll              — Polling VPN
POST /api/vpn/push-status       — Status VPN

### 6.3 Routes Web (ajout)

GET /vendeur/vpn                — Page VPN vendeur

### 6.4 Authentification polling

Le MikroTik envoie polling_secret dans les headers. La plateforme verifie le secret et associe a la config.

---

## 7. Phase 5 — UI Vendeur

### 7.1 Composant Livewire MikrotikConfig.php (refonte)

Le composant actuel (46 lignes) sera remplace par un composant complet (249 lignes) avec 5 onglets.

### 7.2 Structure de la page

- Onglet 1: Configuration (IP, port, login, mdp, detect, test, save)
- Onglet 2: Test & Statut (badge connecte, derniere sync, nb users)
- Onglet 3: Synchro Auto (activation, script .rsc, scheduler)
- Onglet 4: VPN WifiPourTous (credits, creation, script .rsc, .conf, QR)
- Onglet 5: Import & Tickets (template CSV/Excel, import fichier)

---

## 8. Phase 6 — Artisan Commands

php artisan mikrotik:sync    — Sync periodique de tous les MikroTik actifs
php artisan mikrotik:health  — Health check de tous les routeurs
php artisan vpn:expire       — Verification expirations VPN

---

## 9. Phase 7 — Nettoyage & Finalisation

- Corriger les liens template CSV/Excel casses
- Utiliser mikrotik_id sur les tickets (jamais rempli)
- Utiliser source = mikrotik pour les tickets sync
- Ajouter lien VPN au sidebar vendeur

---

## 10. Fichiers a creer

### Services (6 fichiers)

| Fichier | Lignes |
|---|---|
| app/Services/EncryptionService.php | ~40 |
| app/Services/MikrotikRestClient.php | ~130 |
| app/Services/MikrotikRos6/Client.php | ~180 |
| app/Services/MikrotikService.php | ~480 |
| app/Services/MikrotikRos6/MikrotikException.php | ~15 |
| app/Services/VpnService.php | ~300 |

### Models (2 fichiers)

| Fichier | Lignes |
|---|---|
| app/Models/MikrotikConfig.php | ~50 |
| app/Models/VpnConfig.php | ~50 |

### Controllers (4 fichiers)

| Fichier | Lignes |
|---|---|
| app/Http/Controllers/Api/MikrotikApiController.php | ~200 |
| app/Http/Controllers/Api/MikrotikPollController.php | ~100 |
| app/Http/Controllers/Api/VpnApiController.php | ~80 |
| app/Http/Controllers/VpnController.php | ~150 |

### Livewire (1 fichier modifie)

| Fichier | Lignes |
|---|---|
| app/Http/Livewire/Vendor/MikrotikConfig.php | ~250 (remplace 46) |

### Artisan (3 fichiers)

| Fichier | Lignes |
|---|---|
| app/Console/Commands/MikrotikSync.php | ~100 |
| app/Console/Commands/MikrotikHealth.php | ~60 |
| app/Console/Commands/VpnExpire.php | ~40 |

### Migrations (3 fichiers)

- 2026_07_16_000001_create_mikrotik_config_table.php
- 2026_07_16_000002_create_vpn_config_table.php
- 2026_07_16_000003_create_vpn_credits_tables.php

### Vues (2 fichiers)

| Fichier | Lignes |
|---|---|
| resources/views/livewire/vendor/mikrotik-config.blade.php | ~438 (remplace 56) |
| resources/views/vendor/vpn.blade.php | ~6 |

### Config (1 fichier)

- config/mikrotik.php (~25 lignes)

### Fichiers modifies

- routes/api.php (+9 routes)
- routes/web.php (+1 route)
- .env (+variables)
- components/sidebar-vendor.blade.php (+lien VPN)
- TicketService.php (mikrotik_id + source)

**Total: ~26 fichiers, ~2900 lignes**

---

## 11. Dependances & Configuration

### Packages composer

Aucun package externe requis. Tout est PHP pur.

### Variables .env a ajouter

MIKROTIK_API_TIMEOUT=30
MIKROTIK_API_RETRIES=3
MIKROTIK_POLLING_INTERVAL=60
VPN_SERVER_HOST=vpn.wifipourtous.com
VPN_SERVER_PORT=51820
VPN_IP_POOL_START=10.8.0.2
VPN_IP_POOL_END=10.8.0.254
VPN_DEFAULT_DNS=1.1.1.1

---

## 12. Estimation de travail

| Phase | Complexite | Fichiers | Lignes |
|---|---|---|---|
| Phase 1 — DB & Models | Faible | 5 | ~220 |
| Phase 2 — Services Core | Elevee | 6 | ~1020 |
| Phase 3 — VPN | Elevee | 2 | ~350 |
| Phase 4 — Routes API | Moyenne | 3 | ~380 |
| Phase 5 — UI Vendeur | Moyenne | 2 | ~694 |
| Phase 6 — Artisan | Faible | 3 | ~200 |
| Phase 7 — Nettoyage | Faible | 5 modif | ~50 |
| **TOTAL** | | **~26 fichiers** | **~2900 lignes** |

---

## Ordre d'implementation recommande

1. Phase 1 (DB) — Pre-requis pour tout le reste
2. Phase 2 (Services) — Le coeur de l'integration
3. Phase 4 (Routes API) — Permet de tester les services
4. Phase 5 (UI) — Interface vendeur
5. Phase 3 (VPN) — Peut etre fait en parallele de la Phase 5
6. Phase 6 (Artisan) — Automatisation
7. Phase 7 (Nettoyage) — Finalisation
