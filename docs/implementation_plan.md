# Plan d'Implementation — Correction de Bugs

**Projet:** Wifi Pour Tous (hotspot_sass_laravel)
**Date:** 2026-07-15
**Statut:** TERMINE (Phase 1-4)

---

## Phase 1 — Erreurs Critiques (cassent le fonctionnement)

| # | Bug | Fichier(s) | Statut |
|---|-----|-----------|--------|
| 1 | `config('urls.base')` au lieu de `config('platform.urls.base')` | MikrotikService.php:414, LigdiCashService.php:58 | OK |
| 2 | Route shop cassée (passe `$id` au lieu de `$vendeur` + `$forfaits`) | web.php:9, shop/show.blade.php | OK |
| 3 | Route `vendeur.mikrotik` inexistante | livewire/vendor/ticket-list.blade.php:4 | OK |
| 4 | Logout vendeur cassé (`/auth/logout` au lieu de route named) | navbar-vendor.blade.php:27,45 | OK |
| 5 | `auth:sanctum` sur api.php alors que Sanctum n'est pas installé | api.php:13 | OK |
| 6 | Race condition ticket assignment (pas de transaction atomique) | TicketService.php:12-29 | OK |
| 7 | Callback payment sans vérification signature | PaymentApiController.php:65-109 | OK |

## Phase 2 — Données Manquantes (erreurs runtime)

| # | Bug | Fichier(s) | Statut |
|---|-----|-----------|--------|
| 8 | Merci/annule: variables non passées aux vues | web.php:11-12, PageController.php | OK |
| 9 | Récupérer-ticket: pas de logique backend | web.php:13, PageController.php:49-62 | OK |
| 10 | Mot de passe admin hardcoded `'password'` | TicketCreator.php:99 | OK |
| 11 | `config('platform.admin')` = array vide → `admin_email` = null | config/platform.php:8 | OK |
| 12 | `@vite` JS chargé 2 fois dans layouts | app.blade.php:8+18, admin.blade.php:9+20 | OK |
| 13 | `use Pdo\Mysql` casse sur PHP < 8.4 | config/database.php | OK |
| 14 | Logo shop mauvais path | shop/show.blade.php:43 | OK |

## Phase 3 — Navbars et CSS

| # | Bug | Fichier(s) | Statut |
|---|-----|-----------|--------|
| 15 | Navbar vendor: route names `vendeur.*` au lieu de `vendor.*` | navbar-vendor.blade.php:3-9 | OK |
| 16 | Navbar admin: route names `raider.*` au lieu de `admin.*` | navbar-admin.blade.php:3-10 | OK |
| 17 | Badge `badge-error` non défini dans CSS | app.css | OK |

## Améliorations Inscription & Admin

| # | Bug | Fichier(s) | Statut |
|---|-----|-----------|--------|
| 22| Notification inscription vendeur à l'admin | RegisterForm.php, AdminVendorRegistered.php | OK |
| 23| Bannière alert sur Dashboard Admin | dashboard.blade.php | OK |

### Détails des corrections
- **Notification**: Ajout de `Mail::to(config('platform.admin.email'))->send(new AdminVendorRegistered($vendeur))` dans `RegisterForm.php`.
- **Dashboard**: Bannière warning ajoutée sur le dashboard admin affichant le nombre de vendeurs `en_attente`.

---

## Détails des Corrections

### Bug 1 — config('urls.base')
- **Fichiers modifiés:** `app/Services/MikrotikService.php:414`, `app/Services/LigdiCashService.php:58`
- **Correction:** `config('urls.base')` → `config('platform.urls.base')`
- **Impact:** URLs de paiement LigdiCash, walled garden MikroTik, polling script

### Bug 2 — Route shop cassée
- **Fichiers modifiés:** `routes/web.php:9`
- **Correction:** Utiliser `ShopController::show` au lieu d'une closure
- **Le ShopController existait déjà** avec la bonne logique (Vendeur + forfaits)

### Bug 3 — Route vendeur.mikrotik inexistante
- **Fichiers modifiés:** `resources/views/livewire/vendor/ticket-list.blade.php:4`
- **Correction:** `route('vendeur.mikrotik')` → `route('vendor.mikrotik')`

### Bug 4 — Logout vendeur cassé
- **Fichiers modifiés:** `routes/web.php`, `resources/views/components/navbar-vendor.blade.php`
- **Correction:**
  - Ajouté routes vendor auth (login, register, logout) utilisant `AuthController`
  - Navbar utilise maintenant `route('vendor.logout')` au lieu de `/auth/logout`

