<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Nouveau concept
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-800 border border-slate-700 rounded-xl">
                <div class="p-6">
                    <form method="POST" action="{{ route('domains.concepts.store', $domain) }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="title" value="Titre" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <div>
                            <x-input-label for="explanation" value="Explication" />
                            <textarea id="explanation" name="explanation" rows="6" class="mt-1 block w-full border-slate-600 bg-slate-700 text-white placeholder-slate-400 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('explanation') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('explanation')" />
                        </div>

                        <div>
                            <x-input-label for="difficulty" value="Difficulté" />
                            <select id="difficulty" name="difficulty" class="mt-1 block w-full border-slate-600 bg-slate-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="junior" {{ old('difficulty', 'junior') === 'junior' ? 'selected' : '' }}>Junior</option>
                                <option value="mid" {{ old('difficulty') === 'mid' ? 'selected' : '' }}>Mid</option>
                                <option value="senior" {{ old('difficulty') === 'senior' ? 'selected' : '' }}>Senior</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('difficulty')" />
                        </div>

                        <div>
                            <x-input-label for="status" value="Statut" />
                            <select id="status" name="status" class="mt-1 block w-full border-slate-600 bg-slate-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="to_review" {{ old('status', 'to_review') === 'to_review' ? 'selected' : '' }}>À revoir</option>
                                <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>En cours</option>
                                <option value="mastered" {{ old('status') === 'mastered' ? 'selected' : '' }}>Maîtrisé</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>Créer</x-primary-button>
                            <a href="{{ route('domains.concepts.index', $domain) }}">
                                <x-secondary-button type="button">Annuler</x-secondary-button>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>