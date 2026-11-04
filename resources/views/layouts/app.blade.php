<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Presente</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f5f9f7] text-slate-800 antialiased">
    <div class="min-h-screen pb-20 lg:pl-72 lg:pb-0">
        {{-- Navegación lateral de escritorio --}}
        <aside class="fixed inset-y-0 left-0 z-30 hidden w-72 flex-col border-r border-[#e4eee9] bg-white lg:flex">
            <div class="flex h-24 items-center border-b border-[#edf3ef] px-7">
                <a href="{{ url('/') }}" class="group inline-flex items-center gap-3">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#168d6b] text-white shadow-lg shadow-emerald-900/10 transition group-hover:-translate-y-0.5">
                        <svg viewBox="0 0 32 32" class="h-7 w-7" fill="none" aria-hidden="true">
                            <path d="M10 5H7a2 2 0 0 0-2 2v3M22 5h3a2 2 0 0 1 2 2v3M5 22v3a2 2 0 0 0 2 2h3M27 22v3a2 2 0 0 1-2 2h-3" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
                            <path d="m10 16 4 4 8-9" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="block">
                        <span class="block text-xl font-extrabold tracking-tight text-slate-800">Presente</span>
                        <span class="mt-0.5 block text-[10px] font-bold tracking-[0.16em] text-[#8ba197]">ASISTENCIA UNIVERSITARIA</span>
                    </span>
                </a>
            </div>

            <div class="px-6 pb-2 pt-7">
                <p class="px-2 text-[10px] font-bold uppercase tracking-[0.18em] text-slate-400">Espacio de trabajo</p>
            </div>

            <nav class="flex-1 space-y-2 px-4 py-3" aria-label="Navegación principal">
                @if (auth()->user()->role === 'teacher')
                    <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-2xl bg-[#effbf6] px-4 py-3 text-sm font-semibold text-[#127257] ring-1 ring-inset ring-[#d8f5e7] transition hover:bg-[#e4f8ed]">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white text-[#168d6b] shadow-sm">
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m3.5 10 8.5-7 8.5 7M5.5 9v11h13V9M9 20v-6h6v6"/>
                            </svg>
                        </span>
                        Inicio
                    </a>
                    @include('teacher.teacher-menu')
                @else
                    @include('student.student-menu')
                @endif
            </nav>

            <div class="border-t border-[#edf3ef] p-4">
                @include('layouts.profile-menu', [
                    'triggerClass' => 'flex w-full items-center gap-3 rounded-2xl px-3 py-3 text-left text-sm font-semibold text-slate-600 transition hover:bg-[#f2faf5] hover:text-[#127257]',
                    'avatarSizeClass' => 'h-9 w-9',
                    'showLabel' => true,
                    'menuPosition' => 'bottom-full left-0 mb-2 w-full',
                ])
            </div>
        </aside>

        {{-- Cabecera --}}
        <header class="sticky top-0 z-20 border-b border-[#e4eee9]/90 bg-white/90 backdrop-blur-xl lg:h-24">
            <div class="flex h-16 items-center justify-between px-4 sm:px-6 lg:h-24 lg:px-9">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-lg font-extrabold tracking-tight text-[#127257] lg:hidden">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#168d6b] text-white">
                        <svg viewBox="0 0 32 32" class="h-5 w-5" fill="none" aria-hidden="true">
                            <path d="M10 5H7a2 2 0 0 0-2 2v3M22 5h3a2 2 0 0 1 2 2v3M5 22v3a2 2 0 0 0 2 2h3M27 22v3a2 2 0 0 1-2 2h-3" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
                            <path d="m10 16 4 4 8-9" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    Presente
                </a>

                <div class="hidden lg:block">
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Tu espacio académico</p>
                    <h1 class="mt-1 text-xl font-semibold text-slate-700">
                        Hola, <span class="font-extrabold text-[#168d6b]">{{ auth()->user()->name ?? 'Profesor' }}</span>
                    </h1>
                </div>

                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="inline-flex items-center gap-2 rounded-2xl border border-[#e4eee9] bg-white px-3 py-2 text-xs font-semibold text-slate-500 shadow-sm sm:px-4 sm:text-sm">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 text-[#168d6b]" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <circle cx="12" cy="12" r="9"/>
                            <path stroke-linecap="round" d="M12 7v5l3 2"/>
                        </svg>
                        <span class="hidden sm:inline" id="current-date">{{ now()->format('d/m/Y') }}</span>
                        <span class="font-bold text-[#168d6b]" id="current-time">{{ now()->format('H:i') }}</span>
                    </div>

                    <div class="lg:hidden">
                        @include('layouts.profile-menu', [
                            'triggerClass' => 'inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#eaf8f0] text-sm font-bold text-[#127257] transition hover:bg-[#d8f5e7]',
                            'avatarSizeClass' => 'h-10 w-10',
                            'menuPosition' => 'right-0 top-full mt-2 w-52',
                        ])
                    </div>
                </div>
            </div>
        </header>

        {{-- Contenido de cada pantalla --}}
        <main class="min-h-[calc(100vh-4rem)] px-4 py-6 sm:px-6 lg:min-h-[calc(100vh-6rem)] lg:px-9 lg:py-8">
            @yield('content')
        </main>

        {{-- Navegación móvil --}}
        <nav
    class="fixed inset-x-0 bottom-0 z-30 border-t border-[#e4eee9] bg-white/95 px-2 py-2 shadow-[0_-8px_28px_rgba(30,70,54,0.06)] backdrop-blur-xl lg:hidden"
    aria-label="Navegación móvil"
>
    @if (auth()->user()->role === 'teacher')
        <div class="mx-auto grid max-w-md grid-cols-3 gap-1.5">
            @include('teacher.teacher-menu')
        </div>
    @else
        <div class="mx-auto grid max-w-lg grid-cols-4 gap-1">
            @include('student.student-menu')
        </div>
    @endif
</nav>
    </div>
</body>
</html>
