# Plan Correction Sécurité — Phase 1 (Critique)

## Objectif
Rotation des secrets + sécurisation du webhook de callback LigdiCash.

---

## Tâche 1 — Rotation des secrets

### Fichier: `.env`

| Secret | Valeur actuelle | Action |
|--------|-----------------|--------|
| `DB_PASSWORD` | `secret123root` | Générer nouveau |
| `LIGDICASH_API_KEY` | `9C67BYY7YY5PBVDQO` | Générer nouveau |
| `LIGDICASH_API_TOKEN` | `eyJ0eXAiOiJKV1Qi...` | Générer nouveau |
| `MAIL_PASSWORD` | `rnfsxcubchiltjxc` | Générer nouveau |
| `APP_KEY` | `base64:yHnHYZ1RIaee...` | `php artisan key:generate` |

**Procédure :**
1. Générer les nouveaux secrets
2. Mettre à jour `.env`
3. Appliquer les changements côté services (DB, Gmail, LigdiCash)
4. Ne **pas** committer le `.env` — le retirer du suivi git si nécessaire

---

## Tâche 2 — Sécuriser le webhook callback

### Fichiers concernés
- `routes/api.php`
- `app/Http/Controllers/Api/PaymentApiController.php`

### Changements

#### 2.1 Ajouter une signature HMAC
- Ajouter une constante/shared secret dans `.env` : `WEBHOOK_SECRET`
- Le callback LigdiCash doit envoyer un header `X-Signature` = `HMAC-SHA256(payload, secret)`
- Vérifier la signature avant de traiter la requête

#### 2.2 IP whitelist
- Définir les plages IP autorisées dans `.env` : `LIGDICASH_IPS=...`
- Vérifier que `$request->ip()` est dans la whitelist avant traitement

#### 2.3 Logging des tentatives non autorisées
- Logger toute tentative (IP, payload) avec niveau `warning`

### Détail technique

```php
// Dans PaymentApiController::callback()

// 1. Vérifier IP
$allowedIps = explode(',', env('LIGDICASH_IPS', ''));
if (!in_array($request->ip(), $allowedIps)) {
    Log::warning('Callback non autorisé', ['ip' => $request->ip()]);
    return response()->json(['error' => 'Unauthorized'], 403);
}

// 2. Vérifier HMAC
$payload = $request->getContent();
$signature = $request->header('X-Signature');
$expected = hash_hmac('sha256', $payload, env('WEBHOOK_SECRET'));
if (!$signature || !hash_equals($expected, $signature)) {
    Log::warning('Signature HMAC invalide', ['ip' => $request->ip()]);
    return response()->json(['error' => 'Invalid signature'], 403);
}
```

#### 2.4 Rate limiting sur la route callback
```php
// routes/api.php
Route::post('/payment-callback', [PaymentApiController::class, 'callback'])
    ->middleware('throttle:30,1');
```

---

## Tâche 3 — Nettoyage

- Retirer `.env` du suivi git : `git rm --cached .env && echo ".env" >> .gitignore`
- Vérifier qu'aucun secret n'est commité dans l'historique

---

## Ordre d'exécution

1. Ajouter `WEBHOOK_SECRET` et `LIGDICASH_IPS` dans `.env`
2. Modifier `PaymentApiController::callback()` (HMAC + IP whitelist + rate limiting)
3. Modifier `routes/api.php` (throttle)
4. Rotation des autres secrets (DB, Gmail, APP_KEY)
5. Appliquer les changements externes (services)
6. Nettoyer git
