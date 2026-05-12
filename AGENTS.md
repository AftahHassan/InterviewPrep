# AGENTS.md — InterviewPrep

> Ce fichier documente toutes les règles, conventions et décisions liées à l'usage
> des coding agents IA dans ce projet. Il doit être lu par tout agent avant de générer
> du code, et mis à jour après chaque session de travail significative.

---

## 1. Présentation du projet

**Nom** : InterviewPrep  
**Type** : Application web Laravel (backend + Blade views)  
**Objectif** : Aider un développeur à structurer sa préparation aux entretiens techniques
en organisant ses connaissances par domaine, en rédigeant des notes sur chaque concept,
et en générant automatiquement des questions d'entretien via une API AI.  
**Stack** :
- Backend : PHP 8.3 / Laravel 13
- Frontend : Blade + Tailwind CSS
- Base de données : MySQL
- API AI : Groq API (appel via `Http::` facade Laravel — zéro package externe)
- Auth : Laravel Breeze (stack Blade)

---

## 2. Agent(s) utilisé(s)

| Agent | Usage | Lien |
|---|---|---|
| Claude Code | Agent principal — génération de code, migrations, controllers | https://claude.ai/code |

> Si un second agent est testé en cours de projet, l'ajouter ici avec la date de test.

---

## 3. Workflow obligatoire avant chaque génération

### Règle fondamentale
**Toujours utiliser le mode Plan avant le mode Build.** Ne jamais lancer une génération
de code sans avoir d'abord validé un plan détaillé avec l'agent.

### Les 7 étapes à suivre pour chaque feature

```
1. CONTEXTE    → Donner à l'agent le contexte complet du projet et de la feature
2. PLAN        → Demander un plan détaillé (fichiers à créer, logique, structure)
3. VALIDATION  → Lire le plan, corriger ce qui ne convient pas
4. CONTRAINTES → Préciser explicitement "Ce que je NE veux PAS" (voir section 6)
5. BUILD       → Lancer la génération seulement après validation du plan
6. REVIEW      → Relire tout le code généré ligne par ligne
7. SPEC        → Documenter dans specs/<feature>.md ce qui a été fait
```

### Exemple de prompt de démarrage (à réutiliser)

```
Je travaille sur InterviewPrep, une application Laravel 11.
Je vais construire la feature [NOM].
Voici le contexte : [DESCRIPTION].
Les fichiers concernés sont : [LISTE].
Je NE veux PAS : [CONTRAINTES].
Commence par me proposer un plan détaillé SANS générer de code.
```

---

## 4. Conventions de code imposées à l'agent

Ces règles s'appliquent à tout code généré. L'agent doit les respecter sans exception.

### 4.1 Nommage

| Élément | Convention | Exemple |
|---|---|---|
| Tables | snake_case pluriel | `generated_questions` |
| Modèles | PascalCase singulier | `GeneratedQuestion` |
| Controllers | PascalCase + Controller | `ConceptController` |
| Form Requests | Store/Update + NomModel + Request | `StoreConceptRequest` |
| Routes | kebab-case | `/domains/{domain}/concepts` |
| Variables | camelCase | `$generatedQuestion` |
| Méthodes | camelCase, verbe + nom | `generateQuestions()` |

### 4.2 Structure des controllers

- **Toujours** utiliser les 7 méthodes RESTful standard : `index, create, store, show, edit, update, destroy`
- **Jamais** de logique métier directement dans le controller — extraire dans un Service si besoin
- **Toujours** utiliser les Form Request classes pour la validation (jamais `$request->validate()` inline)
- **Toujours** utiliser `route()` pour les redirections, jamais de URL en dur

### 4.3 Eloquent & base de données

- **Toujours** définir `$fillable` dans chaque modèle (jamais `$guarded = []`)
- **Toujours** définir les relations dans les deux sens (hasMany + belongsTo)
- **Toujours** utiliser `with()` pour éviter les N+1 (vérifié avec Laravel Debugbar)
- **Jamais** de requête SQL brute — utiliser l'ORM Eloquent
- Les accessors `statusLabel()` et `difficultyLabel()` sont **obligatoires** sur le modèle `Concept`

### 4.4 Sécurité

- La clé `GROQ_API_KEY` (ou autre clé AI) doit être dans `.env` **uniquement**
- Jamais de clé API dans le code, ni dans un commentaire, ni dans un fichier de config commité
- Toutes les routes qui modifient des données doivent être protégées par le middleware `auth`
- Vérifier que chaque ressource appartient à l'utilisateur connecté (authorization, pas seulement authentication)

### 4.5 Gestion des erreurs

- L'appel à l'API Groq doit être dans un bloc `try/catch`
- En cas d'échec de l'API, afficher un message d'erreur propre à l'utilisateur (pas une page blanche, pas un stack trace)
- Utiliser `session()->flash('error', '...')` pour les messages d'erreur utilisateur

---

## 5. Ce que l'agent fait bien (à lui déléguer)

- ✅ Générer la structure des migrations avec les bons types et FK
- ✅ Écrire les Form Request classes avec les règles de validation
- ✅ Mettre en place les relations Eloquent (hasMany, belongsTo, hasManyThrough)
- ✅ Créer les controllers RESTful avec les 7 méthodes standard
- ✅ Écrire les routes resource dans `web.php`
- ✅ Générer les vues Blade de base (liste, formulaire, détail)
- ✅ Écrire la logique d'appel HTTP vers l'API Groq avec `Http::` facade
- ✅ Proposer des noms de variables et de méthodes cohérents

