<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Concept;
use App\Http\Requests\StoreConceptRequest;
use App\Http\Requests\UpdateConceptRequest;
use Illuminate\Http\Request;

class ConceptController extends Controller
{
    public function index(Domain $domain)
    {
        abort_if($domain->user_id !== auth()->id(), 403);

        $concepts = $domain->concepts()
            ->with('domain')
            ->when(request('status'), fn ($q) => $q->where('status', request('status')))
            ->when(request('difficulty'), fn ($q) => $q->where('difficulty', request('difficulty')))
            ->get();

        return view('concepts.index', [
            'domain' => $domain,
            'concepts' => $concepts,
            'statusFilter' => request('status'),
            'difficultyFilter' => request('difficulty'),
        ]);
    }

    public function create(Domain $domain)
    {
        abort_if($domain->user_id !== auth()->id(), 403);

        return view('concepts.create', compact('domain'));
    }

    public function store(StoreConceptRequest $request, Domain $domain)
    {
        abort_if($domain->user_id !== auth()->id(), 403);

        $domain->concepts()->create($request->validated());

        return redirect()->route('domains.concepts.index', $domain)
            ->with('success', 'Concept créé avec succès.');
    }

    public function show(Domain $domain, Concept $concept)
    {
        abort_if($domain->user_id !== auth()->id(), 403);

        return view('concepts.show', compact('domain', 'concept'));
    }

    public function edit(Domain $domain, Concept $concept)
    {
        abort_if($domain->user_id !== auth()->id(), 403);

        return view('concepts.edit', compact('domain', 'concept'));
    }

    public function update(UpdateConceptRequest $request, Domain $domain, Concept $concept)
    {
        abort_if($domain->user_id !== auth()->id(), 403);

        $concept->update($request->validated());

        return redirect()->route('domains.concepts.index', $domain)
            ->with('success', 'Concept mis à jour avec succès.');
    }

    public function destroy(Domain $domain, Concept $concept)
    {
        abort_if($domain->user_id !== auth()->id(), 403);

        $concept->delete();

        return redirect()->route('domains.concepts.index', $domain)
            ->with('success', 'Concept supprimé avec succès.');
    }

    public function updateStatus(Request $request, Domain $domain, Concept $concept)
    {
        abort_if($domain->user_id !== auth()->id(), 403);

        $request->validate([
            'status' => ['required', 'in:to_review,in_progress,mastered'],
        ]);

        $concept->update(['status' => $request->status]);

        return redirect()->back()
            ->with('success', 'Statut mis à jour.');
    }
}
