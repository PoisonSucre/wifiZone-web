# Audit de Sécurité — Wifi Pour Tous (Hotspot SaaS Laravel)

Date : 30/07/2026
Projet : hotspot_sass_laravel
Framework : Laravel 13.x / Livewire 4.x

---

## CRITIQUES (Action immédiate)

| # | Vulnérabilité | Fichier | Risque |
|---|---|---|---|
| C1 | Webhook `/api/payment-callback` sans aucune authentification | `routes/api.php`, `PaymentApiController.php` | N'importe qui peut POST et simuler un paiement |
| C2 | `POST /payment/init` sans CSRF **et** sans auth | `bootstrap/app.php:26` | Attaque CSRF possible, initiation de paiement non autorisée |
| C3 | `is_admin` dans `$fillable` | `app/Models/Vendeur.php:22` | Escalade de privilèges possible via mass-assignment |
| C4 | `trustProxies(at: '*')` | `bootstrap/app.php:33` | Spoofing IP, contournement du rate limiting |
| C5 | Secrets en clair dans `.env` | `.env` | DB, Gmail, API LigdiCash exposés |
| C6 | Aucune config CORS | `config/cors.php` manquant | API accessible de n'importe quelle origine |

---

## HAUTES

| # | Vulnérabilité | Fichier |
|---|---|---|
| H1 | `SESSION_ENCRYPT=false` — sessions stockées en clair en base | `.env` / `config/session.php` |
| H2 | Pas de SSL sur la connexion MySQL | `config/database.php` |
| H3 | `LOG_LEVEL=debug` en production — logs contenant données sensibles | `.env` |
| H4 | URL ngrok utilisée comme `APP_URL` | `.env` |

---

## MOYENNES

| # | Vulnérabilité | Fichier |
|---|---|---|
| M1 | Mot de passe minimum 6 caractères | `RegisterForm.php:61`, `ProfilEditor.php:39` |
| M2 | Aucun rate limiting sur l'inscription ni le reset de mot de passe | `routes/web.php` |
| M3 | IDs auto-incrémentés exposés (`/shop/{id}`) | Route `/shop/{id}` |
| M4 | Génération numéro carte avec `str_shuffle()` (RNG faible) | `app/Models/Vendeur.php:103-113` |
| M5 | Même modèle (`Vendeur`) pour admin et vendor | `config/auth.php` |
| M6 | Tests connectés à MySQL au lieu de SQLite | `phpunit.xml` |

---

## Plan de Correction

### Phase 1 — Corrections rapides

| # | Action | Fichier | Statut |
|---|---|---|---|
| 1 | Retirer `is_admin` de `$fillable` → `$guarded` | `app/Models/Vendeur.php` | ✅ |
| 2 | Forcer `SESSION_ENCRYPT=true` | `.env` | ✅ |
| 3 | Passer `LOG_LEVEL=warning` | `.env` | ✅ |
| 4 | Créer `config/cors.php` | `config/cors.php` | ✅ |
| 5 | Rate limiting sur inscription & reset password | `routes/web.php` | ✅ |
| 6 | Password min 8 caractères | `RegisterForm.php`, `ProfilEditor.php`, `PasswordController` | ✅ |
| 7 | Tests → SQLite memory | `phpunit.xml` | ✅ |

### Phase 2 — Corrections code

| # | Action | Fichier | Statut |
|---|---|---|---|
| 8 | Sécuriser webhook `/api/payment-callback` (HMAC + IP whitelist) | `PaymentApiController.php` | ✅ |
| 9 | Restreindre `trustProxies` | `bootstrap/app.php` | ✅ |
| 10 | Remplacer `str_shuffle` par `random_int()` | `app/Models/Vendeur.php` | ✅ |
| 11 | Sécuriser `/payment/init` (CSRF + validation) | `routes/web.php`, `PaymentInitController` | ✅ |
| 12 | SSL MySQL | `config/database.php` | ✅ |

### Phase 3 — Infrastructure (non inclus)

| # | Action | Raison |
|---|---|---|
| 13 | Rotation des secrets | À faire manuellement (DB, Gmail, LigdiCash, APP_KEY) |
| 14 | SSL MySQL si DB distante | Déjà en localhost ? À vérifier |
| 15 | Remplacer ngrok | Dépend du déploiement |
| 16 | Séparer modèles Admin/Vendeur | Refactoring lourd |
| 17 | UUIDs au lieu de IDs auto-incrémentés | Refactoring lourd |

---

## Détail des correctifs

### Fix 1 — `is_admin` dans `$guarded`

**Fichier :** `app/Models/Vendeur.php`

Retirer `'is_admin'` de `$fillable` et l'ajouter dans `$guarded` pour empêcher le mass-assignment.

### Fix 2 — `SESSION_ENCRYPT=true`

**Fichier :** `.env`

Ajouter la variable pour que les sessions soient chiffrées en base de données.

### Fix 3 — `LOG_LEVEL=warning`

**Fichier :** `.env`

Passer de `debug` à `warning` pour éviter de logger des données sensibles (emails, payloads API, etc.).

### Fix 4 — `config/cors.php`

Créer le fichier qui avait été supprimé. Restreindre les origines autorisées pour les appels API.

### Fix 5 — Rate limiting

Ajouter `->middleware('throttle:3,60')` sur les routes d'inscription et de reset de mot de passe.

### Fix 6 — Password min 8

Changer toutes les validations `min:6` en `min:8` pour le mot de passe.

### Fix 7 — Tests vers SQLite

Changer `phpunit.xml` pour utiliser `sqlite` et `:memory:` au lieu de MySQL, évitant tout risque de pollution de la base de production.

### Fix 8 — Webhook sécurisé

Ajouter :
- Vérification d'une signature HMAC dans le header `X-Signature`
- Whitelist d'IPs autorisées (plages LigdiCash)
- Logging des tentatives non autorisées

### Fix 9 — `trustProxies`

Remplacer `'*'` par les IPs réelles (ngrok ou reverse proxy).

### Fix 10 — CSPRNG

Remplacer `str_shuffle()` par `random_int()` pour la génération des numéros de carte.

### Fix 11 — `/payment/init`

- Réactiver la vérification CSRF (ou ajouter un token dans le formulaire)
- Lier `vendeur_id` à l'utilisateur authentifié au lieu de le prendre de la requête
- Ou à défaut, ajouter une validation que le vendeur_id correspond bien à un vendeur actif

### Fix 12 — SSL MySQL

Ajouter le support SSL optionnel dans `config/database.php` pour chiffrer la connexion à la base de données.
