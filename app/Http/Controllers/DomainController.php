<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Http\Requests\StoreDomainRequest;
use App\Http\Requests\UpdateDomainRequest;

class DomainController extends Controller
{
    const COLORS = ['#6366f1', '#10b981', '#f59e0b', '#f43f5e', '#06b6d4', '#8b5cf6'];

    public function index()
    {
        $domains = auth()->user()->domains()
            ->withCount([
                'concepts',
                'concepts as mastered_concepts_count' => fn ($q) => $q->where('status', 'mastered'),
            ])
            ->get();

        return view('domains.index', compact('domains'));
    }

    public function create()
    {
        $colors = self::COLORS;

        return view('domains.create', compact('colors'));
    }

    public function store(StoreDomainRequest $request)
    {
        auth()->user()->domains()->create($request->validated());

        return redirect()->route('domains.index')
            ->with('success', 'Domaine créé avec succès.');
    }

    public function edit(Domain $domain)
    {
        abort_if($domain->user_id !== auth()->id(), 403);

        $colors = self::COLORS;

        return view('domains.edit', compact('domain', 'colors'));
    }

    public function update(UpdateDomainRequest $request, Domain $domain)
    {
        abort_if($domain->user_id !== auth()->id(), 403);

        $domain->update($request->validated());

        return redirect()->route('domains.index')
            ->with('success', 'Domaine mis à jour avec succès.');
    }

    public function destroy(Domain $domain)
    {
        abort_if($domain->user_id !== auth()->id(), 403);

        $domain->delete();

        return redirect()->route('domains.index')
            ->with('success', 'Domaine supprimé avec succès.');
    }
}
