<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
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
                <div class="mb-4 p-4 bg-green-900/30 border border-green-700 text-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @forelse ($domains as $domain)
                <div class="bg-slate-800 border border-slate-700 rounded-xl mb-4">
                    <div class="p-6 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <span class="w-4 h-4 rounded-full" style="background-color: {{ $domain->color }}"></span>
                            <a href="{{ route('domains.concepts.index', $domain) }}" class="text-lg font-medium text-slate-200 hover:text-indigo-400">{{ $domain->name }}</a>
                            <span class="text-sm text-slate-400">
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
                <div class="bg-slate-800 border border-slate-700 rounded-xl">
                    <div class="p-6 text-center text-slate-400">
                        Aucun domaine pour le moment.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>