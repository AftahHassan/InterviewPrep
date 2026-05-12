# Spec — Authentification

## Date
Lundi 12/05/2026

## User Story couverte
US1 — En tant qu'utilisateur, je veux créer mon compte,
me connecter et me déconnecter.

---

## Ce que j'ai expliqué à l'agent

J'ai ouvert Claude Code et j'ai écrit ceci :

> "Je travaille sur InterviewPrep, une application Laravel 11.
> Je veux mettre en place l'authentification complète.
> L'utilisateur doit pouvoir s'inscrire avec son nom, email et mot de passe,
> se connecter, et se déconnecter.
> Je veux utiliser Laravel Breeze avec la stack Blade.
> Je NE veux PAS de vérification email obligatoire.
> Je NE veux PAS de connexion via Google ou GitHub.
> Je NE veux PAS de double authentification.
> Commence par me proposer un plan SANS générer de code."

---

## Plan que l'agent a proposé

L'agent m'a proposé ce plan avant de générer quoi que ce soit :

1. Installer Laravel Breeze via composer
2. Lancer la commande `php artisan breeze:install blade`
3. Lancer les migrations pour créer la table `users`
4. Supprimer l'interface `MustVerifyEmail` dans `User.php`
5. Installer les dépendances npm et compiler les assets
6. Tester les routes `/register`, `/login`, `/logout`

J'ai validé ce plan sans modification.

---

## Ce que je NE voulais PAS
(précisé à l'agent avant qu'il génère le code)

- Pas de social login (Google, GitHub)
- Pas de vérification email obligatoire avant connexion
- Pas de 2FA (double authentification)
- Pas de page "mot de passe oublié" personnalisée
- Pas de champ "username" séparé du "name"

---

## Commandes exécutées

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
php artisan migrate
npm install && npm run dev
```

---

## Ce que l'agent a généré

### Fichiers créés automatiquement par Breeze

```
routes/auth.php
app/Http/Controllers/Auth/AuthenticatedSessionController.php
app/Http/Controllers/Auth/RegisteredUserController.php
app/Http/Controllers/Auth/PasswordResetLinkController.php
app/Http/Controllers/Auth/NewPasswordController.php
resources/views/auth/login.blade.php
resources/views/auth/register.blade.php
resources/views/auth/forgot-password.blade.php
resources/views/layouts/app.blade.php
resources/views/layouts/guest.blade.php
resources/views/dashboard.blade.php
database/migrations/xxxx_create_users_table.php
database/migrations/xxxx_create_sessions_table.php
```

---

## Ce que j'ai modifié manuellement après génération

### 1. Suppression de MustVerifyEmail dans User.php

L'agent avait laissé `MustVerifyEmail` dans le modèle User.
Je l'ai supprimé car je ne veux pas de vérification email.

**Avant :**
```php
class User extends Authenticatable implements MustVerifyEmail
{
```
**Après :**
```php
class User extends Authenticatable
{
```

### 2. Traduction des textes en français

Les vues Blade générées étaient en anglais.
J'ai traduit manuellement les textes principaux :

| Texte original     | Texte traduit          |
|--------------------|------------------------|
| Log in             | Se connecter           |
| Register           | S'inscrire             |
| Remember me        | Se souvenir de moi     |
| Forgot password?   | Mot de passe oublié ?  |
| Already registered?| Déjà inscrit ?         |
| Email Address      | Adresse email          |
| Password           | Mot de passe           |

### 3. Redirection après connexion

Par défaut Breeze redirige vers `/dashboard`.
J'ai changé pour rediriger vers `/domains` :

**Avant :**
```php
return redirect()->intended(RouteServiceProvider::HOME);
```
**Après :**
```php
return redirect()->route('domains.index');
```

---

## Observations

- L'agent avait oublié de changer la redirection après login
- MustVerifyEmail est une erreur classique de Breeze — toujours vérifier
- Les textes sont toujours en anglais par défaut — toujours traduire manuellement

---

## Résultat final

- Inscription fonctionne
- Connexion fonctionne
- Déconnexion fonctionne
- Les routes protégées redirigent vers /login si non connecté
- Textes en français

---

## Commit associé

```
feat(auth): setup Laravel Breeze Blade, remove email verification,
translate to French — [AI: Claude Code]
```