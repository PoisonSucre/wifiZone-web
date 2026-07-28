# TODO — Suite de la Migration Laravel

## ÉTAT ACTUEL

Le projet Laravel est fonctionnel avec :
- ✅ 8 Migrations + Seeders
- ✅ 8 Models avec relations/scopes
- ✅ 5 Services (Encryption, LigdiCash, MikrotikRestClient, MikrotikService, TicketService)
- ✅ 2 Middleware (EnsureVendeurIsActive, EnsureAdmin)
- ✅ 18 Contrôleurs (Auth, Admin, Vendor, Api)
- ✅ 53 Routes (web + api)
- ✅ 31 Blade Views (layouts, components, auth, vendor, admin, pages, shop)
- ✅ 3 Livewire Components créés (Dashboard, TicketList, BoutiqueManager)
- ✅ 1 Artisan Command (MikrotikSync)
- ✅ Config platform.php + .env

---

## LIVewire COMPONENTS À CRÉER

### Vendor (app/Http/Livewire/Vendor/)

| Composant | Fichier | Description | Priorité |
|-----------|---------|-------------|----------|
| ✅ Dashboard | `Dashboard.php` | Stats, chart, ventes récentes | — |
| ✅ TicketList | `TicketList.php` | Liste, filtres, recherche, toggle password | — |
| ✅ BoutiqueManager | `BoutiqueManager.php` | CRUD forfaits, couleur, logo, message | — |
| ❌ **ProfilEditor** | `ProfilEditor.php` | Édition profil + mot de passe | **Haute** |
| ❌ **RetraitManager** | `RetraitManager.php` | Demande retrait, historique, calcul commission live | **Haute** |
| ❌ **MikrotikConfig** | `MikrotikConfig.php` | Config connexion, test, polling, sync, import CSV | **Haute** |
| ❌ **WalledGarden** | `WalledGarden.php` | Affichage script (lecture seule, peut rester Blade) | Basse |

### Admin (app/Http/Livewire/Admin/)

| Composant | Fichier | Description | Priorité |
|-----------|---------|-------------|----------|
| ❌ **Dashboard** | `Dashboard.php` | Stats globales, derniers vendeurs/transactions | **Haute** |
| ❌ **VendeurManager** | `VendeurManager.php` | CRUD vendeurs, commission, boutique, forfaits | **Haute** |
| ❌ **TransactionList** | `TransactionList.php` | Liste filtrable par vendeur/statut | **Haute** |
| ❌ **TicketList** | `TicketList.php` | Liste filtrable, password toggle | **Haute** |
| ❌ **TicketCreator** | `TicketCreator.php` | Création unitaire + batch (500 max) | **Haute** |
| ❌ **ParametreManager** | `ParametreManager.php` | Settings plateforme + creds admin | **Moyenne** |
| ❌ **RetraitManager** | `RetraitManager.php` | Approve/reject/payer retraits | **Haute** |

### Auth (app/Http/Livewire/Auth/)

| Composant | Fichier | Description | Priorité |
|-----------|---------|-------------|----------|
| ❌ **RegisterForm** | `RegisterForm.php` | Formulaire 3 étapes | **Moyenne** |
| ❌ **LoginForm** | `LoginForm.php` | Email + password, rate limiting | **Moyenne** |

### Shop (app/Http/Livewire/Shop/)

| Composant | Fichier | Description | Priorité |
|-----------|---------|-------------|----------|
| ❌ **ShopPage** | `ShopPage.php` | Forfaits dynamiques, sélection, redirection paiement | **Haute** |

---

## VUES LIVEWIRE À CRÉER

Chaque composant Livewire a besoin d'une vue Blade dans `resources/views/livewire/` :

### Vendor
| Vue | Fichier |
|-----|---------|
| ✅ Dashboard | `livewire/vendor/dashboard.blade.php` |
| ✅ TicketList | `livewire/vendor/ticket-list.blade.php` |
| ✅ BoutiqueManager | `livewire/vendor/boutique-manager.blade.php` |
| ❌ ProfilEditor | `livewire/vendor/profil-editor.blade.php` |
| ❌ RetraitManager | `livewire/vendor/retrait-manager.blade.php` |
| ❌ MikrotikConfig | `livewire/vendor/mikrotik-config.blade.php` |
| ❌ WalledGarden | `livewire/vendor/walled-garden.blade.php` |

