# Spec — CRUD Concepts

## Date
Mercredi 14/05/2026

## User Stories couvertes
- US5  — Liste des concepts d'un domaine avec filtre par statut
- US6  — Créer un concept (titre, explication, difficulté, statut)
- US7  — Voir le détail d'un concept
- US8  — Modifier un concept
- US9  — Changer le statut rapidement depuis la liste
- US10 — Supprimer un concept

---

## Ce que j'ai expliqué à l'agent

J'ai ouvert Claude Code et j'ai écrit ceci :

> "Je travaille sur InterviewPrep, une application Laravel 11.
> Je veux construire la gestion complète des concepts.
> Un concept appartient à un domaine.
> Il a : un titre, une explication (texte long), un niveau de difficulté
> (junior/mid/senior) et un statut (to_review/in_progress/mastered).
>
> Points importants :
> 1. Les statuts et niveaux doivent s'afficher en français avec des accessors
>    Eloquent dans le modèle (statusLabel et difficultyLabel)
> 2. Je veux pouvoir changer le statut directement depuis la liste
>    sans ouvrir le formulaire — via un petit formulaire POST
> 3. Je veux un filtre par statut sur la liste (query string ?status=)
> 4. Toutes les validations dans des Form Request classes
>
> Je NE veux PAS de requête SQL brute.
> Je NE veux PAS de $guarded = [].
> Je NE veux PAS de rechargement Ajax — un simple formulaire POST suffit.
> Commence par me proposer un plan SANS générer de code."

---

## Plan que l'agent a proposé

1. Créer la migration `create_concepts_table`
   avec : id, domain_id, title, explanation, difficulty (enum),
   status (enum), deleted_at (soft delete), timestamps
2. Créer le modèle `Concept` avec :
   - `$fillable` explicite
   - `SoftDeletes` trait
   - Relation `belongsTo(Domain::class)`
   - Relation `hasMany(GeneratedQuestion::class)`
   - Accessor `statusLabel` pour les labels français
   - Accessor `difficultyLabel` pour les labels français
3. Créer `StoreConceptRequest` et `UpdateConceptRequest`
4. Créer `ConceptController` avec les 7 méthodes RESTful
5. Ajouter une route PATCH séparée pour le changement de statut rapide
6. Créer les vues Blade avec le filtre par statut
7. Dans `index()`, filtrer par `?status=` si présent dans l'URL

J'ai validé ce plan sans modification.

---

## Ce que je NE voulais PAS
(précisé à l'agent avant génération)

- Pas de `$guarded = []` — toujours `$fillable` explicite
- Pas de requête SQL brute — Eloquent uniquement
- Pas de rechargement Ajax pour le changement de statut
  (un formulaire POST simple avec redirection suffit)
- Pas de champ "tags"
- Pas de pagination
- Pas de champ "ressources externes" ou "liens"
- Pas d'éditeur de texte riche pour l'explication
  (un simple textarea suffit)

---

## Ce que l'agent a généré

### Migration
```
database/migrations/xxxx_create_concepts_table.php
```

Contenu généré :
```php
Schema::create('concepts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('domain_id')->constrained()->onDelete('cascade');
    $table->string('title');
    $table->text('explanation')->nullable();
    $table->enum('difficulty', ['junior', 'mid', 'senior'])->default('junior');
    $table->enum('status', ['to_review', 'in_progress', 'mastered'])
          ->default('to_review');
    $table->softDeletes();
    $table->timestamps();
});
```

### Modèle
```
app/Models/Concept.php
```

Contenu généré par l'agent (syntaxe Laravel 8 — j'ai dû corriger) :
```php
// Généré par l'agent — MAUVAISE syntaxe pour Laravel 11
public function getStatusLabelAttribute(): string
{
    return match($this->status) {
        'to_review'   => 'À revoir',
        'in_progress' => 'En cours',
        'mastered'    => 'Maîtrisé',
        default       => $this->status,
    };
}
```

### Form Requests
```
app/Http/Requests/StoreConceptRequest.php
app/Http/Requests/UpdateConceptRequest.php
```

### Controller
```
app/Http/Controllers/ConceptController.php
```

Méthodes générées : index, create, store, show, edit, update, destroy
+ méthode `updateStatus()` pour le changement rapide

### Vues Blade
```
resources/views/concepts/index.blade.php
resources/views/concepts/show.blade.php
resources/views/concepts/create.blade.php
resources/views/concepts/edit.blade.php
```

### Routes ajoutées dans web.php
```php
Route::resource('domains.concepts', ConceptController::class)
     ->middleware('auth');

Route::patch('concepts/{concept}/status', [ConceptController::class, 'updateStatus'])
     ->name('concepts.updateStatus')
     ->middleware('auth');
```

