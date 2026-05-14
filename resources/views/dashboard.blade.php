<x-app-layout>
    <div class="max-w-7xl mx-auto">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white">Tableau de bord</h1>
            <p class="text-slate-400 mt-1">Bienvenue, {{ Auth::user()->name }}. Voici un aperçu de ta préparation.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-12">
            <div class="bg-slate-800/50 backdrop-blur border border-slate-700/50 rounded-2xl p-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-indigo-600/20 border border-indigo-500/20 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-400">Total concepts</p>
                        <p class="text-2xl font-bold text-white mt-0.5">{{ $totalConcepts }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800/50 backdrop-blur border border-slate-700/50 rounded-2xl p-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-green-500/20 border border-green-500/20 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-400">Maîtrisés</p>
                        <p class="text-2xl font-bold text-green-400 mt-0.5">{{ $masteredConcepts }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800/50 backdrop-blur border border-slate-700/50 rounded-2xl p-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-yellow-500/20 border border-yellow-500/20 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-400">En cours</p>
                        <p class="text-2xl font-bold text-yellow-400 mt-0.5">{{ $inProgressConcepts }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800/50 backdrop-blur border border-slate-700/50 rounded-2xl p-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-red-500/20 border border-red-500/20 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-400">À revoir</p>
                        <p class="text-2xl font-bold text-red-400 mt-0.5">{{ $toReviewConcepts }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-white">Mes domaines</h2>
                <a href="{{ route('domains.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Nouveau domaine
                </a>
            </div>

            @if ($domains->isEmpty())
                <div class="bg-slate-800/50 backdrop-blur border border-slate-700/50 rounded-2xl p-12 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-indigo-600/20 border border-indigo-500/20 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg>
                    </div>
                    <p class="text-slate-400 mb-6">Aucun domaine pour le moment.</p>
                    <a href="{{ route('domains.create') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl transition-all duration-200 shadow-lg shadow-indigo-600/25">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Créer mon premier domaine
                    </a>
                </div>
            @else
                <div class="grid md:grid-cols-2 gap-4">
                    @foreach ($domains as $domain)
                        <a href="{{ route('domains.concepts.index', $domain) }}"
                           class="group bg-slate-800/50 backdrop-blur border border-slate-700/50 rounded-2xl p-6 hover:border-indigo-500/50 transition-all duration-200">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="w-4 h-4 rounded-full shrink-0" style="background-color: {{ $domain->color }}"></span>
                                <span class="text-lg font-semibold text-slate-200 group-hover:text-indigo-400 transition-colors duration-200">
                                    {{ $domain->name }}
                                </span>
                            </div>
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-slate-400">
                                <span>{{ $domain->concepts_count }} concept{{ $domain->concepts_count !== 1 ? 's' : '' }}</span>
                                <span class="text-green-400">{{ $domain->mastered_count }} maîtrisé{{ $domain->mastered_count !== 1 ? 's' : '' }}</span>
                                <span class="text-yellow-400">{{ $domain->in_progress_count }} en cours</span>
                                <span class="text-red-400">{{ $domain->to_review_count }} à revoir</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
