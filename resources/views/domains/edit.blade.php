<x-app-layout>
    <div class="max-w-lg mx-auto">

        <div class="mb-8">
            <a href="{{ route('domains.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-400 hover:text-white transition-colors duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Retour aux domaines
            </a>
        </div>

        <div class="bg-slate-800/50 backdrop-blur border border-slate-700/50 rounded-2xl p-8">
            <h1 class="text-2xl font-bold text-white mb-8">Modifier le domaine</h1>

            <form method="POST" action="{{ route('domains.update', $domain) }}" class="space-y-6">
                @csrf
                @method('patch')

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-300 mb-1.5">Nom du domaine</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $domain->name) }}" required autofocus
                           class="block w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 @error('name') border-red-500/50 @enderror"
                           placeholder="ex : Laravel, Vue.js, DevOps…">
                    @error('name')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-3">Couleur</label>
                    <div class="flex gap-3 flex-wrap">
                        @foreach ($colors as $color)
                            <label class="cursor-pointer group">
                                <input type="radio" name="color" value="{{ $color }}" class="sr-only peer" {{ old('color', $domain->color) === $color ? 'checked' : '' }} required>
                                <span class="block w-10 h-10 rounded-full border-2 border-transparent peer-checked:border-white peer-checked:ring-2 peer-checked:ring-indigo-500/50 group-hover:scale-110 transition-all duration-200" style="background-color: {{ $color }}"></span>
                            </label>
                        @endforeach
                    </div>
                    @error('color')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                            class="px-6 py-3 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl transition-all duration-200 shadow-lg shadow-indigo-600/25">
                        Mettre à jour
                    </button>
                    <a href="{{ route('domains.index') }}"
                       class="px-6 py-3 text-sm font-medium text-slate-400 hover:text-white border border-slate-700 hover:border-slate-600 rounded-xl transition-all duration-200">
                        Annuler
                    </a>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
