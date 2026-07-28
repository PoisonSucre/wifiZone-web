# Plan : Header fixe (hors scroll) pour toutes les pages

## Problème
Chaque page a son titre/header à l'intérieur du Livewire component, donc dans la zone scrollable `.vendor-content`. Quand on scroll, le titre disparaît.

## Solution
Extraire le header dans `@section('header')` de la page template. Le layout render déjà ce header **avant** `.vendor-content`, donc il reste naturellement fixe. Plus besoin de `position: sticky`.

## Changement par fichier

### Partie 1 — Layout admin (1 fichier)
| Fichier | Action |
|---------|--------|
| `layouts/admin.blade.php` | Ajouter `@hasSection('header')` / `@yield('header')` avant le `.vendor-content` |

### Partie 2 — CSS (1 fichier)
| Fichier | Action |
|---------|--------|
| `resources/css/vendeur.css` | Ajouter `.admin-header-static` (même style que `.vendor-header-static`) |

### Partie 3 — Pages vendeur (5 templates + 5 Livewire)
Chaque paire (template + Livewire) suit le même pattern :

1. **Template** (`vendor/X.blade.php`) — Ajouter `@section('header')` avec le header HTML extrait du component
2. **Livewire** (`livewire/vendor/X.blade.php`) — Supprimer le header + supprimer son placeholder dans le skeleton

| Template | Livewire Component | Header |
|----------|-------------------|--------|
| `vendor/tickets.blade.php` | `livewire/vendor.ticket-list` | Icône bleue, "Mes Tickets", bouton "Ajouter" |
| `vendor/boutique.blade.php` | `livewire/vendor.boutique-manager` | Icône neon, "Mon Portail", lien "Voir mon portail" |
| `vendor/retraits.blade.php` | `livewire/vendor.retrait-manager` | Icône ambre, "Mes Retraits" |
| `vendor/profil.blade.php` | `livewire/vendor.profil-editor` | Icône violette, "Mon Profil" |
| `vendor/import.blade.php` | `livewire/vendor.ticket-import` | Icône bleue, "Importer des tickets" |

### Partie 4 — Pages admin (7 templates + 6 Livewire + 1 inline)

| Template | Livewire Component | Header | Migration ancien style ? |
|----------|-------------------|--------|--------------------------|
| `admin/dashboard.blade.php` | `livewire/admin.dashboard` | Icône neon, "Tableau de Bord" + badges | Non (déjà nouveau style) |
| `admin/tickets.blade.php` | `livewire/admin.ticket-list` | Icône bleue, "Tickets" | Oui |
| `admin/transactions.blade.php` | `livewire/admin.transaction-list` | Icône bleue, "Transactions" | Oui |
| `admin/vendeurs.blade.php` | `livewire/admin.vendeur-manager` | Icône bleue, "Gestion des Vendeurs" + bouton Ajouter | Oui |
| `admin/retraits.blade.php` | `livewire/admin.retrait-manager` | Icône ambre, "Gestion des Retraits" | Oui |
| `admin/parametres.blade.php` | `livewire/admin.parametre-manager` | Icône grise, "Paramètres" | Oui |
| `admin/revenus-details.blade.php` | (inline, pas de Livewire) | Icône neon, "Revenus & Commissions" + bouton Retour | N/A |

### Partie 5 — Skeletons
Pour chaque Livewire component modifié, retirer le placeholder header du skeleton.

## Ordre d'exécution
1. `layouts/admin.blade.php` — ajouter le yield header
2. `resources/css/vendeur.css` — ajouter `.admin-header-static`
3. Templates vendeur un par un (de tickets à import)
4. Livewire components vendeur correspondants
5. Templates admin un par un (de dashboard à revenus-details)
6. Livewire components admin correspondants
7. Mise à jour des 12 squelettes (retirer le placeholder header)
