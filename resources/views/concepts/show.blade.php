<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $concept->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('domains.concepts.index', $domain) }}" class="text-sm text-indigo-600 hover:text-indigo-900">← Retour aux concepts</a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium @switch($concept->status) @case('to_review') bg-red-100 text-red-800 @break @case('in_progress') bg-yellow-100 text-yellow-800 @break @case('mastered') bg-green-100 text-green-800 @break @endswitch">
                            {{ $concept->statusLabel }}
                        </span>

                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium @switch($concept->difficulty) @case('junior') bg-blue-100 text-blue-800 @break @case('mid') bg-orange-100 text-orange-800 @break @case('senior') bg-purple-100 text-purple-800 @break @endswitch">
                            {{ $concept->difficultyLabel }}
                        </span>
                    </div>

                    <div class="prose max-w-none">
                        @if ($concept->explanation)
                            <p class="text-gray-700 whitespace-pre-wrap">{{ $concept->explanation }}</p>
                        @else
                            <p class="text-gray-400 italic">Aucune explication pour le moment.</p>
                        @endif
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
        </div>
    </div>
</x-app-layout>
