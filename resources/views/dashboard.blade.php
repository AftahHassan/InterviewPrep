<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8">
                <h3 class="text-2xl font-bold text-white">Bienvenue, {{ Auth::user()->name }}</h3>
                <p class="text-slate-400 mt-1">Voici un aperçu de ta préparation.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <div class="bg-slate-800 border border-slate-700 rounded-xl p-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-600/20 rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-400">Total concepts</p>
                            <p class="text-2xl font-bold text-white">{{ $totalConcepts }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800 border border-slate-700 rounded-xl p-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-600/20 rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-400">Maîtrisés</p>
                            <p class="text-2xl font-bold text-emerald-400">{{ $masteredConcepts }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800 border border-slate-700 rounded-xl p-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-amber-600/20 rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-400">En cours</p>
                            <p class="text-2xl font-bold text-amber-400">{{ $inProgressConcepts }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800 border border-slate-700 rounded-xl p-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-600/20 rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-400">À revoir</p>
                            <p class="text-2xl font-bold text-red-400">{{ $toReviewConcepts }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-xl font-semibold text-white mb-6">Mes domaines</h3>

                @if ($domains->isEmpty())
                    <div class="bg-slate-800 border border-slate-700 rounded-xl p-8 text-center">
                        <p class="text-slate-400 mb-4">Aucun domaine pour le moment.</p>
                        <a href="{{ route('domains.create') }}"
                           class="inline-flex items-center gap-2 px-6 py-3 text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition">
                            Créer mon premier domaine
                        </a>
                    </div>
                @else
                    <div class="grid md:grid-cols-2 gap-4">
                        @foreach ($domains as $domain)
                            <a href="{{ route('domains.concepts.index', $domain) }}"
                               class="bg-slate-800 border border-slate-700 rounded-xl p-5 hover:border-indigo-600/50 transition group">
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="w-3.5 h-3.5 rounded-full shrink-0" style="background-color: {{ $domain->color }}"></span>
                                    <span class="text-lg font-medium text-slate-200 group-hover:text-indigo-400 transition">
                                        {{ $domain->name }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-4 text-sm text-slate-400">
                                    <span>{{ $domain->concepts_count }} concept{{ $domain->concepts_count !== 1 ? 's' : '' }}</span>
                                    <span class="text-emerald-400">{{ $domain->mastered_count }} maîtrisé{{ $domain->mastered_count !== 1 ? 's' : '' }}</span>
                                    <span class="text-amber-400">{{ $domain->in_progress_count }} en cours</span>
                                    <span class="text-red-400">{{ $domain->to_review_count }} à revoir</span>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('domains.create') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-indigo-400 hover:text-indigo-300 border border-slate-700 hover:border-indigo-600/50 rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Nouveau domaine
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>