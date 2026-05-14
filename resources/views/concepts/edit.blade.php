<x-app-layout>
    <div class="max-w-2xl mx-auto">

        <div class="mb-8">
            <a href="{{ route('domains.concepts.index', $domain) }}" class="inline-flex items-center gap-1.5 text-sm text-slate-400 hover:text-white transition-colors duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Retour aux concepts
            </a>
        </div>

        <div class="bg-slate-800/50 backdrop-blur border border-slate-700/50 rounded-2xl p-8">
            <div class="flex items-center gap-3 mb-8">
                <span class="w-3.5 h-3.5 rounded-full shrink-0" style="background-color: {{ $domain->color }}"></span>
                <h1 class="text-2xl font-bold text-white">Modifier le concept</h1>
            </div>

            <form method="POST" action="{{ route('domains.concepts.update', [$domain, $concept]) }}" class="space-y-6">
                @csrf
                @method('patch')

                <div>
                    <label for="title" class="block text-sm font-medium text-slate-300 mb-1.5">Titre</label>
                    <input id="title" name="title" type="text" value="{{ old('title', $concept->title) }}" required autofocus
                           class="block w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 @error('title') border-red-500/50 @enderror"
                           placeholder="ex : Le concept de middleware dans Laravel">
                    @error('title')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="explanation" class="block text-sm font-medium text-slate-300 mb-1.5">Explication</label>
                    <textarea id="explanation" name="explanation" rows="8"
                              class="block w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 @error('explanation') border-red-500/50 @enderror"
                              placeholder="Explique le concept en détail...">{{ old('explanation', $concept->explanation) }}</textarea>
                    @error('explanation')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="difficulty" class="block text-sm font-medium text-slate-300 mb-1.5">Difficulté</label>
                    <select id="difficulty" name="difficulty"
                            class="block w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 @error('difficulty') border-red-500/50 @enderror">
                        <option value="junior" {{ old('difficulty', $concept->difficulty) === 'junior' ? 'selected' : '' }}>Junior</option>
                        <option value="mid" {{ old('difficulty', $concept->difficulty) === 'mid' ? 'selected' : '' }}>Mid</option>
                        <option value="senior" {{ old('difficulty', $concept->difficulty) === 'senior' ? 'selected' : '' }}>Senior</option>
                    </select>
                    @error('difficulty')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-slate-300 mb-1.5">Statut</label>
                    <select id="status" name="status"
                            class="block w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 @error('status') border-red-500/50 @enderror">
                        <option value="to_review" {{ old('status', $concept->status) === 'to_review' ? 'selected' : '' }}>À revoir</option>
                        <option value="in_progress" {{ old('status', $concept->status) === 'in_progress' ? 'selected' : '' }}>En cours</option>
                        <option value="mastered" {{ old('status', $concept->status) === 'mastered' ? 'selected' : '' }}>Maîtrisé</option>
                    </select>
                    @error('status')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                            class="px-6 py-3 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl transition-all duration-200 shadow-lg shadow-indigo-600/25">
                        Mettre à jour
                    </button>
                    <a href="{{ route('domains.concepts.index', $domain) }}"
                       class="px-6 py-3 text-sm font-medium text-slate-400 hover:text-white border border-slate-700 hover:border-slate-600 rounded-xl transition-all duration-200">
                        Annuler
                    </a>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
