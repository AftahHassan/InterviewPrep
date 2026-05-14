<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
                Concepts — {{ $domain->name }}
            </h2>
            <a href="{{ route('domains.concepts.create', $domain) }}">
                <x-primary-button>Nouveau concept</x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('domains.index') }}" class="text-sm text-indigo-400 hover:text-indigo-300">← Retour aux domaines</a>
            </div>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-900/30 border border-green-700 text-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <form method="GET" class="mb-6 flex flex-wrap items-end gap-4">
                <div>
                    <x-input-label for="status" value="Statut" />
                    <select id="status" name="status" class="mt-1 border-slate-600 bg-slate-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Tous</option>
                        <option value="to_review" @selected($statusFilter === 'to_review')>À revoir</option>
                        <option value="in_progress" @selected($statusFilter === 'in_progress')>En cours</option>
                        <option value="mastered" @selected($statusFilter === 'mastered')>Maîtrisé</option>
                    </select>
                </div>

                <div>
                    <x-input-label for="difficulty" value="Difficulté" />
                    <select id="difficulty" name="difficulty" class="mt-1 border-slate-600 bg-slate-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Tous</option>
                        <option value="junior" @selected($difficultyFilter === 'junior')>Junior</option>
                        <option value="mid" @selected($difficultyFilter === 'mid')>Mid</option>
                        <option value="senior" @selected($difficultyFilter === 'senior')>Senior</option>
                    </select>
                </div>

                <div>
                    <x-primary-button>Filtrer</x-primary-button>
                </div>

                @if ($statusFilter || $difficultyFilter)
                    <div>
                        <a href="{{ route('domains.concepts.index', $domain) }}" class="text-sm text-slate-400 hover:text-slate-200">Réinitialiser</a>
                    </div>
                @endif
            </form>

            @forelse ($concepts as $concept)
                <div class="bg-slate-800 border border-slate-700 rounded-xl mb-4">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('domains.concepts.show', [$domain, $concept]) }}" class="text-lg font-medium text-slate-200 hover:text-indigo-400">
                                    {{ $concept->title }}
                                </a>

                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium @switch($concept->status) @case('to_review') bg-red-900/40 text-red-300 @break @case('in_progress') bg-yellow-900/40 text-yellow-300 @break @case('mastered') bg-green-900/40 text-green-300 @break @endswitch">
                                    {{ $concept->statusLabel }}
                                </span>

                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium @switch($concept->difficulty) @case('junior') bg-blue-900/40 text-blue-300 @break @case('mid') bg-orange-900/40 text-orange-300 @break @case('senior') bg-purple-900/40 text-purple-300 @break @endswitch">
                                    {{ $concept->difficultyLabel }}
                                </span>
                            </div>

                            <div class="flex items-center gap-2">
                                <a href="{{ route('domains.concepts.edit', [$domain, $concept]) }}">
                                    <x-secondary-button>Modifier</x-secondary-button>
                                </a>
                                <form method="POST" action="{{ route('domains.concepts.destroy', [$domain, $concept]) }}" onsubmit="return confirm('Confirmer la suppression ?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button>Supprimer</x-danger-button>
                                </form>
                            </div>
                        </div>

                        <div class="mt-3 flex items-center gap-2 text-sm text-slate-400">
                            <span>Changer le statut :</span>
                            <form method="POST" action="{{ route('domains.concepts.updateStatus', [$domain, $concept]) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="border-slate-600 bg-slate-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                    <option value="to_review" @selected($concept->status === 'to_review')>À revoir</option>
                                    <option value="in_progress" @selected($concept->status === 'in_progress')>En cours</option>
                                    <option value="mastered" @selected($concept->status === 'mastered')>Maîtrisé</option>
                                </select>
                                <button type="submit" class="text-indigo-400 hover:text-indigo-300 font-medium">OK</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-slate-800 border border-slate-700 rounded-xl">
                    <div class="p-6 text-center text-slate-400">
                        Aucun concept pour ce domaine.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>