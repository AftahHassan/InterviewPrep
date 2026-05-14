<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} — Connexion</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            *, ::before, ::after { box-sizing: border-box; margin: 0; padding: 0; }
            body { font-family: Figtree, ui-sans-serif, system-ui, sans-serif; }
        </style>
    @endif
</head>
<body class="font-sans antialiased">

    <div class="flex min-h-screen">

        <div class="w-3/5 bg-slate-950 p-16 flex flex-col justify-center relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-indigo-500/50 to-transparent"></div>

            <div class="relative z-10 max-w-xl">
                <a href="/" class="flex items-center gap-3 mb-8">
                    <svg class="w-10 h-10 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                    </svg>
                    <span class="text-xl font-bold text-white">InterviewPrep</span>
                </a>

                <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white via-indigo-200 to-indigo-400 mb-4 leading-tight">
                    Prépare ton entretien technique
                </h1>

                <p class="text-lg text-slate-400 max-w-lg">
                    Organise tes connaissances, suis ta progression et génère des questions d'entretien avec l'IA.
                </p>

                <div class="mt-10 flex items-center gap-3 text-sm text-slate-500">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Gratuit. Sans engagement.</span>
                </div>
            </div>

            <p class="relative z-10 mt-16 text-sm text-slate-600">© {{ date('Y') }} InterviewPrep</p>
        </div>

        <div class="w-2/5 bg-white p-16 flex flex-col justify-center items-center">
            <div class="max-w-sm w-full">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-slate-800">Connexion</h2>
                    <p class="text-slate-500 mt-1">Connecte-toi à ton compte.</p>
                </div>

                @if (session('status'))
                    <div class="mb-6 p-4 bg-indigo-50 border border-indigo-200 rounded-xl text-sm text-indigo-700">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-5">
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                               class="block w-full px-4 py-3 rounded-xl border border-slate-300 text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 @error('email') border-red-400 @enderror"
                               placeholder="exemple@email.com">
                        @error('email')
                            <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">Mot de passe</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               class="block w-full px-4 py-3 rounded-xl border border-slate-300 text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 @error('password') border-red-400 @enderror"
                               placeholder="••••••••">
                        @error('password')
                            <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-sm text-slate-600">Se souvenir de moi</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="w-full px-6 py-3 text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl transition-all duration-200 shadow-lg shadow-indigo-600/25">
                        Se connecter
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-slate-500">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 transition">S'inscrire</a>
                </p>
            </div>
        </div>

    </div>

</body>
</html>
