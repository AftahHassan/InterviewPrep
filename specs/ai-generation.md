# Spec — Appel Groq API + sauvegarde + historique

## Contexte donné à l'agent

Intégration de l'API Groq pour générer des questions d'entretien depuis la page détail d'un concept. Le modèle `GeneratedQuestion`, la migration et les relations Eloquent existent déjà. Il faut créer le controller, les routes, et mettre à jour la vue show.

## Plan validé

1. Créer `GeneratedQuestionController` avec `store()` et `destroy()`
2. Ajouter les routes POST `concepts/{concept}/questions` et DELETE `generated-questions/{generatedQuestion}`
3. Ajouter `load('generatedQuestions')` dans `ConceptController@show`
4. Mettre à jour `show.blade.php` : bouton génération + historique des générations
5. Créer `specs/ai-generation.md`

## Ce que je NE voulais PAS

- Pas de package externe — `Http::` facade Laravel natif uniquement
- Pas de clé API dans le code — uniquement `env('GROQ_API_KEY')`
- Pas de page blanche si l'API échoue
- Pas de queue/job — appel synchrone
- Pas de AJAX — formulaire POST simple
- Pas de `$guarded = []`

## Ce que l'agent a généré

- `app/Http/Controllers/GeneratedQuestionController.php` — controller avec store() et destroy()
- `routes/web.php` — 2 routes ajoutées (POST + DELETE)
- `app/Http/Controllers/ConceptController.php` — eager loading generatedQuestions
- `resources/views/concepts/show.blade.php` — bouton génération + historique
- `specs/ai-generation.md` — ce fichier

## Ce que j'ai modifié manuellement

_(à remplir après review)_
