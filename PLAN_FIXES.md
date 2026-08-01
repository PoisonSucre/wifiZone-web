# Plan de correction — Hotspot & Quota

Date: 2026-08-01

---

## Priorité 1 — Bugs critiques (intégrité données / finances)

### #1 — `addHotspot()` ne gèle pas les abonnements expirés avant de vérifier le quota
- **Fichier**: `app/Http/Livewire/Vendor/HotspotManager.php:77`
- **Problème**: `openForm()` appelle `freezeExpiredSubscriptions()` avant `canCreate()`, mais `addHotspot()` ne le fait pas. Si un abonnement expire entre le rendu de la page et la soumission du formulaire, `canCreate()` utilise des données périmées.
- **Correction**: Ajouter `app(HotspotService::class)->freezeExpiredSubscriptions(auth()->user());` au début de `addHotspot()`, avant le `canCreate()`.

### #2 — `renewSubscription()` calcule l'expiration depuis l'ancienne date au lieu de "maintenant"
- **Fichier**: `app/Services/HotspotService.php:158`
- **Problème**: `Carbon::parse($latest)->addDays($this->packDurationDays())` ajoute la durée du pack à l'ancienne date d'expiration. Si un abonnement a expiré il y a 15 jours et est renouvelé, le vendeur obtient 15 jours + la durée du pack au lieu de juste la durée du pack.
- **Correction**: Remplacer par `now()->addDays($this->packDurationDays())` pour que le renouvellement commence à la date actuelle.

### #3 — `soldeDisponible()` ne déduit pas les achats de pack en attente (`pending`)
- **Fichier**: `app/Services/HotspotService.php:175-183`
- **Problème**: `soldeConsomme()` ne compte que les transactions `statut=completed`. Si un vendeur a un paiement LigdiCash pour un pack en attente de confirmation webhook, son solde disponible ne reflète pas cette dépense future. Risque de double dépense.
- **Correction**: Ajouter une méthode `pendingPackConsomme()` qui somme les transactions `type=pack`, `payment_method=solde`, `statut=pending`, et la soustraire dans `soldeDisponible()`.

### #4 — `handlePackPurchase()` a un fallback dangereux sur `pack_key`
- **Fichier**: `app/Http/Controllers/Api/PaymentApiController.php:174`
- **Problème**: `$transaction->pack_key ?? 'A'` : si `pack_key` est null, il tente de renouveler le pack 'A' sans vérifier qu'il existe dans les settings. L'exception est attrapée silencieusement.
- **Correction**: Vérifier que `pack_key` existe dans `packs()` avant de l'utiliser. Si null ou invalide, logger une erreur et retourner sans créer d'abonnement.

---

## Priorité 2 — Cohérence du code

### #5 — `PaymentInitController::init()` ne définit pas `type` sur la transaction
- **Fichier**: `app/Http/Controllers/PaymentInitController.php:40-46`
- **Problème**: Pas de `type` défini, repose sur le default DB `'ticket'`. `PackPaymentController` le définit explicitement à `'pack'`. Incohérence.
- **Correction**: Ajouter `'type' => 'ticket'` explicitement dans le `Transaction::create()` de `PaymentInitController`.

### #6 — `freezeExpiredSubscriptions()` absent dans `subscribePackWithSolde()`
- **Fichier**: `app/Http/Livewire/Vendor/HotspotManager.php:128`
- **Problème**: Le flux d'achat de pack avec solde ne gèle pas les abonnements expirés avant de calculer `soldeDisponible`.
- **Correction**: Ajouter `app(HotspotService::class)->freezeExpiredSubscriptions(auth()->user());` au début de `subscribePackWithSolde()`.

### #7 — `freezeExpiredSubscriptions()` absent dans `chooseSoldePack()`
- **Fichier**: `app/Http/Livewire/Vendor/HotspotManager.php:108`
- **Problème**: Même problème que #6 pour le choix du pack avec solde.
- **Correction**: Ajouter `app(HotspotService::class)->freezeExpiredSubscriptions(auth()->user());` au début de `chooseSoldePack()`.

---

## Priorité 3 — Performance & Schéma

### #8 — Index manquant sur `frozen_at` dans `hotspot_subscriptions`
- **Fichier**: `database/migrations/2026_08_01_000001_create_hotspot_subscriptions_table.php`
- **Problème**: `freezeExpiredSubscriptions()` interroge fréquemment `frozen_at = null` et `expires_at <= now()` mais il n'y a pas d'index sur `frozen_at`.
- **Correction**: Créer une migration d'ajout d'index composite `['vendeur_id', 'frozen_at', 'expires_at']` sur la table `hotspot_subscriptions`.

### #9 — `Hotspot` a des relations inutilisées dans la logique quota
- **Fichier**: `app/Models/Hotspot.php:43-56`
- **Problème**: Les relations `transactions()`, `withdrawals()`, et `importBatches()` sont définies mais jamais utilisées dans la logique quota (qui fonctionne au niveau vendeur).
- **Correction**: Soit supprimer ces relations si elles ne sont pas prévues, soit les documenter avec un commentaire expliquant leur usage futur prévu.

---

## Priorité 4 — UX & Données seed

### #10 — Barre de progression affiche 0% quand `limit=0` et `used>0`
- **Fichier**: `resources/views/livewire/vendor/hotspot-manager.blade.php:155-157`
- **Problème**: Quand `limit=0` et `used>0`, la barre montre 0% alors que le quota est dépassé.
- **Correction**: Changer la logique pour afficher 100% quand `used >= limit` (et `limit > 0`), ou un état "dépassé" visuel quand `limit=0` et `used>0`.

### #11 — Liens `hotspot-details.blade.php` passent `hotspot` comme paramètre de route
- **Fichier**: `resources/views/vendor/hotspot-details.blade.php:215,227,239`
- **Problème**: `route('vendor.tickets', ['hotspot' => ...])`, `route('vendor.boutique', ...)`, `route('vendor.import', ...)`. Ces routes n'ont pas de paramètre `{hotspot}`, donc `hotspot` devient un query string. Ça fonctionne mais c'est fragile et non explicite.
- **Correction**: Utiliser `?hotspot=X` explicitement dans les URLs au lieu du tableau de paramètres de `route()`.

### #12 — `HotspotSeeder` crée des hotspots sans `HotspotSubscription`
- **Fichier**: `database/seeders/HotspotSeeder.php`
- **Problème**: Crée 7 hotspots pour 5 vendeurs sans créer d'abonnements. Ils dépendent entièrement des 2 slots gratuits par défaut. Si le setting `hotspot_free_slots` change, les données seed seraient incohérentes.
- **Correction**: S'assurer que le seeder crée un abonnement gratuit ou ajuste le nombre de hotspots pour correspondre aux slots gratuits configurés.

### #13 — `statut` du hotspot non validé
- **Fichier**: `app/Models/Hotspot.php:24-26`
- **Problème**: Le `statut` est casté en `string` sans contrainte. L'UI n'utilise que `'actif'` et `'inactif'`, mais rien n'empêche d'autres valeurs en base.
- **Correction**: Ajouter une validation dans `HotspotManager` (dans `addHotspot()` et `updateHotspot()`) pour limiter `statut` à `['actif', 'inactif']`. Optionnellement, ajouter un enum PHP.

---

## Ordre de réalisation

| Sprint | Items |
|--------|-------|
| Sprint 1 | #1, #2, #4 |
| Sprint 1b | #3 |
| Sprint 2 | #5, #6, #7 |
| Sprint 3 | #8, #9 |
| Sprint 4 | #10, #11, #12, #13 |