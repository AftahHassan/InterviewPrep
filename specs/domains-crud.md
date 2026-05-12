# Spec — CRUD Domains

## Date
Mardi 13/05/2026

## User Stories couvertes
- US2 — Liste de mes domaines avec compteurs
- US3 — Créer un domaine avec nom et couleur
- US4 — Modifier et supprimer un domaine

---

## Ce que j'ai expliqué à l'agent

J'ai ouvert Claude Code et j'ai écrit ceci :

> "Je travaille sur InterviewPrep, une application Laravel 11.
> Je veux construire la gestion complète des domaines techniques.
> Un domaine appartient à un utilisateur connecté.
> Il a un nom (ex: Laravel ORM) et une couleur de badge.
> La liste doit afficher pour chaque domaine :
> le nombre total de concepts et le nombre de concepts maîtrisés.
> Je veux un CRUD complet : liste, création, modification, suppression.
> Toutes les validations doivent être dans des Form Request classes.
> Je NE veux PAS de pagination.
> Je NE veux PAS de champ couleur en texte libre.
> Commence par me proposer un plan SANS générer de code."

---

## Plan que l'agent a proposé

1. Créer la migration `create_domains_table`
   avec les colonnes : id, user_id, name, color, timestamps
2. Créer le modèle `Domain` avec :
   - `$fillable` = ['name', 'color', 'user_id']
   - relation `belongsTo(User::class)`
   - relation `hasMany(Concept::class)`
3. Créer `StoreDomainRequest` avec règles de validation
4. Créer `UpdateDomainRequest` avec règles de validation
5. Créer `DomainController` avec les 7 méthodes RESTful
6. Ajouter les routes dans `web.php` avec middleware `auth`
7. Créer les vues Blade :
   - `domains/index.blade.php` — liste avec compteurs
   - `domains/create.blade.php` — formulaire création
   - `domains/edit.blade.php` — formulaire modification
8. Utiliser `withCount()` pour les compteurs de concepts

J'ai demandé une modification au plan :
ajouter le compteur de concepts "maîtrisés" séparément
en plus du compteur total. L'agent a mis à jour le plan
pour utiliser `withCount(['concepts as mastered_count' => ...])`.

---

## Ce que je NE voulais PAS
(précisé à l'agent avant génération)

- Pas de `$guarded = []` — toujours `$fillable` explicite
- Pas de champ couleur en input texte libre
  (l'utilisateur choisit parmi une palette fixe)
- Pas de suppression automatique en cascade des concepts
  sans confirmation
- Pas de pagination sur la liste
- Pas de tri par nom — ordre de création suffit
- Pas de recherche par nom de domaine

---

## Ce que l'agent a généré

### Migration
```
database/migrations/xxxx_create_domains_table.php
```

Contenu généré :
```php
Schema::create('domains', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('name');
    $table->string('color')->default('#6366f1');
    $table->timestamps();
});
```

### Modèle
```
app/Models/Domain.php
```

Contenu généré :
```php
protected $fillable = ['name', 'color', 'user_id'];

public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}

public function concepts(): HasMany
{
    return $this->hasMany(Concept::class);
}
```

### Form Requests
```
app/Http/Requests/StoreDomainRequest.php
app/Http/Requests/UpdateDomainRequest.php
```

Règles générées :
```php
public function rules(): array
{
    return [
        'name'  => 'required|string|max:255',
        'color' => 'required|string|max:7',
    ];
}
```

### Controller
```
app/Http/Controllers/DomainController.php
```

Méthodes générées : index, create, store, show, edit, update, destroy

### Vues Blade
```
resources/views/domains/index.blade.php
resources/views/domains/create.blade.php
resources/views/domains/edit.blade.php
```

### Routes ajoutées dans web.php
```php
Route::resource('domains', DomainController::class)->middleware('auth');
```

---

## Ce que j'ai modifié manuellement après génération

### 1. Ajout de la vérification d'autorisation

L'agent avait oublié de vérifier que le domaine appartient
à l'utilisateur connecté. N'importe quel utilisateur connecté
pouvait modifier ou supprimer le domaine d'un autre.

J'ai ajouté cette vérification dans `edit`, `update` et `destroy` :

```php
// Ajouté manuellement dans edit(), update(), destroy()
if ($domain->user_id !== auth()->id()) {
    abort(403);
}
```

### 2. Remplacement de l'input couleur

L'agent avait généré un `<input type="text">` pour la couleur.
J'ai remplacé par des boutons radio avec des cercles de couleur
en Blade + Tailwind :

```html
<!-- Généré par l'agent (supprimé) -->
<input type="text" name="color" value="#6366f1">

<!-- Remplacé manuellement par -->
<div class="flex gap-3">
    @foreach(['#6366f1','#14b8a6','#f59e0b','#ef4444','#10b981','#8b5cf6'] as $c)
        <label class="cursor-pointer">
            <input type="radio" name="color" value="{{ $c }}" class="hidden"
                {{ old('color', $domain->color ?? '#6366f1') === $c ? 'checked' : '' }}>
            <span class="block w-8 h-8 rounded-full border-4"
                  style="background-color: {{ $c }}"></span>
        </label>
    @endforeach
</div>
```

### 3. Correction du compteur de concepts maîtrisés

L'agent avait écrit ceci dans le controller :
```php
$domains = Domain::withCount('concepts')->get();
```

J'ai corrigé pour avoir les deux compteurs séparément :
```php
$domains = auth()->user()->domains()
    ->withCount('concepts')
    ->withCount(['concepts as mastered_count' => function ($query) {
        $query->where('status', 'mastered');
    }])
    ->get();
```

### 4. Confirmation avant suppression

L'agent n'avait pas ajouté de confirmation avant suppression.
J'ai ajouté un attribut `onclick` sur le bouton supprimer :

```html
<button onclick="return confirm('Supprimer ce domaine et tous ses concepts ?')"
        form="delete-form-{{ $domain->id }}">
    Supprimer
</button>
```

### 5. Traduction des messages de validation

```php
// Avant (généré par l'agent en anglais)
'name.required' => 'The name field is required.'

// Après (traduit manuellement)
'name.required' => 'Le nom du domaine est obligatoire.'
'name.max'      => 'Le nom ne peut pas dépasser 255 caractères.'
'color.required' => 'Veuillez choisir une couleur.'
```

---

## Observations

- L'agent oublie systématiquement la vérification d'autorisation
  (est-ce que la ressource appartient à l'utilisateur connecté ?)
  — toujours vérifier manuellement
- Le withCount pour les sous-ensembles filtrés (maîtrisés seulement)
  est une syntaxe que l'agent ne génère pas spontanément
- Les messages de validation sont toujours en anglais par défaut

---

## Résultat final

- Liste des domaines avec badge de couleur, nb total de concepts
  et nb de concepts maîtrisés
- Création avec sélecteur de couleur visuel
- Modification fonctionne
- Suppression avec confirmation fonctionne
- Sécurité : un utilisateur ne peut pas toucher aux domaines d'un autre

---

## Commit associé

```
feat(domains): add full CRUD with color picker, concept counters,
auth check — [AI: Claude Code]
```