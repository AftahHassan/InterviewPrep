<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} — Prépare ton entretien technique</title>

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
                <div class="flex items-center gap-3 mb-8">
                    <svg class="w-10 h-10 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                    </svg>
                    <span class="text-xl font-bold text-white">InterviewPrep</span>
                </div>

                <h1 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white via-indigo-200 to-indigo-400 mb-4 leading-tight">
                    Prépare ton entretien technique
                </h1>

                <p class="text-lg text-slate-400 mb-12 max-w-lg">
                    Organise tes connaissances par domaine, suis ta progression et génère des questions d'entretien avec l'intelligence artificielle.
                </p>

                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-indigo-600/20 border border-indigo-500/20 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold">Organise tes domaines</h3>
                            <p class="text-sm text-slate-400 mt-1">Structure tes connaissances par domaine technique et garde une vue d'ensemble claire.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-indigo-600/20 border border-indigo-500/20 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold">Maîtrise tes concepts</h3>
                            <p class="text-sm text-slate-400 mt-1">Ajoute des explications, suis ta progression du statut "à revoir" à "maîtrisé".</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-indigo-600/20 border border-indigo-500/20 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold">Génère des questions AI</h3>
                            <p class="text-sm text-slate-400 mt-1">Entraîne-toi avec des questions d'entretien générées automatiquement par intelligence artificielle.</p>
                        </div>
                    </div>
                </div>
            </div>

            <p class="relative z-10 mt-16 text-sm text-slate-600">© {{ date('Y') }} InterviewPrep. Gratuit. Sans engagement.</p>
        </div>

        <div class="w-2/5 bg-white p-16 flex flex-col justify-center items-center">
            <div class="max-w-sm w-full">
                <div class="text-center mb-10">
                    <div class="w-16 h-16 rounded-2xl bg-indigo-600 flex items-center justify-center mx-auto mb-6 shadow-lg shadow-indigo-600/25">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-800">Bienvenue</h2>
                    <p class="text-slate-500 mt-2">Connecte-toi ou crée un compte pour commencer.</p>
                </div>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="flex items-center justify-center gap-2 w-full px-6 py-3 text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl transition-all duration-200 shadow-lg shadow-indigo-600/25">
                            Accéder au tableau de bord
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center justify-center w-full px-6 py-3 text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl transition-all duration-200 shadow-lg shadow-indigo-600/25">
                            Se connecter
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="flex items-center justify-center w-full px-6 py-3 mt-4 text-base font-semibold text-slate-700 border-2 border-slate-200 hover:border-slate-300 rounded-xl transition-all duration-200">
                                Créer un compte
                            </a>
                        @endif

                        <p class="mt-8 text-center text-xs text-slate-400">
                            Gratuit. Sans engagement. Commence en 30 secondes.
                        </p>
                    @endauth
                @endif
            </div>
        </div>

    </div>

</body>
</html>
