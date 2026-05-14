<x-app-layout>
    <div class="max-w-7xl mx-auto">

        <div class="flex items-center justify-between mb-6">
            <div>
                <a href="{{ route('domains.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-400 hover:text-white transition-colors duration-200 mb-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    Retour aux domaines
                </a>
                <div class="flex items-center gap-3">
                    <span class="w-3.5 h-3.5 rounded-full shrink-0" style="background-color: {{ $domain->color }}"></span>
                    <h1 class="text-3xl font-bold text-white">{{ $domain->name }}</h1>
                </div>
                <p class="text-slate-400 mt-1">{{ $concepts->count() }} concept{{ $concepts->count() !== 1 ? 's' : '' }}</p>
            </div>
            <a href="{{ route('domains.concepts.create', $domain) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl transition-all duration-200 shadow-lg shadow-indigo-600/25">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Nouveau concept
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400 text-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <form method="GET" class="mb-8 flex flex-wrap items-end gap-4 p-4 bg-slate-800/30 border border-slate-700/50 rounded-2xl">
            <div>
                <label for="status" class="block text-sm font-medium text-slate-400 mb-1.5">Statut</label>
                <select id="status" name="status" class="px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200">
                    <option value="">Tous</option>
                    <option value="to_review" @selected($statusFilter === 'to_review')>À revoir</option>
                    <option value="in_progress" @selected($statusFilter === 'in_progress')>En cours</option>
                    <option value="mastered" @selected($statusFilter === 'mastered')>Maîtrisé</option>
                </select>
            </div>

            <div>
                <label for="difficulty" class="block text-sm font-medium text-slate-400 mb-1.5">Difficulté</label>
                <select id="difficulty" name="difficulty" class="px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200">
                    <option value="">Tous</option>
                    <option value="junior" @selected($difficultyFilter === 'junior')>Junior</option>
                    <option value="mid" @selected($difficultyFilter === 'mid')>Mid</option>
                    <option value="senior" @selected($difficultyFilter === 'senior')>Senior</option>
                </select>
            </div>

            <div>
                <button type="submit"
                        class="px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl transition-all duration-200">
                    Filtrer
                </button>
            </div>

            @if ($statusFilter || $difficultyFilter)
                <div>
                    <a href="{{ route('domains.concepts.index', $domain) }}" class="text-sm text-slate-400 hover:text-white transition-colors duration-200">
                        Réinitialiser
                    </a>
                </div>
            @endif
        </form>

        @forelse ($concepts as $concept)
            <div class="bg-slate-800/50 backdrop-blur border border-slate-700/50 rounded-2xl p-6 mb-4 hover:border-indigo-500/50 transition-all duration-200">
                <div class="flex items-start justify-between">
                    <div class="space-y-2">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('domains.concepts.show', [$domain, $concept]) }}" class="text-lg font-semibold text-slate-200 hover:text-indigo-400 transition-colors duration-200">
                                {{ $concept->title }}
                            </a>

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border
                                @switch($concept->status)
                                    @case('to_review') bg-red-500/20 text-red-400 border-red-500/30 @break
                                    @case('in_progress') bg-yellow-500/20 text-yellow-400 border-yellow-500/30 @break
                                    @case('mastered') bg-green-500/20 text-green-400 border-green-500/30 @break
                                @endswitch">
                                {{ $concept->statusLabel }}
                            </span>

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border
                                @switch($concept->difficulty)
                                    @case('junior') bg-blue-500/20 text-blue-400 border-blue-500/30 @break
                                    @case('mid') bg-orange-500/20 text-orange-400 border-orange-500/30 @break
                                    @case('senior') bg-purple-500/20 text-purple-400 border-purple-500/30 @break
                                @endswitch">
                                {{ $concept->difficultyLabel }}
                            </span>
                        </div>

                        <div class="flex items-center gap-2 text-sm text-slate-500">
                            <span>Changer le statut :</span>
                            <form method="POST" action="{{ route('domains.concepts.updateStatus', [$domain, $concept]) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="px-3 py-1.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200">
                                    <option value="to_review" @selected($concept->status === 'to_review')>À revoir</option>
                                    <option value="in_progress" @selected($concept->status === 'in_progress')>En cours</option>
                                    <option value="mastered" @selected($concept->status === 'mastered')>Maîtrisé</option>
                                </select>
                                <button type="submit"
                                        class="px-3 py-1.5 text-sm font-medium text-indigo-400 hover:text-indigo-300 bg-indigo-500/10 hover:bg-indigo-500/20 border border-indigo-500/20 hover:border-indigo-500/30 rounded-xl transition-all duration-200">
                                    OK
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ route('domains.concepts.edit', [$domain, $concept]) }}"
                           class="px-3 py-1.5 text-sm font-medium text-slate-400 hover:text-white bg-slate-800/50 hover:bg-slate-700/50 border border-slate-700/50 hover:border-slate-600 rounded-xl transition-all duration-200">
                            Modifier
                        </a>
                        <form method="POST" action="{{ route('domains.concepts.destroy', [$domain, $concept]) }}" onsubmit="return confirm('Confirmer la suppression ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-1.5 text-sm font-medium text-red-400 hover:text-red-300 bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 hover:border-red-500/30 rounded-xl transition-all duration-200">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-slate-800/50 backdrop-blur border border-slate-700/50 rounded-2xl p-12 text-center">
                <div class="w-16 h-16 rounded-2xl bg-indigo-600/20 border border-indigo-500/20 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <p class="text-slate-400 mb-6">Aucun concept pour ce domaine.</p>
                <a href="{{ route('domains.concepts.create', $domain) }}"
                   class="inline-flex items-center gap-2 px-6 py-3 text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl transition-all duration-200 shadow-lg shadow-indigo-600/25">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Créer mon premier concept
                </a>
            </div>
        @endforelse

    </div>
</x-app-layout>