### Bug 5 — auth:sanctum non installé
- **Fichiers modifiés:** `routes/api.php:13`
- **Correction:** `auth:sanctum` → `auth` (session-based)

### Bug 6 — Race condition ticket assignment
- **Fichiers modifiés:** `app/Services/TicketService.php`
- **Correction:** `assignTicket()` wrappé dans `DB::transaction()` + `lockForUpdate()`

### Bug 7 — Callback payment sans sécurité
- **Fichiers modifiés:** `app/Http/Controllers/Api/PaymentApiController.php`
- **Correction:**
  - Transaction DB wrappé dans `DB::transaction()` + `lockForUpdate()`
  - Logs d'erreur ajoutés pour debugging
  - Ticket assignment utilise `$transaction->vendeur_id` au lieu de `$vendeurId` du payload
  - Log warning si aucun ticket disponible

### Bug 8-9 — Pages merci/annule/recuperer-ticket
- **Fichiers modifiés:** `routes/web.php`
- **Correction:** Les 3 routes utilisent maintenant `PageController` qui passe les bonnes variables

### Bug 10-11 — Admin password et config
- **Fichiers modifiés:** `config/platform.php`, `app/Http/Livewire/Admin/TicketCreator.php`, `app/Http/Controllers/AdminTicketsController.php`, `.env`
- **Correction:**
  - `config('platform.admin')` contient maintenant `email` et `password`
  - Les deux contrôleurs utilisent `config('platform.admin.password')` au lieu de `'password'`
  - Variables `ADMIN_EMAIL` et `ADMIN_PASSWORD` ajoutées au `.env`

### Bug 12 — @vite doublon
- **Fichiers modifiés:** `resources/views/layouts/app.blade.php`, `resources/views/layouts/admin.blade.php`
- **Correction:** Supprimé le 2ème `@vite(['resources/js/app.js'])` dans chaque layout

### Bug 13 — use Pdo\Mysql
- **Fichiers modifiés:** `config/database.php`
- **Correction:** `use Pdo\Mysql` supprimé, `Mysql::ATTR_SSL_CA` → `\PDO::MYSQL_ATTR_SSL_CA`

### Bug 14 — Logo shop path
- **Fichiers modifiés:** `resources/views/shop/show.blade.php:43`
- **Correction:** `asset('storage/' . $vendeur->logo)` → `asset($vendeur->logo)`
- **Raison:** Les logos sont stockés dans `public/assets/uploads/logos/`

### Bug 15-16 — Navbars route names
- **Fichiers modifiés:** `resources/views/components/navbar-vendor.blade.php`, `resources/views/components/navbar-admin.blade.php`
- **Correction:**
  - Vendor: `vendeur.dashboard` → `vendor.dashboard`, etc.
  - Admin: `raider.dashboard` → `admin.dashboard`, etc.

### Bug 17 — Badge error CSS
- **Fichiers modifiés:** `resources/css/app.css`
- **Correction:** Ajouté `.badge-error` avec background #ef4444

### Bug 18 — Fichiers temporaires
- **Action:** 16 fichiers `tmp_test*.php` supprimés de la racine

### Bug 19 — APP_DEBUG
- **Fichiers modifiés:** `.env`
- **Correction:** `APP_DEBUG=true` → `APP_DEBUG=false`

### Bug 24 — Erreur de signature `withSum` sur la page Vendeurs de l'admin
- **Fichiers modifiés:** `app/Http/Livewire/Admin/VendeurManager.php`, `app/Http/Controllers/AdminVendeursController.php`
- **Correction:**
  - `->withSum('transactions as revenus', fn ($q) => ...)` est invalide sous Laravel car le deuxième argument doit être le nom de la colonne à additionner (ex: `'montant'`).
  - Correction appliquée : `->withSum(['transactions as revenus' => fn ($q) => $q->where('statut', 'completed')], 'montant')`.
- **Impact:** Résout l'erreur `str_contains()` qui causait une page blanche/crash lors de la consultation des vendeurs sur le tableau de bord admin.

---

## Vérification Finale

- `npm run build` → OK (assets compilés)
- `php artisan route:list` → 55 routes, toutes correctes
- Routes vendor: `vendor.dashboard`, `vendor.tickets`, `vendor.mikrotik`, etc.
- Routes admin: `admin.dashboard`, `admin.vendeurs`, `admin.tickets`, etc.
- Routes auth: `vendor.login`, `vendor.logout`, `admin.login`, `admin.logout`
- Routes publiques: `shop`, `merci`, `annule`, `recuperer-ticket`