### Admin
| Vue | Fichier |
|-----|---------|
| ❌ Dashboard | `livewire/admin/dashboard.blade.php` |
| ❌ VendeurManager | `livewire/admin/vendeur-manager.blade.php` |
| ❌ TransactionList | `livewire/admin/transaction-list.blade.php` |
| ❌ TicketList | `livewire/admin/ticket-list.blade.php` |
| ❌ TicketCreator | `livewire/admin/ticket-creator.blade.php` |
| ❌ ParametreManager | `livewire/admin/parametre-manager.blade.php` |
| ❌ RetraitManager | `livewire/admin/retrait-manager.blade.php` |

### Auth
| Vue | Fichier |
|-----|---------|
| ❌ RegisterForm | `livewire/auth/register-form.blade.php` |
| ❌ LoginForm | `livewire/auth/login-form.blade.php` |

### Shop
| Vue | Fichier |
|-----|---------|
| ❌ ShopPage | `livewire/shop/shop-page.blade.php` |

---

## VUES BLADE À METTRE À JOUR

Les vues Blade existantes doivent être remplacées par des vues Livewire :

| Vue actuelle | Remplacement |
|-------------|--------------|
| `vendor/dashboard.blade.php` | Remplacer le contenu par `@livewire('vendor.dashboard')` |
| `vendor/tickets.blade.php` | Remplacer le contenu par `@livewire('vendor.ticket-list')` |
| `vendor/boutique.blade.php` | Remplacer le contenu par `@livewire('vendor.boutique-manager')` |
| `vendor/profil.blade.php` | Remplacer le contenu par `@livewire('vendor.profil-editor')` |
| `vendor/mikrotik.blade.php` | Remplacer le contenu par `@livewire('vendor.mikrotik-config')` |
| `vendor/retraits.blade.php` | Remplacer le contenu par `@livewire('vendor.retrait-manager')` |
| `admin/dashboard.blade.php` | Remplacer le contenu par `@livewire('admin.dashboard')` |
| `admin/vendeurs.blade.php` | Remplacer le contenu par `@livewire('admin.vendeur-manager')` |
| `admin/transactions.blade.php` | Remplacer le contenu par `@livewire('admin.transaction-list')` |
| `admin/tickets.blade.php` | Remplacer le contenu par `@livewire('admin.ticket-list')` |
| `admin/ajouter-ticket.blade.php` | Remplacer le contenu par `@livewire('admin.ticket-creator')` |
| `admin/parametres.blade.php` | Remplacer le contenu par `@livewire('admin.parametre-manager')` |
| `admin/retraits.blade.php` | Remplacer le contenu par `@livewire('admin.retrait-manager')` |
| `auth/login.blade.php` | Remplacer le contenu par `@livewire('auth.login-form')` |
| `auth/register.blade.php` | Remplacer le contenu par `@livewire('auth.register-form')` |
| `shop/show.blade.php` | Remplacer le contenu par `@livewire('shop.shop-page', ['id' => $id])` |

---

## ROUTES À AJOUTER

Ajouter les routes Livewire dans `routes/web.php` (remplacer les contrôleurs existants) :

