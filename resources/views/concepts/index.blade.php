<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
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
                <a href="{{ route('domains.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">← Retour aux domaines</a>
            </div>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <form method="GET" class="mb-6 flex items-end gap-4">
                <div>
                    <x-input-label for="status" value="Statut" />
                    <select id="status" name="status" class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Tous</option>
                        <option value="to_review" @selected($statusFilter === 'to_review')>À revoir</option>
                        <option value="in_progress" @selected($statusFilter === 'in_progress')>En cours</option>
                        <option value="mastered" @selected($statusFilter === 'mastered')>Maîtrisé</option>
                    </select>
                </div>

                <div>
                    <x-input-label for="difficulty" value="Difficulté" />
                    <select id="difficulty" name="difficulty" class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
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
                        <a href="{{ route('domains.concepts.index', $domain) }}" class="text-sm text-gray-600 hover:text-gray-900">Réinitialiser</a>
                    </div>
                @endif
            </form>

            @forelse ($concepts as $concept)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('domains.concepts.show', [$domain, $concept]) }}" class="text-lg font-medium text-gray-900 hover:text-indigo-600">
                                    {{ $concept->title }}
                                </a>

                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium @switch($concept->status) @case('to_review') bg-red-100 text-red-800 @break @case('in_progress') bg-yellow-100 text-yellow-800 @break @case('mastered') bg-green-100 text-green-800 @break @endswitch">
                                    {{ $concept->statusLabel }}
                                </span>

                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium @switch($concept->difficulty) @case('junior') bg-blue-100 text-blue-800 @break @case('mid') bg-orange-100 text-orange-800 @break @case('senior') bg-purple-100 text-purple-800 @break @endswitch">
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

                        <div class="mt-3 flex items-center gap-2 text-sm text-gray-500">
                            <span>Changer le statut :</span>
                            <form method="POST" action="{{ route('domains.concepts.updateStatus', [$domain, $concept]) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                    <option value="to_review" @selected($concept->status === 'to_review')>À revoir</option>
                                    <option value="in_progress" @selected($concept->status === 'in_progress')>En cours</option>
                                    <option value="mastered" @selected($concept->status === 'mastered')>Maîtrisé</option>
                                </select>
                                <button type="submit" class="text-indigo-600 hover:text-indigo-900 font-medium">OK</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-gray-500">
                        Aucun concept pour ce domaine.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
