# Spec — Génération AI de questions d'entretien

## Date
Jeudi 15/05/2026

## User Stories couvertes
- US11 — Générer 5 questions d'entretien depuis la page détail d'un concept
- US12 — Voir l'historique des générations pour un concept
- US13 — Supprimer une génération

---

## Ce que j'ai expliqué à l'agent

J'ai ouvert Claude Code et j'ai écrit ceci :

> "Je travaille sur InterviewPrep, une application Laravel 11.
> Je veux intégrer l'API Groq pour générer automatiquement
> 5 questions d'entretien techniques.
>
> Voici comment ça doit fonctionner :
> - L'utilisateur est sur la page détail d'un concept
> - Il clique sur un bouton 'Générer des questions'
> - L'application appelle l'API Groq avec le titre et l'explication du concept
> - L'API renvoie 5 questions
> - On sauvegarde ces 5 questions en base AVANT de les afficher
> - L'utilisateur voit les questions générées et peut consulter
>   l'historique de toutes les générations passées pour ce concept
> - Il peut supprimer une génération dont il n'a plus besoin
>
> Contraintes techniques IMPORTANTES :
> - L'appel API se fait UNIQUEMENT avec Http:: facade Laravel natif
> - ZERO package externe (pas de SDK Groq, pas de SDK OpenAI)
> - La clé API doit être dans .env uniquement, jamais dans le code
> - Si l'API ne répond pas, afficher un message d'erreur propre
>   (pas une page blanche, pas un stack trace)
> - Les questions sont stockées en JSON dans la base de données
>
> Je NE veux PAS de traitement en arrière-plan (queue/job).
> Je NE veux PAS de streaming de la réponse.
> Commence par me proposer un plan SANS générer de code."

---

## Plan que l'agent a proposé

1. Créer la migration `create_generated_questions_table`
   avec : id, concept_id (FK), questions (JSON), timestamps
2. Créer le modèle `GeneratedQuestion` avec `belongsTo(Concept)`
3. Ajouter `hasMany(GeneratedQuestion)` dans le modèle `Concept`
4. Créer `GeneratedQuestionController` avec :
   - `store()` — appel API + sauvegarde + redirection
   - `destroy()` — suppression d'une génération
5. Construire le prompt à envoyer à Groq
6. Appeler l'API avec `Http::withHeaders()->post()`
7. Parser la réponse et extraire les 5 questions
8. Sauvegarder en base puis rediriger vers la page du concept
9. Mettre à jour la vue `concepts/show.blade.php` pour afficher
   le bouton de génération et l'historique
10. Ajouter les routes dans `web.php`

J'ai demandé une modification :
ajouter la gestion d'erreur explicite dans le plan
(l'agent ne l'avait pas mentionnée). Il a mis à jour le plan
pour inclure un bloc try/catch avec message flash en cas d'erreur.

---

