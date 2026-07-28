# PLAN DE CORRECTION DES LENTEURS

## Diagnostic — 3 causes racines

| Cause | Impact | Pages concernées |
|-------|--------|------------------|
| **A — N+1 queries + boucles SQL** | 87 requêtes/dashboard | Admin Dashboard, Vendor Dashboard, Revenus-Détails, VendeurManager |
| **B — Emails synchrones** | Bloque la requête HTTP (3 SMTP/appel) | Toute page qui envoie une notification |
| **C — Aucun index DB** | Full table scan partout | Toutes les pages listes/recherche |

---

## PHASE 1 — DB Indexes (risque faible, impact immédiat)

Migration unique : `database/migrations/xxxx_xx_xx_xxxxxx_add_performance_indexes.php`

### Index à créer

| Table | Index | Colonnes |
|-------|-------|----------|
| `vendeurs` | `idx_vendeurs_statut` | `statut` |
| `vendeurs` | `idx_vendeurs_is_admin` | `is_admin` |
| `vendeurs` | `idx_vendeurs_date_inscription` | `date_inscription` |
| `ticket` | `idx_ticket_status` | `status` |
| `ticket` | `idx_ticket_date_creation` | `date_creation` |
| `ticket` | `idx_ticket_forfait` | `forfait` |
| `ticket` | `idx_ticket_token` | `token` |
| `ticket` | `idx_ticket_vendeur_id` | `vendeur_id` |
| `transactions` | `idx_transactions_statut` | `statut` |
| `transactions` | `idx_transactions_date_creation` | `date_creation` |
| `transactions` | `idx_transactions_vendeur_id` | `vendeur_id` |
| `transactions` | `idx_transactions_transaction_id` | `transaction_id` |
| `transactions` | `idx_transactions_token` | `token` |
| `retraits` | `idx_retraits_statut` | `statut` |
| `retraits` | `idx_retraits_date_creation` | `date_creation` |
| `retraits` | `idx_retraits_vendeur_id` | `vendeur_id` |
| `vendor_forfaits` | `idx_vendor_forfaits_vendeur_id` | `vendeur_id` |
| `mikrotik_config` | `idx_mikrotik_config_vendeur_id` | `vendeur_id` |
| `import_batches` | `idx_import_batches_vendeur_id` | `vendeur_id` |

**Commande :** `php artisan make:migration add_performance_indexes`

---

## PHASE 2 — Queue + Notifications asynchrones

### 2.1 Configurer la queue

| Fichier | Modification |
|---------|-------------|
| `.env` | `QUEUE_CONNECTION=database` |
| `config/queue.php` | Déjà OK avec la config Laravel, pas de modif nécessaire |

**Commandes :**
```bash
php artisan queue:table
php artisan migrate
```

### 2.2 Ajouter `implements ShouldQueue` aux 9 notifications

| Fichier | Modification |
|---------|-------------|
| `app/Notifications/VendeurWelcomeNotification.php` | `extends Notification implements ShouldQueue` |
| `app/Notifications/VendeurRegisteredNotification.php` | `extends Notification implements ShouldQueue` |
| `app/Notifications/WithdrawalRequestedNotification.php` | `extends Notification implements ShouldQueue` |
| `app/Notifications/WithdrawalStatusNotification.php` | `extends Notification implements ShouldQueue` |
| `app/Notifications/VendeurStatusNotification.php` | `extends Notification implements ShouldQueue` |
| `app/Notifications/ForfaitQuantityAlertNotification.php` | `extends Notification implements ShouldQueue` |
| `app/Notifications/TransactionSuccessNotification.php` | `extends Notification implements ShouldQueue` |
| `app/Notifications/AchatVendeurNotification.php` | `extends Notification implements ShouldQueue` |
| `app/Notifications/EmailVerificationNotification.php` | `extends Notification implements ShouldQueue` |

### 2.3 Lancer le worker en prod

```bash
nohup php artisan queue:work --daemon &
```

Ou dans Supervisor :
```ini
[program:hotspot-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
numprocs=2
```