```php
// Vendor - remplacer les contrôleurs par Livewire
Route::middleware(['auth', 'vendeur.status'])->prefix('vendeur')->name('vendor.')->group(function () {
    Route::get('/', fn () => view('vendor.dashboard'))->name('dashboard');
    Route::get('/tickets', fn () => view('vendor.tickets'))->name('tickets');
    Route::get('/boutique', fn () => view('vendor.boutique'))->name('boutique');
    Route::get('/profil', fn () => view('vendor.profil'))->name('profil');
    Route::get('/mikrotik', fn () => view('vendor.mikrotik'))->name('mikrotik');
    Route::get('/walled-garden', fn () => view('vendor.walled-garden'))->name('walled-garden');
    Route::get('/retraits', fn () => view('vendor.retraits'))->name('retraits');
});

// Admin - remplacer les contrôleurs par Livewire
Route::middleware(['auth:admin', 'admin'])->prefix('raider')->name('admin.')->group(function () {
    Route::get('/', fn () => view('admin.dashboard'))->name('dashboard');
    Route::get('/vendeurs', fn () => view('admin.vendeurs'))->name('vendeurs');
    Route::get('/transactions', fn () => view('admin.transactions'))->name('transactions');
    Route::get('/tickets', fn () => view('admin.tickets'))->name('tickets');
    Route::get('/ajouter-ticket', fn () => view('admin.ajouter-ticket'))->name('tickets.create');
    Route::get('/boutique', fn () => view('admin.boutique'))->name('boutique');
    Route::get('/parametres', fn () => view('admin.parametres'))->name('parametres');
    Route::get('/retraits', fn () => view('admin.retraits'))->name('retraits');
});
```

---

## BUGS À CORRIGER

1. **AdminParametresController** — Ajouter `use Illuminate\Support\Facades\Hash;` (déjà corrigé ✅)
2. **Admin password en clair** — Le login admin compare en clair. Amélioration : hacher avec bcrypt et utiliser `Hash::check()`
3. **Pas de pagination** — Les listes admin (transactions, tickets) sont limitées à 200/500 sans paginate()
4. **`traite_par = 0`** hardcodé dans les retraits admin → utiliser `Auth::id()`
5. **Double theme-toggle** — Les layouts Laravel gèrent ça, pas de problème
6. **Font Awesome mismatch** — Unifier sur FA 6.4.0 dans tout le projet

---

## SERVICES À COMPLÉTER

| Service | Fichier | Ce qui manque |
|---------|---------|---------------|
| MikrotikService | `app/Services/MikrotikService.php` | Le `syncFromRouter()` doit déchiffrer le mot de passe via `EncryptionService` avant de se connecter — déjà fait ✅ |
| TicketService | `app/Services/TicketService.php` | `generateBatch()` doit être connecté au contrôleur admin `AdminTicketsController` — déjà fait ✅ |
| LigdiCashService | `app/Services/LigdiCashService.php` | Tester en conditions réelles avec les credentials LigdiCash |
| EncryptionService | `app/Services/EncryptionService.php` | Fonctionnel ✅ |

---

## TESTS À ÉCRIRE

| Type | Fichier | Portée |
|------|---------|--------|
| Unit | `tests/Unit/Services/EncryptionServiceTest.php` | encrypt/decrypt roundtrip |
| Unit | `tests/Unit/Services/TicketServiceTest.php` | assignTicket, importFromCsv, generateBatch |
| Feature | `tests/Feature/Auth/LoginTest.php` | Login vendeur + admin |
| Feature | `tests/Feature/Auth/RegisterTest.php` | Inscription 3 étapes |
| Feature | `tests/Feature/Payment/PaymentFlowTest.php` | Process + callback |
| Feature | `tests/Feature/Vendor/DashboardTest.php` | Stats, accès |
| Feature | `tests/Feature/Admin/VendeursTest.php` | CRUD vendeurs |
| Livewire | `tests/Feature/Livewire/Vendor/BoutiqueManagerTest.php` | CRUD forfaits |
| Livewire | `tests/Feature/Livewire/Vendor/RetraitManagerTest.php` | Demande retrait |

---

## ORDRE D'IMPLÉMENTATION RECOMMANDÉ

| # | Tâche | Temps est. |
|---|-------|------------|
| 1 | Créer les 14 composants Livewire restants | 3-4j |
| 2 | Créer les 14 vues Livewire | 2-3j |
| 3 | Mettre à jour les vues Blade existantes | 0.5j |
| 4 | Mettre à jour les routes web.php | 0.5j |
| 5 | Corriger les 6 bugs listés | 1j |
| 6 | Écrire les 9 tests | 2j |
| **Total** | | **9-11 jours** |
