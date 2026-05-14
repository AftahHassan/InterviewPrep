<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ $concept->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('domains.concepts.index', $domain) }}" class="text-sm text-indigo-400 hover:text-indigo-300">← Retour aux concepts</a>
            </div>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-900/40 border border-green-700 rounded-xl text-green-300">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-900/40 border border-red-700 rounded-xl text-red-300">
                    {{ session('error') }}
                </div>
            @endif
            </div>

            <div class="bg-slate-800 border border-slate-700 rounded-xl">
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium @switch($concept->status) @case('to_review') bg-red-900/40 text-red-300 @break @case('in_progress') bg-yellow-900/40 text-yellow-300 @break @case('mastered') bg-green-900/40 text-green-300 @break @endswitch">
                            {{ $concept->statusLabel }}
                        </span>

                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium @switch($concept->difficulty) @case('junior') bg-blue-900/40 text-blue-300 @break @case('mid') bg-orange-900/40 text-orange-300 @break @case('senior') bg-purple-900/40 text-purple-300 @break @endswitch">
                            {{ $concept->difficultyLabel }}
                        </span>
                    </div>

                    <div>
                        @if ($concept->explanation)
                            <p class="text-slate-300 whitespace-pre-wrap">{{ $concept->explanation }}</p>
                        @else
                            <p class="text-slate-500 italic">Aucune explication pour le moment.</p>
                        @endif
                    </div>

                    <div class="mt-8">
                        <form method="POST" action="{{ route('generated-questions.store', $concept) }}">
                            @csrf
                            <x-primary-button>Générer des questions d'entretien</x-primary-button>
                        </form>
                    </div>

                    <div class="mt-8 flex items-center gap-4">
                        <a href="{{ route('domains.concepts.edit', [$domain, $concept]) }}">
                            <x-primary-button>Modifier</x-primary-button>
                        </a>
                        <form method="POST" action="{{ route('domains.concepts.destroy', [$domain, $concept]) }}" onsubmit="return confirm('Confirmer la suppression ?')">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>Supprimer</x-danger-button>
                        </form>
                    </div>
                </div>
            </div>

            @if ($concept->generatedQuestions->isNotEmpty())
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-white mb-4">Historique des générations</h3>

                    @foreach ($concept->generatedQuestions as $gq)
                        <div class="bg-slate-800 border border-slate-700 rounded-xl p-6 mb-4">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-sm text-slate-400">{{ $gq->created_at->format('d/m/Y H:i') }}</span>
                                <form method="POST" action="{{ route('generated-questions.destroy', $gq) }}" onsubmit="return confirm('Supprimer cette génération ?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button>Supprimer</x-danger-button>
                                </form>
                            </div>
                            <ol class="list-decimal list-inside space-y-2">
                                @foreach ($gq->questions as $question)
                                    <li class="text-slate-300">{{ $question }}</li>
                                @endforeach
                            </ol>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>