---

## PHASE 3 — Admin Dashboard (87 → 2 requêtes)

Fichier : `app/Http/Livewire/Admin/Dashboard.php`

### 3.1 Remplacer `computeEvolutions()`

**Avant :** boucle `for ($i = 0; $i < 7; $i++)` avec 9 requêtes par itération + 10 requêtes avant → ~87 requêtes

**Après :** 2 requêtes SQL avec `GROUP BY DATE`

```php
private function computeEvolutions(): void
{
    $dates = collect();
    for ($i = 6; $i >= 0; $i--) {
        $dates->push(now()->subDays($i)->format('Y-m-d'));
    }

    // 1 requête pour toutes les transactions des 7 derniers jours
    $transactions = Transaction::where('created_at', '>=', now()->subDays(7))
        ->selectRaw('DATE(created_at) as date, COUNT(*) as total, COALESCE(SUM(montant), 0) as montant')
        ->groupBy('date')
        ->pluck('total', 'montant', 'date'); // à adapter selon le besoin

    // 1 requête pour tous les vendeurs des 7 derniers jours
    $vendeurs = Vendeur::where('created_at', '>=', now()->subDays(7))
        ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupBy('date')
        ->pluck('count', 'date');
}
```

### 3.2 Vérifier les propriétés `$evolutionData` / `$evolutionLabels`

Adapter la structure pour matcher ce que le template Blade attend.

---

## PHASE 4 — Vendor Dashboard (~37 → 2 requêtes)

Fichier : `app/Http/Livewire/Vendor/Dashboard.php`

Même pattern que Phase 3 : remplacer la boucle de 7 jours par `GROUP BY DATE`.

**Colonnes concernées :** `total_ventes`, `total_montant`, `tickets_vendus`, `tickets_restants`, `ventes_data`, `montant_data`

---

## PHASE 5 — Revenus-Détails (vue Blade, logique extraite)

### 5.1 Créer un service de stats

Fichier : `app/Services/StatsService.php`

```php
<?php
namespace App\Services;

use App\Models\Transaction;
use App\Models\Vendeur;
use App\Models\Ticket;
use Illuminate\Support\Facades\Cache;

class StatsService
{
    public function revenueOverTime(string $period = '7d'): array
    {
        $days = match($period) {
            '30d' => 30,
            '90d' => 90,
            default => 7,
        };

        return Cache::remember("stats.revenue.{$period}", 300, function () use ($days) {
            return Transaction::where('created_at', '>=', now()->subDays($days))
                ->where('statut', 'completed')
                ->selectRaw('DATE(created_at) as date, COALESCE(SUM(montant), 0) as total')
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('total', 'date')
                ->toArray();
        });
    }

    public function totalRevenue(): float
    {
        return Cache::remember('stats.total_revenue', 300, function () {
            return Transaction::where('statut', 'completed')->sum('montant');
        });
    }

    public function totalVendors(): int
    {
        return Cache::remember('stats.total_vendors', 300, function () {
            return Vendeur::where('statut', 'actif')->count();
        });
    }

    public function ticketsSold(): int
    {
        return Cache::remember('stats.tickets_sold', 300, function () {
            return Ticket::where('status', 'vendu')->count();
        });
    }
}
```

### 5.2 Injecter dans la vue Blade

Remplacer les blocs `@php(...)` par `app(StatsService::class)->revenueOverTime($period)`.

### 5.3 Ajouter le cache helper

```php
// config/cache.php — déjà configuré par défaut (file driver)
// .env — CACHE_DRIVER=file (défaut)
```

---

## PHASE 6 — VendeurManager (sous-requêtes avecCount/withSum)

Fichier : `app/Http/Livewire/Admin/VendeurManager.php`

### Avant (7 sous-requêtes par ligne)
```php
Vendeur::withCount(['tickets as tickets_vendus' => fn($q) => $q->where('status', 'vendu')])
    ->withCount(['tickets as tickets_disponibles' => fn($q) => $q->where('status', 'disponible')])
    ->withCount(['tickets' => fn($q) => $q->where('status', 'vendu')])
    ->withSum(['transactions' => fn($q) => $q->where('statut', 'completed')], 'montant')
    ->withSum(['withdrawals' => fn($q) => $q->where('statut', 'paid')], 'montant_net')
    ...
```

