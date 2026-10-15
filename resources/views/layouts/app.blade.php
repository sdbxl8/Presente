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
                @if (auth()->user()->role === 'teacher')
                    <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-xl bg-sky-50 px-4 py-3 text-sm font-semibold text-sky-700">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-sky-600 text-xs text-white">I</span>
                        Inicio
                    </a>
                    @include('teacher.teacher-menu')
                @else
                    @include('student.student-menu')
                @endif
            </nav>

            <div class="border-t border-slate-200 p-4">
                @include('layouts.profile-menu', [
                    'triggerClass' => 'flex w-full items-center gap-3 rounded-xl px-4 py-3 text-left text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-sky-700',
                    'avatarSizeClass' => 'h-9 w-9',
                    'showLabel' => true,
                    'menuPosition' => 'bottom-full left-0 mb-2 w-full',
                ])
            </div>
        </aside>

        <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/95 backdrop-blur lg:h-20">
            <div class="flex h-16 items-center justify-between px-4 sm:px-6 lg:h-20 lg:px-10">
                <a href="{{ url('/') }}" class="text-xl font-bold tracking-tight text-sky-700 lg:hidden">Presente</a>

                <div class="hidden lg:block">
                    <h1 class="text-lg uppercase font-semibold text-slate-800">Hola,
                        <span class="font-bold text-2xl text-sky-700">{{ auth()->user()->name ?? 'Profesor' }}</span>
                    </h1>
                </div>

                <div class="flex items-center gap-2">
                    <div class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm">
                        <span class="hidden sm:inline" id="current-date">{{ now()->format('d/m/Y') }}</span>
                        <span class="font-semibold text-sky-700 " id="current-time">{{ now()->format('H:i') }}</span>
                    </div>

                    <div class="lg:hidden">
                        @include('layouts.profile-menu', [
                            'triggerClass' => 'inline-flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-sm font-bold text-slate-600 transition hover:bg-sky-50 hover:text-sky-700',
                            'avatarSizeClass' => 'h-10 w-10',
                            'menuPosition' => 'right-0 top-full mt-2 w-52',
                        ])
                    </div>
                </div>
            </div>
        </header>

        <main class="min-h-[calc(100vh-4rem)] px-4 py-6 sm:px-6 lg:min-h-[calc(100vh-5rem)] lg:px-10 lg:py-8">
            @yield('content')
        </main>

        <nav class="fixed inset-x-0 bottom-0 z-30 border-t border-slate-200 bg-white/95 px-3 py-2 backdrop-blur lg:hidden" aria-label="Navegación móvil">
            <div class="mx-auto grid max-w-md grid-cols-3 gap-2">
                @if (auth()->user()->role === 'teacher')
                    <a href="{{ route('home') }}" class="flex min-h-14 flex-col items-center justify-center gap-1 rounded-xl bg-sky-50 text-xs font-semibold text-sky-700">
                        <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-sky-600 text-xs text-white">I</span>
                        Inicio
                    </a>
                    @include('teacher.teacher-menu')
                @else
                    @include('student.student-menu')
                @endif
                @include('layouts.profile-menu', [
                    'triggerClass' => 'flex min-h-14 w-full flex-col items-center justify-center gap-1 rounded-xl text-xs font-medium text-slate-500 transition hover:bg-slate-50 hover:text-sky-700',
                    'avatarSizeClass' => 'h-6 w-6',
                    'showLabel' => true,
                    'menuPosition' => 'bottom-full right-0 mb-2 w-52',
                ])
            </div>
        </nav>
    </div>
</body>
</html>
