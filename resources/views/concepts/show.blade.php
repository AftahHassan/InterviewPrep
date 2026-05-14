<x-app-layout>
    <div class="max-w-7xl mx-auto">

        <div class="mb-6">
            <a href="{{ route('domains.concepts.index', $domain) }}" class="inline-flex items-center gap-1.5 text-sm text-slate-400 hover:text-white transition-colors duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Retour aux concepts
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

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-400 text-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <div class="flex gap-8">

            <div class="flex-1 min-w-0">
                <div class="bg-slate-800/50 backdrop-blur border border-slate-700/50 rounded-2xl p-8">
                    <div class="flex items-center gap-3 mb-6">
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

                    <div>
                        @if ($concept->explanation)
                            <p class="text-slate-300 whitespace-pre-wrap leading-relaxed">{{ $concept->explanation }}</p>
                        @else
                            <p class="text-slate-500 italic">Aucune explication pour le moment.</p>
                        @endif
                    </div>

                    <div class="mt-8 flex items-center gap-3 pt-6 border-t border-slate-700/50">
                        <a href="{{ route('domains.concepts.edit', [$domain, $concept]) }}"
                           class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl transition-all duration-200 shadow-lg shadow-indigo-600/25">
                            Modifier
                        </a>
                        <form method="POST" action="{{ route('domains.concepts.destroy', [$domain, $concept]) }}" onsubmit="return confirm('Confirmer la suppression ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-4 py-2 text-sm font-medium text-red-400 hover:text-red-300 bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 hover:border-red-500/30 rounded-xl transition-all duration-200">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="w-96 shrink-0">
                <div class="bg-slate-800/50 backdrop-blur border border-slate-700/50 rounded-2xl p-6 mb-6">
                    <h3 class="text-base font-semibold text-white mb-4">Générer des questions</h3>
                    <p class="text-sm text-slate-400 mb-4">Génère 5 questions d'entretien sur ce concept avec l'IA.</p>
                    <form method="POST" action="{{ route('generated-questions.store', $concept) }}">
                        @csrf
                        <button type="submit"
                                class="w-full px-4 py-3 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl transition-all duration-200 shadow-lg shadow-indigo-600/25">
                            Générer des questions d'entretien
                        </button>
                    </form>
                </div>

                @if ($concept->generatedQuestions->isNotEmpty())
                    <div>
                        <h3 class="text-base font-semibold text-white mb-4">Historique des générations</h3>

                        @foreach ($concept->generatedQuestions as $gq)
                            <div class="bg-slate-800/50 backdrop-blur border border-slate-700/50 rounded-2xl p-6 mb-4">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-xs text-slate-500">{{ $gq->created_at->format('d/m/Y H:i') }}</span>
                                    <form method="POST" action="{{ route('generated-questions.destroy', $gq) }}" onsubmit="return confirm('Supprimer cette génération ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-xs font-medium text-red-400 hover:text-red-300 transition-colors duration-200">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                                <ol class="space-y-3">
                                    @foreach ($gq->questions as $index => $question)
                                        <li class="flex gap-3 text-sm text-slate-300">
                                            <span class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-500/20 border border-indigo-500/30 text-indigo-400 text-xs font-bold shrink-0 mt-0.5">
                                                {{ $index + 1 }}
                                            </span>
                                            <span>{{ $question }}</span>
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>

    </div>
</x-app-layout>