---

## 6. Ce que je vérifie et corrige manuellement

- ❌ Les messages de validation — l'agent génère souvent en anglais, je les traduis
- ❌ L'authorization — l'agent oublie parfois de vérifier que la ressource appartient à `auth()->user()`
- ❌ Les N+1 queries — je vérifie avec Debugbar et j'ajoute les `with()` manquants
- ❌ Le prompt envoyé à Groq — je l'affine moi-même pour obtenir des questions de qualité
- ❌ Le design et l'UX des vues Blade — l'agent génère du fonctionnel, pas du beau
- ❌ Les cas limites (domaine sans concept, génération quand l'API est down)

---

## 7. Ce que je NE veux PAS (à préciser à chaque session)

Ces contraintes sont globales et s'appliquent à tout le projet :

- **Pas de package externe** pour l'appel API AI — uniquement `Http::` facade Laravel natif
- **Pas de `$guarded = []`** dans les modèles — toujours `$fillable` explicite
- **Pas de logique dans les vues Blade** — les calculs se font dans le controller ou le modèle
- **Pas de routes nommées inventées** — toujours vérifier que le nom de route existe
- **Pas de JavaScript complexe** — au maximum du Blade + Tailwind pur, Alpine.js si absolument nécessaire
- **Pas de vérification email** dans l'auth — Laravel Breeze sans `MustVerifyEmail`
- **Pas de soft delete sur domains** — uniquement sur les concepts (bonus)
- **Pas de pagination** — les listes restent simples pour ce projet

---

## 8. Format des commits avec mention AI

Tout commit contenant du code généré ou assisté par un agent doit le mentionner explicitement.

### Format
```
type(scope): description courte — [AI: NomAgent]
```

### Types autorisés
- `feat` — nouvelle fonctionnalité
- `fix` — correction de bug
- `chore` — configuration, setup, fichiers non-fonctionnels
- `refactor` — réécriture sans changement de comportement
- `docs` — documentation uniquement

### Exemples réels
```bash
feat(auth): setup Laravel Breeze with Blade stack — [AI: Claude Code]
feat(domains): add CRUD controller and Form Requests — [AI: Claude Code]
feat(concepts): add statusLabel and difficultyLabel accessors — [AI: Claude Code]
fix(concepts): fix N+1 query on index with eager loading — [AI: Claude Code]
feat(ai): add Groq API call via Http facade with error handling — [AI: Claude Code]
chore: init project structure with AGENTS.md and specs/ — [AI: Claude Code]
```

### Commits sans mention AI
Les commits de corrections manuelles, de design, ou de logique métier personnelle
n'ont pas besoin de mention AI :
```bash
fix(concepts): translate validation messages to French
style(views): improve domain list card layout
refactor(concepts): add user ownership check on all routes
```

---

## 9. Structure du dossier specs/

Un fichier `.md` par feature construite avec un coding agent.
Chaque fichier doit contenir les 4 sections suivantes :

```markdown
# Spec — [Nom de la feature]

## Contexte donné à l'agent
[Ce que j'ai expliqué à l'agent avant de lancer]

## Plan validé
[Le plan que l'agent a proposé et que j'ai accepté]

## Ce que je NE voulais PAS
[Les contraintes que j'ai précisées]

## Ce que l'agent a généré
[Liste des fichiers créés/modifiés par l'agent]

## Ce que j'ai modifié manuellement
[Ce que j'ai changé après génération, et pourquoi]
```

### Fichiers specs/ prévus

| Fichier | Feature couverte |
|---|---|
| `specs/auth.md` | Authentification (Breeze) |
| `specs/domains-crud.md` | CRUD Domains |
| `specs/concepts-crud.md` | CRUD Concepts + changement statut rapide |
| `specs/ai-generation.md` | Appel Groq API + sauvegarde + historique |

---

## 10. Journal des sessions AI

> À remplir au fur et à mesure des sessions de travail.

### Session 1 — Lundi 12/05/2026
- **Agent** : Claude Code
- **Feature** : Setup projet + AGENTS.md + specs/
- **Ce que l'agent a généré** : Structure initiale du fichier AGENTS.md
- **Ce que j'ai modifié** : Ajout des conventions spécifiques au projet, traduction
- **Observation** : —

### Session 2 — À venir
<!-- Compléter après chaque session -->

---

## 11. Modèle de données (rappel pour l'agent)

```
users
  id, name, email, password, timestamps

domains
  id, user_id (FK → users), name, color, timestamps

concepts
  id, domain_id (FK → domains), title, explanation,
  difficulty ENUM(junior|mid|senior),
  status ENUM(to_review|in_progress|mastered),
  deleted_at (soft delete), timestamps

generated_questions
  id, concept_id (FK → concepts), questions (JSON), timestamps
```

**Relations Eloquent à définir :**
- `User` hasMany `Domain`
- `Domain` belongsTo `User`
- `Domain` hasMany `Concept`
- `Concept` belongsTo `Domain`
- `Concept` hasMany `GeneratedQuestion`
- `GeneratedQuestion` belongsTo `Concept`

---

*Dernière mise à jour : 12/05/2026*  
*Auteur : [Hassan]*