## Ce que je NE voulais PAS
(précisé à l'agent avant génération)

- Pas de package externe — Http:: facade natif uniquement
- Pas de clé API dans le code source ou dans config/services.php
  commitée — uniquement dans .env
- Pas d'affichage des questions sans sauvegarde préalable en base
- Pas de page blanche en cas d'erreur API
- Pas de génération en tâche de fond (queue)
- Pas de streaming de la réponse
- Pas de modification du prompt par l'utilisateur depuis l'interface

---

## Ce que l'agent a généré

### Migration
```
database/migrations/xxxx_create_generated_questions_table.php
```

Contenu généré :
```php
Schema::create('generated_questions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('concept_id')->constrained()->onDelete('cascade');
    $table->json('questions');
    $table->timestamps();
});
```

### Modèle
```
app/Models/GeneratedQuestion.php
```

Contenu généré :
```php
protected $fillable = ['concept_id', 'questions'];

protected $casts = [
    'questions' => 'array',
];

public function concept(): BelongsTo
{
    return $this->belongsTo(Concept::class);
}
```

### Controller
```
app/Http/Controllers/GeneratedQuestionController.php
```

Contenu généré par l'agent :
```php
public function store(Concept $concept)
{
    $prompt = "Generate 5 interview questions about: " . $concept->title;

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
    ])->post('https://api.groq.com/openai/v1/chat/completions', [
        'model'    => 'llama3-8b-8192',
        'messages' => [['role' => 'user', 'content' => $prompt]],
    ]);

    $questions = json_decode($response->json()['choices'][0]['message']['content'], true);

    GeneratedQuestion::create([
        'concept_id' => $concept->id,
        'questions'  => $questions,
    ]);

    return redirect()->route('concepts.show', $concept);
}
```

### Vue mise à jour
```
resources/views/concepts/show.blade.php
```
Ajout du bouton de génération et de la liste des générations passées.

### Routes ajoutées dans web.php
```php
Route::post('concepts/{concept}/questions', [GeneratedQuestionController::class, 'store'])
     ->name('generated-questions.store')
     ->middleware('auth');

Route::delete('generated-questions/{generatedQuestion}', [GeneratedQuestionController::class, 'destroy'])
     ->name('generated-questions.destroy')
     ->middleware('auth');
```

---

## Ce que j'ai modifié manuellement après génération

### 1. Réécriture complète du prompt

Le prompt généré par l'agent était trop vague et donnait
des questions génériques. Je l'ai réécrit entièrement
pour obtenir des questions de qualité :

**Avant (généré par l'agent) :**
```php
$prompt = "Generate 5 interview questions about: " . $concept->title;
```

**Après (réécrit manuellement) :**
```php
$prompt = "Tu es un expert en entretiens techniques pour développeurs web.
Génère exactement 5 questions d'entretien techniques sur le concept suivant.

Concept : " . $concept->title . "
Explication : " . $concept->explanation . "
Niveau visé : " . $concept->difficulty_label . "

Les questions doivent être précises, techniques et réalistes
(questions qu'un recruteur poserait vraiment en entretien).

Réponds UNIQUEMENT avec un tableau JSON de 5 strings.
Exemple : [\"Question 1 ?\", \"Question 2 ?\", \"Question 3 ?\"]
Ne rajoute rien d'autre. Pas d'introduction. Pas d'explication.";
```

### 2. Ajout du try/catch complet

L'agent avait généré un try/catch vide qui ne faisait rien.
J'ai écrit la gestion d'erreur complète :

**Avant (généré par l'agent) :**
```php
try {
    // appel API...
} catch (\Exception $e) {
    // vide
}
```

**Après (écrit manuellement) :**
```php
try {
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
        'Content-Type'  => 'application/json',
    ])->timeout(30)
      ->post('https://api.groq.com/openai/v1/chat/completions', [
        'model'    => 'llama3-8b-8192',
        'messages' => [['role' => 'user', 'content' => $prompt]],
    ]);

    if ($response->failed()) {
        return back()->with('error', 'L\'API n\'a pas répondu. Réessaie dans quelques secondes.');
    }

    $content = $response->json()['choices'][0]['message']['content'] ?? null;

    if (!$content) {
        return back()->with('error', 'La réponse de l\'API était vide.');
    }

    $questions = json_decode($content, true);

    if (!is_array($questions) || count($questions) === 0) {
        return back()->with('error', 'Les questions générées n\'étaient pas au bon format.');
    }

    GeneratedQuestion::create([
        'concept_id' => $concept->id,
        'questions'  => $questions,
    ]);

    return redirect()
        ->route('concepts.show', [$concept->domain, $concept])
        ->with('success', '5 questions générées avec succès !');

} catch (\Exception $e) {
    return back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
}
```

### 3. Ajout du header Content-Type manquant

L'agent avait oublié le header `Content-Type: application/json`.
Sans ce header, l'API Groq retournait une erreur 400.

```php
// Ajouté manuellement
'Content-Type' => 'application/json',
```

### 4. Ajout du timeout

L'agent n'avait pas mis de timeout. Si l'API est lente,
la requête pouvait bloquer indéfiniment.

```php
// Ajouté manuellement
->timeout(30)
```

### 5. Vérification d'autorisation

L'agent avait oublié de vérifier que le concept appartient
à l'utilisateur connecté avant de générer les questions :

```php
// Ajouté manuellement dans store() et destroy()
if ($concept->domain->user_id !== auth()->id()) {
    abort(403);
}
```

---

## Observations

- Le prompt est la partie la plus importante — l'agent génère
  toujours un prompt trop vague. C'est à moi de le rédiger
- La gestion d'erreur générée par l'agent était inutilisable
  (catch vide) — toujours réécrire le try/catch manuellement
- Le header Content-Type est souvent oublié par l'agent
- Le timeout est toujours oublié par l'agent
- La vérification d'autorisation est encore une fois oubliée

---

## Résultat final

- Bouton "Générer des questions" sur la page détail d'un concept
- 5 questions techniques générées par l'API Groq
- Questions sauvegardées en base avant affichage
- Historique de toutes les générations visible sur la page
- Chaque génération peut être supprimée
- Message d'erreur propre si l'API ne répond pas
- Sécurité : vérification d'appartenance du concept

---

## Fichier .env (clé à ajouter — jamais committée)

```env
GROQ_API_KEY=gsk_xxxxxxxxxxxxxxxxxxxxxxxx
```

---

## Commit associé

```
feat(ai): add Groq API integration with Http facade, error handling,
history view — [AI: Claude Code]
```