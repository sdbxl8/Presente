@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-7xl space-y-7 sm:space-y-8">

        {{-- Cabecera --}}
        <header class="relative overflow-hidden rounded-[2rem] border border-[#dcefe4] bg-gradient-to-br from-[#eaf8f0] via-white to-[#f1edff] p-6 sm:p-8 lg:p-10">
            <div class="pointer-events-none absolute -right-12 -top-16 h-48 w-48 rounded-full border border-[#c9ead8] sm:h-64 sm:w-64"></div>
            <div class="pointer-events-none absolute -bottom-16 right-24 h-32 w-32 rounded-full bg-[#d8f5e7]/60 blur-2xl"></div>

            <div class="relative z-10 flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
                <div class="max-w-2xl">
                    <span class="inline-flex items-center gap-2 rounded-full border border-[#c9ead8] bg-white/80 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.14em] text-[#127257]">
                        <span class="h-2 w-2 rounded-full bg-[#36b887]"></span>
                        Espacio del profesor
                    </span>

                    <h1 class="mt-5 text-3xl font-extrabold tracking-tight text-[#173d31] sm:text-4xl lg:text-5xl">
                        Tu espacio académico
                    </h1>

                    <p class="mt-3 max-w-xl text-sm leading-6 text-[#5c7c6e] sm:text-base">
                        Organiza tus clases, consulta tus grupos y revisa las solicitudes de tus alumnos desde un mismo lugar.
                    </p>
                </div>

                <button
                    type="button"
                    onclick="document.getElementById('create-class-modal').classList.remove('hidden')"
                    class="inline-flex min-h-12 shrink-0 items-center justify-center gap-2 rounded-2xl bg-[#168d6b] px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-emerald-900/10 transition hover:-translate-y-0.5 hover:bg-[#127257] focus:outline-none focus:ring-4 focus:ring-[#b5ebd2]"
                >
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>
                    </svg>
                    Crear clase
                </button>
            </div>
        </header>

        {{-- Indicadores rápidos --}}
        <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3" aria-label="Resumen académico">

            {{-- Grupos --}}
            <article class="group rounded-[1.5rem] border border-[#e3eee8] bg-white p-5 shadow-[0_14px_40px_rgba(30,70,54,0.045)] transition hover:-translate-y-0.5 hover:shadow-md sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold text-[#789287]">Mis grupos</p>
                        <p class="mt-3 text-4xl font-extrabold tracking-tight text-[#173d31]">
                            {{ $groups->count() }}
                        </p>
                        <p class="mt-2 text-xs text-[#789287]">Grupos que gestionas</p>
                    </div>

                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#eaf8f0] text-[#168d6b] transition group-hover:bg-[#d8f5e7]">
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                            <circle cx="9" cy="8" r="3.5"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 20v-1.5A4.5 4.5 0 0 1 7 14h4a4.5 4.5 0 0 1 4.5 4.5V20M16 5a3.5 3.5 0 0 1 0 6.5M18 14.5a4.5 4.5 0 0 1 3.5 4.4V20"/>
                        </svg>
                    </span>
                </div>

                <a href="{{ route('teacher.groups') }}" class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-[#168d6b] transition hover:text-[#127257]">
                    Gestionar grupos
                    <span aria-hidden="true">→</span>
                </a>
            </article>

            {{-- Sesiones en agenda --}}
            <article class="group rounded-[1.5rem] border border-[#e3eee8] bg-white p-5 shadow-[0_14px_40px_rgba(30,70,54,0.045)] transition hover:-translate-y-0.5 hover:shadow-md sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold text-[#789287]">Sesiones en agenda</p>
                        <p class="mt-3 text-4xl font-extrabold tracking-tight text-[#173d31]">
                            {{ $upcomingClasses->count() }}
                        </p>
                        <p class="mt-2 text-xs text-[#789287]">Sesiones mostradas en el resumen</p>
                    </div>

                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#f1edff] text-[#7967b5] transition group-hover:bg-[#e8e1ff]">
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                            <rect x="3.5" y="5" width="17" height="15.5" rx="2"/>
                            <path stroke-linecap="round" d="M7.5 3.5v3M16.5 3.5v3M3.5 9.5h17"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="m9 14 2 2 4-4"/>
                        </svg>
                    </span>
                </div>

                <a href="{{ route('teacher.classes') }}" class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-[#7967b5] transition hover:text-[#5e4b9d]">
                    Ver clases
                    <span aria-hidden="true">→</span>
                </a>
            </article>

            {{-- Justificantes pendientes --}}
            <article class="group rounded-[1.5rem] border border-[#f5d8c8] bg-gradient-to-br from-white to-[#fff5eb] p-5 shadow-[0_14px_40px_rgba(30,70,54,0.035)] transition hover:-translate-y-0.5 hover:shadow-md sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold text-[#98613c]">Por revisar</p>
                        <p class="mt-3 text-4xl font-extrabold tracking-tight text-[#75472c]">
                            {{ $pendingJustifications->count() }}
                        </p>
                        <p class="mt-2 text-xs text-[#a87958]">Justificantes pendientes</p>
                    </div>

                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#fff0e7] text-[#b96d48] transition group-hover:bg-[#ffe6d7]">
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 3.75h7l5 5v11.5a.75.75 0 0 1-.75.75h-11.5a.75.75 0 0 1-.75-.75v-15.75A.75.75 0 0 1 6.75 3.75Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 4v5h5M9 14h6M9 17h4"/>
                        </svg>
                    </span>
                </div>

                <a href="{{ route('teacher.justifications') }}" class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-[#b96d48] transition hover:text-[#98613c]">
                    Revisar solicitudes
                    <span aria-hidden="true">→</span>
                </a>
            </article>
        </section>

        {{-- Calendario y agenda --}}
        <section class="grid min-w-0 grid-cols-1 items-start gap-5 xl:grid-cols-[minmax(0,1.65fr)_minmax(19rem,0.85fr)] xl:gap-6">

            {{-- Calendario --}}
            <div class="min-w-0 overflow-hidden rounded-[1.5rem] border border-[#e3eee8] bg-white p-4 shadow-[0_14px_40px_rgba(30,70,54,0.045)] sm:p-5 lg:p-6">
                <div class="mb-5 flex items-center gap-3">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#eaf8f0] text-[#168d6b]">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <rect x="3.5" y="5" width="17" height="15.5" rx="2"/>
                            <path stroke-linecap="round" d="M7.5 3.5v3M16.5 3.5v3M3.5 9.5h17"/>
                        </svg>
                    </span>

                    <div>
                        <h2 class="text-lg font-extrabold tracking-tight text-[#173d31]">
                            Calendario académico
                        </h2>
                        <p class="mt-1 text-sm text-[#789287]">
                            Consulta las sesiones programadas.
                        </p>
                    </div>
                </div>

                @include('layouts.calendar')
            </div>

            {{-- Lista de clases --}}
            <aside class="min-w-0 overflow-hidden rounded-[1.5rem] border border-[#e3eee8] bg-white shadow-[0_14px_40px_rgba(30,70,54,0.045)]">
                <div class="flex items-center justify-between gap-3 border-b border-[#edf3ef] bg-gradient-to-r from-[#effbf6] to-white px-5 py-5 sm:px-6">
                    <div>
                        <h2 class="text-lg font-extrabold tracking-tight text-[#173d31]">
                            Clases planificadas
                        </h2>
                        <p class="mt-1 text-sm text-[#789287]">
                            Tu agenda de clases
                        </p>
                    </div>

                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#168d6b] shadow-sm ring-1 ring-[#e3eee8]">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <circle cx="12" cy="12" r="9"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
                        </svg>
                    </span>
                </div>

                <div class="space-y-3 p-4 sm:p-5">
                    @forelse ($upcomingClasses as $class)
                        <article class="rounded-2xl border border-[#e3eee8] bg-white p-4 transition hover:border-[#b5ebd2] hover:bg-[#f7fbf8]">
                            <div class="flex items-start gap-3">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#eaf8f0] text-[#168d6b]">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.75A2.75 2.75 0 0 1 6.75 3H20v16H6.75A2.75 2.75 0 0 0 4 21.75z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.75v16M8 7h8M8 10.5h8"/>
                                    </svg>
                                </span>

                                <div class="min-w-0 flex-1">
                                    <h3 class="break-words text-sm font-bold leading-5 text-[#29483b]">
                                        {{ $class->subject->name }}
                                    </h3>

                                    <p class="mt-1 truncate text-xs text-[#789287]">
                                        {{ $class->subject->group->name ?? 'Grupo' }}
                                    </p>

                                    <div class="mt-3 flex flex-wrap items-center gap-x-3 gap-y-2 text-xs font-semibold text-[#5c7c6e]">
                                        <span class="inline-flex items-center gap-1.5">
                                            <svg viewBox="0 0 24 24" class="h-3.5 w-3.5 text-[#168d6b]" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                <rect x="3.5" y="5" width="17" height="15.5" rx="2"/>
                                                <path stroke-linecap="round" d="M7.5 3.5v3M16.5 3.5v3M3.5 9.5h17"/>
                                            </svg>
                                            {{ \Illuminate\Support\Carbon::parse($class->date)->format('d/m/Y') }}
                                        </span>

                                        <span class="inline-flex items-center gap-1.5">
                                            <svg viewBox="0 0 24 24" class="h-3.5 w-3.5 text-[#7967b5]" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                <circle cx="12" cy="12" r="9"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
                                            </svg>
                                            {{ substr($class->start_time, 0, 5) }} – {{ substr($class->end_time, 0, 5) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-2xl border border-dashed border-[#cfe7d9] bg-[#f7fbf8] px-4 py-8 text-center">
                            <span class="mx-auto flex h-11 w-11 items-center justify-center rounded-xl bg-white text-[#168d6b] shadow-sm">
                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <rect x="3.5" y="5" width="17" height="15.5" rx="2"/>
                                    <path stroke-linecap="round" d="M7.5 3.5v3M16.5 3.5v3M3.5 9.5h17"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 12v5M9.5 14.5h5"/>
                                </svg>
                            </span>

                            <p class="mt-3 text-sm font-bold text-[#466157]">
                                No hay clases en la agenda
                            </p>

                            <p class="mt-1 text-xs leading-5 text-[#789287]">
                                Cuando tengas sesiones planificadas, aparecerán aquí.
                            </p>
                        </div>
                    @endforelse
                </div>

                <div class="border-t border-[#edf3ef] p-4 sm:px-5">
                    <a href="{{ route('teacher.classes') }}" class="inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl border border-[#c9ead8] bg-white px-4 py-3 text-sm font-bold text-[#127257] transition hover:bg-[#effbf6] focus:outline-none focus:ring-4 focus:ring-[#d8f5e7]">
                        Ver todas las clases
                        <span aria-hidden="true">→</span>
                    </a>
                </div>
            </aside>
        </section>

        {{-- Justificantes pendientes --}}
        <section class="overflow-hidden rounded-[1.5rem] border border-[#f5d8c8] bg-white shadow-[0_14px_40px_rgba(30,70,54,0.04)]">
            <div class="flex flex-col gap-4 border-b border-[#f5e4d9] bg-gradient-to-r from-[#fff5eb] via-[#fffaf5] to-white px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-7">
                <div class="flex items-center gap-3">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#fff0e7] text-[#b96d48]">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 3.75h7l5 5v11.5a.75.75 0 0 1-.75.75h-11.5a.75.75 0 0 1-.75-.75v-15.75A.75.75 0 0 1 6.75 3.75Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 4v5h5M9 14h6M9 17h4"/>
                        </svg>
                    </span>

                    <div>
                        <h2 class="text-lg font-extrabold tracking-tight text-[#173d31]">
                            Justificantes pendientes
                        </h2>
                        <p class="mt-1 text-sm text-[#98613c]">
                            Solicitudes que requieren tu atención.
                        </p>
                    </div>
                </div>

                <span class="inline-flex w-fit items-center gap-2 rounded-full border border-[#f5d8c8] bg-white px-3.5 py-2 text-xs font-bold text-[#98613c]">
                    <span class="h-2 w-2 rounded-full bg-[#d99a65]"></span>
                    {{ $pendingJustifications->count() }} por revisar
                </span>
            </div>

            <div class="space-y-3 p-5 sm:p-6 lg:p-7">
                @forelse ($pendingJustifications->take(4) as $justification)
                    <article class="flex items-center gap-3 rounded-2xl border border-[#f5d8c8] bg-[#fffaf5] p-4 transition hover:bg-[#fff5eb] sm:gap-4 sm:p-5">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#fff0e7] text-[#b96d48]">
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 3.75h7l5 5v11.5a.75.75 0 0 1-.75.75h-11.5a.75.75 0 0 1-.75-.75v-15.75A.75.75 0 0 1 6.75 3.75Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 4v5h5M9 14h6M9 17h4"/>
                            </svg>
                        </span>

                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-bold text-[#75472c]">
                                {{ $justification->attendance->student->name }}
                            </p>

                            <p class="mt-1 truncate text-sm text-[#98613c]">
                                {{ $justification->attendance->classSession->subject->name }}
                            </p>
                        </div>

                        <span class="hidden shrink-0 rounded-full border border-[#f5d8c8] bg-white px-3 py-1.5 text-xs font-bold text-[#98613c] sm:inline-flex">
                            Pendiente
                        </span>
                    </article>
                @empty
                    <div class="rounded-2xl border border-dashed border-[#cfe7d9] bg-[#f7fbf8] px-5 py-8 text-center">
                        <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-[#168d6b] shadow-sm">
                            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6"/>
                                <circle cx="12" cy="12" r="9"/>
                            </svg>
                        </span>

                        <h3 class="mt-4 text-sm font-bold text-[#29483b]">
                            Todo al día
                        </h3>
                        <p class="mt-1 text-sm leading-6 text-[#789287]">
                            No hay justificantes pendientes de revisión.
                        </p>
                    </div>
                @endforelse
            </div>

            @if ($pendingJustifications->isNotEmpty())
                <div class="border-t border-[#f5e4d9] p-4 sm:px-6 lg:px-7">
                    <a href="{{ route('teacher.justifications') }}" class="inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl border border-[#f5d8c8] bg-white px-4 py-3 text-sm font-bold text-[#98613c] transition hover:bg-[#fff5eb] focus:outline-none focus:ring-4 focus:ring-[#ffe6d7] sm:w-auto">
                        Revisar todos los justificantes
                        <span aria-hidden="true">→</span>
                    </a>
                </div>
            @endif
        </section>

        {{-- Resumen compacto de grupos --}}
        <section class="rounded-[1.5rem] border border-[#e3eee8] bg-white p-5 shadow-[0_14px_40px_rgba(30,70,54,0.045)] sm:p-6 lg:p-7">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#168d6b]">
                        Tus grupos
                    </p>
                    <h2 class="mt-2 text-xl font-extrabold tracking-tight text-[#173d31]">
                        Resumen de grupos
                    </h2>
                    <p class="mt-1 text-sm text-[#789287]">
                        Acceso rápido a los grupos que gestionas.
                    </p>
                </div>

                <a href="{{ route('teacher.groups') }}" class="inline-flex w-fit items-center gap-2 text-sm font-bold text-[#168d6b] transition hover:text-[#127257]">
                    Gestionar grupos
                    <span aria-hidden="true">→</span>
                </a>
            </div>

            <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">
                @forelse ($groups->take(3) as $group)
                    <div class="flex items-center gap-3 rounded-2xl border border-[#e3eee8] bg-[#f7fbf8] p-4">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-sm font-extrabold text-[#168d6b] shadow-sm">
                            {{ strtoupper(substr($group->name, 0, 1)) }}
                        </span>

                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-bold text-[#29483b]">
                                {{ $group->name }}
                            </p>
                            <p class="mt-1 text-xs text-[#789287]">
                                {{ $group->students->count() }} alumnos
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-[#789287]">
                        Todavía no tienes grupos creados.
                    </p>
                @endforelse
            </div>
        </section>

    </div>

    {{-- Se conserva el modal existente --}}
    @include('teacher.create-class-modal', ['groups' => $groups])

@endsection