### Après (1 requête avec `selectRaw + join`)
```php
Vendeur::leftJoin('ticket', 'vendeurs.id', '=', 'ticket.vendeur_id')
    ->leftJoin('transactions', 'vendeurs.id', '=', 'transactions.vendeur_id')
    ->leftJoin('withdrawals', 'vendeurs.id', '=', 'withdrawals.vendeur_id')
    ->selectRaw('vendeurs.*')
    ->selectRaw('COUNT(CASE WHEN ticket.status = "vendu" THEN 1 END) as tickets_vendus')
    ->selectRaw('COUNT(CASE WHEN ticket.status = "disponible" THEN 1 END) as tickets_disponibles')
    ->selectRaw('COALESCE(SUM(CASE WHEN transactions.statut = "completed" THEN transactions.montant END), 0) as total_ventes')
    ->selectRaw('COALESCE(SUM(CASE WHEN withdrawals.statut = "paid" THEN withdrawals.montant_net END), 0) as total_retraits')
    ->groupBy('vendeurs.id')
    ->paginate(20);
```

---

## PHASE 7 — Asset optimization

### 7.1 Chart.js bundle

```bash
npm install chart.js
```

**`resources/js/app.js`** — Ajouter :
```js
import Chart from 'chart.js/auto';
window.Chart = Chart;
```

**`vite.config.js`** — Vérifier que `resources/js/app.js` est dans le bundle.

**Retirer les 3 CDN Chart.js** des vues :
- `resources/views/livewire/admin/revenus-details.blade.php`
- `resources/views/livewire/vendor/dashboard.blade.php`
- `resources/views/layouts/app.blade.php` (ou layout concerné)

### 7.2 Font Awesome — une seule version

Unifier les CDN vers une version unique (6.7.2) avec `defer` :
```html
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
```

### 7.3 Preconnect CDN

Dans `resources/views/layouts/app.blade.php` :
```html
<link rel="preconnect" href="https://cdn.jsdelivr.net">
<link rel="preconnect" href="https://cdnjs.cloudflare.com">
```

### 7.4 Retirer les setTimeout artificiels des squelettes

Remplacer `setTimeout(() => loaded = true, 1600)` par `wire:loading` ou `$delay` de Livewire.

---

## ORDRE D'EXÉCUTION RECOMMANDÉ

| Ordre | Phase | Effort | Impact | Risque |
|-------|-------|--------|--------|--------|
| 1 | **Phase 1 — Indexes DB** | 1 fichier | 🔥 Très haut | Faible |
| 2 | **Phase 2 — Queue + ShouldQueue** | 9 fichiers + config | 🔥 Très haut | Faible |
| 3 | **Phase 3 — Admin Dashboard** | 1 fichier | 🔥 Très haut | Moyen |
| 4 | **Phase 4 — Vendor Dashboard** | 1 fichier | 🔥 Haut | Moyen |
| 5 | **Phase 6 — VendeurManager** | 1 fichier | 🟡 Haut | Moyen |
| 6 | **Phase 5 — Revenus-Détails + StatsService** | 2 fichiers | 🟡 Moyen | Moyen |
| 7 | **Phase 7 — Assets** | 3-5 fichiers | 🟢 Faible | Faible |

**Total estimé : 10-15 fichiers modifiés, 2-3h de travail.**

---

## VALIDATION

Après chaque phase :

```bash
# Vérifier les requêtes SQL
php artisan debugbar:enable  # ou utiliser Laravel Debugbar

# Vérifier les indexes
php artisan db:show --table=ticket

# Vérifier la queue
php artisan queue:monitor

# Vérifier les temps de réponse
php artisan route:list --path=vendeur | xargs -I{} curl -o /dev/null -s -w "%{time_total}s\n" http://localhost/{}
```
