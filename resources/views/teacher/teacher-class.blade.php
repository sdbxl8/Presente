@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-6xl space-y-8">

        {{-- Cabecera de la página --}}
        <header class="relative overflow-hidden rounded-[2rem] border border-[#dcefe4] bg-gradient-to-br from-[#eaf8f0] via-white to-[#f1edff] p-6 sm:p-8 lg:p-10">
            <div class="pointer-events-none absolute -right-12 -top-16 h-48 w-48 rounded-full border border-[#c9ead8] sm:h-64 sm:w-64"></div>
            <div class="pointer-events-none absolute -bottom-16 right-24 h-32 w-32 rounded-full bg-[#d8f5e7]/60 blur-2xl"></div>

            <div class="relative z-10 flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
                <div class="max-w-2xl">
                    <span class="inline-flex items-center gap-2 rounded-full border border-[#c9ead8] bg-white/80 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.14em] text-[#127257]">
                        <span class="h-2 w-2 rounded-full bg-[#36b887]"></span>
                        Espacio del profesor
                    </span>

                    <h1 class="mt-5 text-3xl font-extrabold tracking-tight text-[#173d31] sm:text-4xl">
                        Mis clases
                    </h1>

                    <p class="mt-3 max-w-xl text-sm leading-6 text-[#5c7c6e] sm:text-base">
                        Planifica tus sesiones, organiza los horarios y controla la asistencia de tus alumnos desde un mismo lugar.
                    </p>

                    <div class="mt-5 inline-flex items-center gap-2 rounded-full border border-[#e3eee8] bg-white/80 px-3.5 py-2 text-sm font-semibold text-[#466157]">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 text-[#168d6b]" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <rect x="3.5" y="5" width="17" height="15.5" rx="2"/>
                            <path stroke-linecap="round" d="M7.5 3.5v3M16.5 3.5v3M3.5 9.5h17"/>
                        </svg>

                        <span>{{ ($classes ?? collect())->count() }} clases planificadas</span>
                    </div>
                </div>

                <button
                    type="button"
                    onclick="document.getElementById('create-class-modal').classList.remove('hidden')"
                    class="inline-flex min-h-12 w-full shrink-0 items-center justify-center gap-2 rounded-2xl bg-[#168d6b] px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-emerald-900/10 transition hover:-translate-y-0.5 hover:bg-[#127257] hover:shadow-md focus:outline-none focus:ring-4 focus:ring-[#b5ebd2] sm:w-auto"
                >
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>
                    </svg>

                    Planificar clase
                </button>
            </div>
        </header>

        {{-- Calendario existente --}}
        @include('layouts.calendar')

        {{-- Listado de clases planificadas --}}
        <section class="space-y-5" aria-labelledby="classes-title">

            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#168d6b]">
                        Organización académica
                    </p>

                    <h2 id="classes-title" class="mt-2 text-xl font-extrabold tracking-tight text-[#173d31] sm:text-2xl">
                        Clases planificadas
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-[#789287]">
                        Consulta los grupos, las asignaturas y los horarios de cada sesión.
                    </p>
                </div>

                <span class="inline-flex w-fit items-center gap-2 rounded-full border border-[#c9ead8] bg-[#effbf6] px-3.5 py-2 text-xs font-bold text-[#127257]">
                    <span class="h-2 w-2 rounded-full bg-[#36b887]"></span>
                    {{ ($classes ?? collect())->count() }} clases
                </span>
            </div>

            @forelse (($classes ?? collect()) as $class)

                <article class="overflow-hidden rounded-[1.5rem] border border-[#e3eee8] bg-white shadow-[0_14px_40px_rgba(30,70,54,0.045)] transition duration-200 hover:shadow-[0_18px_42px_rgba(30,70,54,0.075)]">

                    <div class="flex flex-col gap-5 p-5 sm:p-6 lg:flex-row lg:items-center lg:justify-between lg:p-7">

                        {{-- Información de la asignatura --}}
                        <div class="flex min-w-0 items-start gap-4">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#eaf8f0] text-[#168d6b]">
                                <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.75A2.75 2.75 0 0 1 6.75 3H20v16H6.75A2.75 2.75 0 0 0 4 21.75z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.75v16M8 7h8M8 10.5h8"/>
                                </svg>
                            </span>

                            <div class="min-w-0">
                                <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#168d6b]">
                                    {{ $class->subject->group->name ?? 'Grupo' }}
                                </p>

                                <h3 class="mt-1.5 break-words text-lg font-extrabold tracking-tight text-[#173d31]">
                                    {{ $class->subject->name ?? 'Asignatura' }}
                                </h3>

                                <p class="mt-2 text-sm text-[#789287]">
                                    Sesión planificada
                                </p>
                            </div>
                        </div>

                        {{-- Fecha y horario --}}
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:min-w-[19rem]">
                            <div class="rounded-2xl border border-[#e3eee8] bg-[#f7fbf8] p-4">
                                <div class="flex items-center gap-2">
                                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-[#168d6b]" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <rect x="3.5" y="5" width="17" height="15.5" rx="2"/>
                                        <path stroke-linecap="round" d="M7.5 3.5v3M16.5 3.5v3M3.5 9.5h17"/>
                                    </svg>

                                    <p class="text-xs font-semibold text-[#789287]">
                                        Fecha
                                    </p>
                                </div>

                                <p class="mt-2 text-sm font-bold text-[#29483b]">
                                    {{ \Illuminate\Support\Carbon::parse($class->date)->format('d/m/Y') }}
                                </p>
                            </div>

                            <div class="rounded-2xl border border-[#e3eee8] bg-[#f7fbf8] p-4">
                                <div class="flex items-center gap-2">
                                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-[#7967b5]" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
                                    </svg>

                                    <p class="text-xs font-semibold text-[#789287]">
                                        Horario
                                    </p>
                                </div>

                                <p class="mt-2 text-sm font-bold tabular-nums text-[#29483b]">
                                    {{ substr($class->start_time, 0, 5) }} - {{ substr($class->end_time, 0, 5) }}
                                </p>
                            </div>
                        </div>

                        {{-- Acciones originales --}}
                        <div class="flex flex-col gap-2 sm:flex-row lg:flex-col xl:flex-row">

                            <form
                                action="{{ route('teacher.classes.destroy', $class) }}"
                                method="POST"
                                onsubmit="return confirm('¿Quieres borrar esta clase?');"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl border border-[#f0ceca] bg-white px-4 py-2.5 text-sm font-bold text-rose-700 transition hover:bg-rose-50 focus:outline-none focus:ring-4 focus:ring-rose-100 sm:w-auto"
                                    aria-label="Borrar clase"
                                >
                                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M9 7V4h6v3M7 7l1 13h8l1-13M10 11v5M14 11v5"/>
                                    </svg>

                                    Borrar
                                </button>
                            </form>

                            <button
                                type="button"
                                onclick="document.getElementById('start-class-modal-{{ $class->id }}').classList.remove('hidden')"
                                class="inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#168d6b] px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#127257] focus:outline-none focus:ring-4 focus:ring-[#b5ebd2] sm:w-auto"
                            >
                                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 9V5h4M20 9V5h-4M4 15v4h4M20 15v4h-4"/>
                                    <rect x="9" y="9" width="6" height="6" rx="1"/>
                                </svg>

                                Abrir clase
                            </button>

                        </div>
                    </div>
                </article>

            @empty

                {{-- Estado vacío --}}
                <div class="rounded-[1.75rem] border border-dashed border-[#cfe7d9] bg-white/80 px-5 py-12 text-center shadow-[0_14px_40px_rgba(30,70,54,0.035)] sm:px-8 sm:py-16">

                    <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-[#eaf8f0] text-[#168d6b]">
                        <svg viewBox="0 0 24 24" class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                            <rect x="3.5" y="5" width="17" height="15.5" rx="2"/>
                            <path stroke-linecap="round" d="M7.5 3.5v3M16.5 3.5v3M3.5 9.5h17"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 12v5M9.5 14.5h5"/>
                        </svg>
                    </span>

                    <h3 class="mt-5 text-lg font-extrabold text-[#173d31]">
                        Todavía no hay clases planificadas
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#789287]">
                        Cuando planifiques una sesión, aparecerá aquí con su asignatura, fecha y horario.
                    </p>

                    <button
                        type="button"
                        onclick="document.getElementById('create-class-modal').classList.remove('hidden')"
                        class="mt-6 inline-flex min-h-11 items-center justify-center gap-2 rounded-2xl bg-[#168d6b] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#127257] focus:outline-none focus:ring-4 focus:ring-[#b5ebd2]"
                    >
                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>
                        </svg>
                        Planificar primera clase
                    </button>
                </div>

            @endforelse
        </section>
    </div>

    {{-- Se mantienen los modales de cada sesión --}}
    @foreach (($classes ?? collect()) as $class)

        @include('teacher.teacher-class-open', [
            'classSession' => $class,

            'attendanceUrl' => session('open_class_id') == $class->id
                ? session('attendance_url')
                : null,
        ])

    @endforeach

    {{-- Se conserva el modal de creación --}}
    @include('teacher.create-class-modal', ['groups' => $groups ?? collect()])

@endsection
