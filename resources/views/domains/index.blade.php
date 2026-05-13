<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mes domaines
            </h2>
            <a href="{{ route('domains.create') }}">
                <x-primary-button>Nouveau domaine</x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @forelse ($domains as $domain)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <span class="w-4 h-4 rounded-full" style="background-color: {{ $domain->color }}"></span>
                            <a href="{{ route('domains.concepts.index', $domain) }}" class="text-lg font-medium text-gray-900 hover:text-indigo-600">{{ $domain->name }}</a>
                            <span class="text-sm text-gray-500">
                                {{ $domain->concepts_count }} concepts · {{ $domain->mastered_concepts_count }} maîtrisés
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('domains.edit', $domain) }}">
                                <x-secondary-button>Modifier</x-secondary-button>
                            </a>
                            <form method="POST" action="{{ route('domains.destroy', $domain) }}" onsubmit="return confirm('Confirmer la suppression ?')">
                                @csrf
                                @method('DELETE')
                                <x-danger-button>Supprimer</x-danger-button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-gray-500">
                        Aucun domaine pour le moment.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
