<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Presente</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 antialiased">
    <div class="min-h-screen pb-20 lg:pl-64 lg:pb-0">
        <aside class="fixed inset-y-0 left-0 z-30 hidden w-64 border-r border-slate-200 bg-white lg:flex lg:flex-col">
            <div class="flex h-20 items-center border-b border-slate-200 px-8">
                <a href="{{ url('/') }}" class="text-xl font-bold tracking-tight text-sky-700">Presente</a>
            </div>

            <nav class="flex-1 space-y-2 px-4 py-6" aria-label="Navegación principal">
                <a href="#" class="flex items-center gap-3 rounded-xl bg-sky-50 px-4 py-3 text-sm font-semibold text-sky-700">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-sky-600 text-xs text-white">I</span>
                    Inicio
                </a>
                <a href="#" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-sky-700">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-xs text-slate-500">M</span>
                    Menú
                </a>
            </nav>

            <div class="border-t border-slate-200 p-4">
                <button type="button" class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-left text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-sky-700" aria-label="Abrir perfil">
                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-200 text-xs font-bold text-slate-600">P</span>
                    <span>Perfil</span>
                </button>
            </div>
        </aside>

        <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/95 backdrop-blur lg:h-20">
            <div class="flex h-16 items-center justify-between px-4 sm:px-6 lg:h-20 lg:px-10">
                <a href="{{ url('/') }}" class="text-xl font-bold tracking-tight text-sky-700 lg:hidden">Presente</a>

                <div class="hidden lg:block">
                    <h1 class="text-lg font-semibold text-slate-800">Presente</h1>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" class="inline-flex h-10 items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 text-sm font-medium text-slate-600 shadow-sm transition hover:border-sky-200 hover:text-sky-700" aria-label="Abrir calendario">
                        <span class="flex h-6 w-6 items-center justify-center rounded-md bg-sky-50 text-xs text-sky-700">C</span>
                        <span class="hidden sm:inline">Calendario</span>
                    </button>

                    <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-sm font-bold text-slate-600 transition hover:bg-sky-50 hover:text-sky-700 lg:hidden" aria-label="Abrir perfil">
                        P
                    </button>
                </div>
            </div>
        </header>

        <main class="min-h-[calc(100vh-4rem)] px-4 py-6 sm:px-6 lg:min-h-[calc(100vh-5rem)] lg:px-10 lg:py-8">
            @yield('content')
        </main>

        <nav class="fixed inset-x-0 bottom-0 z-30 border-t border-slate-200 bg-white/95 px-3 py-2 backdrop-blur lg:hidden" aria-label="Navegación móvil">
            <div class="mx-auto grid max-w-md grid-cols-3 gap-2">
                <a href="#" class="flex min-h-14 flex-col items-center justify-center gap-1 rounded-xl bg-sky-50 text-xs font-semibold text-sky-700">
                    <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-sky-600 text-xs text-white">I</span>
                    Inicio
                </a>
                <a href="#" class="flex min-h-14 flex-col items-center justify-center gap-1 rounded-xl text-xs font-medium text-slate-500 transition hover:bg-slate-50 hover:text-sky-700">
                    <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-slate-100 text-xs text-slate-500">M</span>
                    Menú
                </a>
                <button type="button" class="flex min-h-14 flex-col items-center justify-center gap-1 rounded-xl text-xs font-medium text-slate-500 transition hover:bg-slate-50 hover:text-sky-700" aria-label="Abrir perfil">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-slate-200 text-xs font-bold text-slate-600">P</span>
                    Perfil
                </button>
            </div>
        </nav>
    </div>
</body>
</html>
