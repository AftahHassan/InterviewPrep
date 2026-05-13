<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nouveau domaine
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('domains.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" value="Nom du domaine" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label value="Couleur" />
                            <div class="mt-2 flex gap-3">
                                @foreach ($colors as $color)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="color" value="{{ $color }}" class="sr-only peer" {{ old('color', '#6366f1') === $color ? 'checked' : '' }} required>
                                        <span class="block w-10 h-10 rounded-full border-2 border-transparent peer-checked:border-gray-800 peer-focus-visible:ring-2 peer-focus-visible:ring-indigo-500" style="background-color: {{ $color }}"></span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('color')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>Créer</x-primary-button>
                            <a href="{{ route('domains.index') }}">
                                <x-secondary-button type="button">Annuler</x-secondary-button>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
