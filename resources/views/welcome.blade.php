<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} — Prépare ton entretien technique</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            *, ::before, ::after { box-sizing: border-box; margin: 0; padding: 0; }
            body { font-family: Figtree, ui-sans-serif, system-ui, sans-serif; }
        </style>
    @endif
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 min-h-screen text-slate-300">

    <header class="max-w-6xl mx-auto px-6 py-6 flex items-center justify-between">
        <a href="/" class="flex items-center gap-2">
            <svg class="w-7 h-7 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
            </svg>
            <span class="text-xl font-bold text-white">InterviewPrep</span>
        </a>

        <nav class="flex items-center gap-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-5 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2 text-sm font-medium text-slate-300 hover:text-white transition">Se connecter</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition">S'inscrire</a>
                    @endif
                @endauth
            @endif
        </nav>
    </header>

    <main class="max-w-6xl mx-auto px-6">
        <section class="flex flex-col items-center text-center pt-20 pb-16">
            <h1 class="text-5xl sm:text-6xl font-bold text-white mb-4">InterviewPrep</h1>
            <p class="text-xl sm:text-2xl text-slate-400 mb-10 max-w-xl">Prépare ton entretien technique Laravel</p>
            <div class="flex items-center gap-4">
                @guest
                    <a href="{{ route('register') }}" class="px-8 py-3 text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-lg shadow-indigo-600/25 transition">Commencer gratuitement</a>
                    <a href="{{ route('login') }}" class="px-8 py-3 text-base font-semibold text-slate-300 border border-slate-600 hover:border-slate-500 rounded-lg transition">Se connecter</a>
                @else
                    <a href="{{ route('dashboard') }}" class="px-8 py-3 text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-lg shadow-indigo-600/25 transition">Accéder au tableau de bord</a>
                @endguest
            </div>
        </section>

        <section class="grid md:grid-cols-3 gap-6 pb-24">
            <div class="bg-slate-800 border border-slate-700 rounded-xl p-6 text-center">
                <div class="w-12 h-12 bg-indigo-600/20 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Organise tes domaines</h3>
                <p class="text-sm text-slate-400">Structure tes connaissances par domaine technique et garde une vue d'ensemble claire.</p>
            </div>

            <div class="bg-slate-800 border border-slate-700 rounded-xl p-6 text-center">
                <div class="w-12 h-12 bg-indigo-600/20 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Maîtrise tes concepts</h3>
                <p class="text-sm text-slate-400">Ajoute des explications, suis ta progression et passe du statut "à revoir" à "maîtrisé".</p>
            </div>

            <div class="bg-slate-800 border border-slate-700 rounded-xl p-6 text-center">
                <div class="w-12 h-12 bg-indigo-600/20 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Génère des questions AI</h3>
                <p class="text-sm text-slate-400">Entraîne-toi avec des questions générées automatiquement par intelligence artificielle.</p>
            </div>
        </section>
    </main>

    <footer class="max-w-6xl mx-auto px-6 pb-8 text-center text-sm text-slate-500">
        &copy; {{ date('Y') }} InterviewPrep.
    </footer>

</body>
</html>