<x-app-layout>
    <div class="max-w-7xl mx-auto">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white">Mes domaines</h1>
                <p class="text-slate-400 mt-1">{{ $domains->count() }} domaine{{ $domains->count() !== 1 ? 's' : '' }} au total</p>
            </div>
            <a href="{{ route('domains.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl transition-all duration-200 shadow-lg shadow-indigo-600/25">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Nouveau domaine
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

        @forelse ($domains as $domain)
            <div class="group bg-slate-800/50 backdrop-blur border border-slate-700/50 rounded-2xl p-6 mb-4 hover:border-indigo-500/50 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <span class="w-4 h-4 rounded-full shrink-0" style="background-color: {{ $domain->color }}"></span>
                        <a href="{{ route('domains.concepts.index', $domain) }}" class="text-lg font-semibold text-slate-200 group-hover:text-indigo-400 transition-colors duration-200">
                            {{ $domain->name }}
                        </a>
                        <span class="text-sm text-slate-500">
                            {{ $domain->concepts_count }} concept{{ $domain->concepts_count !== 1 ? 's' : '' }}
                            @if ($domain->mastered_concepts_count)
                                · {{ $domain->mastered_concepts_count }} maîtrisé{{ $domain->mastered_concepts_count !== 1 ? 's' : '' }}
                            @endif
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('domains.edit', $domain) }}"
                           class="px-3 py-1.5 text-sm font-medium text-slate-400 hover:text-white bg-slate-800/50 hover:bg-slate-700/50 border border-slate-700/50 hover:border-slate-600 rounded-xl transition-all duration-200">
                            Modifier
                        </a>
                        <form method="POST" action="{{ route('domains.destroy', $domain) }}" onsubmit="return confirm('Confirmer la suppression ?')">
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
        @endforelse

    </div>
</x-app-layout>
