# Plan d'intégration du template MikroTik dans l'aperçu boutique

## Objectif

- Afficher le template `resources/views/shop/template/login.html` dans l'aperçu
- Remplacer la page shop publique `/shop/{id}` par le template
- Générer un pack téléchargeable pour déploiement MikroTik

## Fichiers à créer (2)

### 1. `resources/views/shop/template/preview.blade.php`

Version Blade du `login.html` :

- **Données dynamiques** : nom, couleur, logo, message d'accueil, forfaits
- **CSS inline** : contenu de `style.css` intégré, couleurs dynamiques via `{{ $vendeur->couleur }}`
- **Tableau des tarifs** : `@foreach($forfaits as $f)` — label, montant, duree_minutes
- **Paiement** : formulaire POST → `{{ url('/api/payment-process') }}`
- Pas de variables MikroTik (inutiles en preview web)
- Fonctionne avec `$vendeur` (route publique) ou `auth()->user()` (aperçu vendeur)
- Font Awesome 6.7.2 via CDN

### 2. `app/Http/Controllers/TemplateDownloadController.php`

Génère un ZIP avec :

| Fichier | Source |
|---------|--------|
| `login.html` | Généré statiquement : forfaits, logo (base64 ou URL absolue), `{{ config('app.url') }}/api/payment-process`, variables MikroTik conservées |
| `style.css` | Copie brute de `resources/views/shop/template/style.css` |
| `logo.{ext}` | Copie de `public/assets/uploads/logos/logo_{id}.{ext}` (si existe) |
| `orange.png` | Copie depuis le dossier template |
| `moov.png` | Copie depuis le dossier template |
| `wave.png` | Copie depuis le dossier template |

## Fichiers à modifier (4)

### 3. `app/Http/Livewire/Vendor/BoutiqueManager.php`

```php
public int $previewVersion = 0;

// Nouvelle méthode
public function refreshPreview(): void {
    $this->previewVersion++;
}

// Dans updateShop() → $this->previewVersion++
// Dans addForfait() → $this->previewVersion++
// Dans updateForfait() → $this->previewVersion++
// Dans toggleForfait() → $this->previewVersion++
// Dans deleteForfait() → $this->previewVersion++
```

### 4. `resources/views/livewire/vendor/boutique-manager.blade.php`

- Color picker : `wire:model.live` + `wire:change="refreshPreview"`
- Aperçu statique remplacé par iframe :
  ```html
  <iframe src="{{ route('vendor.preview') }}?v={{ $previewVersion }}"
          class="w-full h-[650px] rounded-xl border border-slate-200/80 dark:border-darkBorder"></iframe>
  ```
- Bouton "Télécharger" dans section Lien du portail :
  ```html
  <a href="{{ route('vendor.boutique.download') }}"
     class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-purple-500 text-white">
     <i class="fas fa-download"></i> Télécharger le pack MikroTik
  </a>
  ```

### 5. `routes/web.php`

```php
// Dans groupe 'vendor' (auth requis) :
Route::get('/apercu', function () {
    $vendeur = auth()->user();
    $forfaits = $vendeur->forfaits()->orderBy('ordre')->get();
    return view('shop.template.preview', compact('vendeur', 'forfaits'));
})->name('vendor.preview');

Route::get('/boutique/download', [TemplateDownloadController::class, 'download'])
    ->name('vendor.boutique.download');
```

### 6. `app/Http/Controllers/ShopController.php`

```php
public function show(Request $request, int $id)
{
    $vendeur = Vendeur::active()->findOrFail($id);
    $forfaits = $vendeur->forfaits()->active()->ordered()->get();
    return view('shop.template.preview', compact('vendeur', 'forfaits'));
}
```

## Flux de mise à jour en temps réel

1. Vendeur modifie la couleur → `wire:change="refreshPreview"` → `$previewVersion++`
2. Vendeur ajoute/modifie/supprime un forfait → méthode CRUD → `$previewVersion++` imbriqué
3. Vue se re-rend avec la nouvelle version → l'iframe a `?v=N+1` → rechargement automatique
4. Le preview reflète instantanément les changements

## Contenu de la preview (par rapport à login.html)

| Élément login.html | Preview | Download |
|--------------------|---------|----------|
| `$(link-login-only)` | Omis | Conservé |
| `$(link-orig)` | Omis | Conservé |
| `$(error)` | Omis | Conservé |
| `$(if trial == 'yes')` | Omis | Conservé |
| `$(endif)` | Omis | Conservé |
| `$(mac-esc)` | Omis | Conservé |
| `https://...ngrok.../payment_process.php` | `{{ url('/api/payment-process') }}` | `{{ config('app.url') }}/api/payment-process` |
| Forfaits (prix, labels) | `@foreach($forfaits)` | Boucle PHP figée en HTML |
| Couleur (gradient, boutons) | `{{ $vendeur->couleur }}` | Valeur figée |
| Logo | `<img src="{{ asset($vendeur->logo) }}">` | Base64 ou URL absolue |
| `.nom` | `{{ $vendeur->prenom }} {{ $vendeur->nom }}` | Valeur figée |
| Message d'accueil | `{{ $vendeur->message_bienvenue }}` | Valeur figée |
| CSS | Inline dans `<style>` | Fichier `style.css` externe |
| Font Awesome | CDN 6.7.2 | CDN 6.0.0-beta3 (conservé) |