---

## Ce que j'ai modifié manuellement après génération

### 1. Correction des accessors — syntaxe Laravel 11

L'agent avait utilisé l'ancienne syntaxe Laravel 8
avec `getStatusLabelAttribute()`. En Laravel 11 on utilise
`Attribute::make()`. J'ai corrigé les deux accessors :

**Avant (généré par l'agent) :**
```php
public function getStatusLabelAttribute(): string
{
    return match($this->status) {
        'to_review'   => 'À revoir',
        'in_progress' => 'En cours',
        'mastered'    => 'Maîtrisé',
        default       => $this->status,
    };
}

public function getDifficultyLabelAttribute(): string
{
    return match($this->difficulty) {
        'junior' => 'Junior',
        'mid'    => 'Mid',
        'senior' => 'Senior',
        default  => $this->difficulty,
    };
}
```

**Après (corrigé manuellement pour Laravel 11) :**
```php
use Illuminate\Database\Eloquent\Casts\Attribute;

protected function statusLabel(): Attribute
{
    return Attribute::make(
        get: fn () => match($this->status) {
            'to_review'   => 'À revoir',
            'in_progress' => 'En cours',
            'mastered'    => 'Maîtrisé',
            default       => $this->status,
        }
    );
}

protected function difficultyLabel(): Attribute
{
    return Attribute::make(
        get: fn () => match($this->difficulty) {
            'junior' => 'Junior',
            'mid'    => 'Mid',
            'senior' => 'Senior',
            default  => $this->difficulty,
        }
    );
}
```

### 2. Ajout de la vérification d'autorisation

Comme pour les domaines, l'agent avait oublié de vérifier
que le concept appartient bien à l'utilisateur connecté.
J'ai ajouté la vérification dans `show`, `edit`, `update`,
`destroy` et `updateStatus` :

```php
// Ajouté manuellement
if ($concept->domain->user_id !== auth()->id()) {
    abort(403);
}
```

### 3. Amélioration du filtre dans index()

L'agent avait généré un filtre basique.
J'ai ajouté le filtre combiné statut + difficulté (bonus) :

**Avant (généré par l'agent) :**
```php
public function index(Domain $domain)
{
    $concepts = $domain->concepts()
        ->when(request('status'), fn($q) => $q->where('status', request('status')))
        ->get();

    return view('concepts.index', compact('domain', 'concepts'));
}
```

**Après (ajout du filtre par difficulté) :**
```php
public function index(Domain $domain)
{
    $concepts = $domain->concepts()
        ->when(request('status'), fn($q) =>
            $q->where('status', request('status')))
        ->when(request('difficulty'), fn($q) =>
            $q->where('difficulty', request('difficulty')))
        ->get();

    return view('concepts.index', compact('domain', 'concepts'));
}
```

### 4. Badges de couleur dans la vue

L'agent avait juste affiché le texte du statut sans mise en forme.
J'ai ajouté des badges colorés dans `index.blade.php` :

```html
{{-- Ajouté manuellement --}}
@php
    $statusColor = [
        'to_review'   => 'bg-red-100 text-red-800',
        'in_progress' => 'bg-yellow-100 text-yellow-800',
        'mastered'    => 'bg-green-100 text-green-800',
    ][$concept->status] ?? 'bg-gray-100 text-gray-800';
@endphp

<span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
    {{ $concept->status_label }}
</span>
```

### 5. Traduction des messages de validation

```php
// Traduit manuellement
'title.required'      => 'Le titre est obligatoire.',
'title.max'           => 'Le titre ne peut pas dépasser 255 caractères.',
'difficulty.required' => 'Le niveau de difficulté est obligatoire.',
'difficulty.in'       => 'Le niveau doit être junior, mid ou senior.',
'status.in'           => 'Le statut choisi est invalide.',
```

---

## Observations

- La syntaxe des accessors change entre les versions de Laravel.
  L'agent génère souvent l'ancienne syntaxe — toujours vérifier
- La vérification d'autorisation est oubliée à chaque feature
  → en faire un réflexe systématique
- Le filtre combiné (bonus) n'était pas dans le plan initial,
  je l'ai ajouté moi-même sans demander à l'agent

---

## Résultat final

- Liste des concepts avec badges de statut colorés
- Filtre par statut ET par difficulté depuis l'URL
- Changement de statut rapide depuis la liste (1 clic)
- Création avec tous les champs
- Modification fonctionne
- Suppression fonctionne (soft delete)
- Accessors statusLabel et difficultyLabel fonctionnels en français
- Sécurité : vérification d'appartenance sur toutes les routes

---

## Commit associé

```
feat(concepts): add CRUD with status accessors, quick status update,
combined filter — [AI: Claude Code]
```