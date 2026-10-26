@extends('layouts.app')

@section('content')
    @php
        $student = auth()->user();

        $classes = $classes ?? collect();

        $teachers = $classes
            ->map(fn ($class) => $class->subject?->group?->teacher)
            ->filter()
            ->unique('id');
    @endphp

    <div class="mx-auto max-w-6xl space-y-7 sm:space-y-8">

        {{-- Cabecera --}}
        <header class="relative overflow-hidden rounded-[2rem] border border-[#dcefe4] bg-gradient-to-br from-[#eaf8f0] via-white to-[#f1edff] p-6 sm:p-8 lg:p-10">
            <div class="pointer-events-none absolute -right-12 -top-16 h-48 w-48 rounded-full border border-[#c9ead8] sm:h-64 sm:w-64"></div>
            <div class="pointer-events-none absolute -bottom-16 right-24 h-32 w-32 rounded-full bg-[#d8f5e7]/60 blur-2xl"></div>

            <div class="relative z-10">
                <span class="inline-flex items-center gap-2 rounded-full border border-[#c9ead8] bg-white/80 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.14em] text-[#127257]">
                    <span class="h-2 w-2 rounded-full bg-[#36b887]"></span>
                    Espacio del alumno
                </span>

                <h1 class="mt-5 text-3xl font-extrabold tracking-tight text-[#173d31] sm:text-4xl">
                    Mis clases
                </h1>

                <p class="mt-3 max-w-xl text-sm leading-6 text-[#5c7c6e] sm:text-base">
                    Consulta las clases de tu grupo, revisa sus horarios y accede a la información de tus profesores.
                </p>

                <div class="mt-6 flex flex-wrap items-center gap-3">
                    <span class="inline-flex items-center gap-2 rounded-full border border-[#dcefe4] bg-white/80 px-4 py-2 text-sm font-semibold text-[#466157]">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 text-[#168d6b]" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <rect x="3.5" y="5" width="17" height="15.5" rx="2"/>
                            <path stroke-linecap="round" d="M7.5 3.5v3M16.5 3.5v3M3.5 9.5h17"/>
                        </svg>
                        {{ $classes->count() }} clases
                    </span>

                    <span class="inline-flex items-center gap-2 rounded-full border border-[#e9e3fb] bg-white/80 px-4 py-2 text-sm font-semibold text-[#7967b5]">
                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <circle cx="9" cy="8" r="3.5"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 20v-1.5A4.5 4.5 0 0 1 7 14h4a4.5 4.5 0 0 1 4.5 4.5V20"/>
                        </svg>
                        {{ $teachers->count() }} profesores
                    </span>
                </div>
            </div>
        </header>

        {{-- Calendario existente --}}
        <section class="space-y-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#168d6b]">
                    Planificación
                </p>

                <h2 class="mt-2 text-xl font-extrabold tracking-tight text-[#173d31] sm:text-2xl">
                    Calendario académico
                </h2>

                <p class="mt-1 text-sm leading-6 text-[#789287]">
                    Consulta las fechas de las sesiones programadas para tu grupo.
                </p>
            </div>

            @include('layouts.calendar')
        </section>

        {{-- Listado de clases --}}
        <section class="space-y-5" aria-labelledby="student-classes-title">

            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#168d6b]">
                        Tu actividad académica
                    </p>

                    <h2 id="student-classes-title" class="mt-2 text-xl font-extrabold tracking-tight text-[#173d31] sm:text-2xl">
                        Clases de tu grupo
                    </h2>

                    <p class="mt-1 text-sm leading-6 text-[#789287]">
                        Consulta la asignatura, el horario y los datos de contacto del profesor.
                    </p>
                </div>

                <span class="inline-flex w-fit items-center gap-2 rounded-full border border-[#c9ead8] bg-[#effbf6] px-3.5 py-2 text-xs font-bold text-[#127257]">
                    <span class="h-2 w-2 rounded-full bg-[#36b887]"></span>
                    {{ $classes->count() }} clases
                </span>
            </div>

            @forelse ($classes as $class)
                @php
                    $teacher = $class->subject?->group?->teacher;
                    $teacherName = trim(($teacher->name ?? '') . ' ' . ($teacher->surname ?? ''));
                @endphp

                <article class="group overflow-hidden rounded-[1.5rem] border border-[#e3eee8] bg-white shadow-[0_14px_40px_rgba(30,70,54,0.045)] transition duration-200 hover:border-[#c9ead8] hover:shadow-[0_18px_42px_rgba(30,70,54,0.07)]">

                    {{-- Identidad de la asignatura --}}
                    <div class="border-b border-[#edf3ef] bg-gradient-to-r from-[#effbf6] via-white to-white p-5 sm:p-6">
                        <div class="flex items-start gap-4">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white text-[#168d6b] shadow-sm ring-1 ring-[#e3eee8] transition group-hover:bg-[#eaf8f0]">
                                <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.75A2.75 2.75 0 0 1 6.75 3H20v16H6.75A2.75 2.75 0 0 0 4 21.75z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.75v16M8 7h8M8 10.5h8"/>
                                </svg>
                            </span>

                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#168d6b]">
                                    {{ $class->subject->group->name ?? 'Grupo' }}
                                </p>

                                <h3 class="mt-1.5 break-words text-lg font-extrabold tracking-tight text-[#173d31] sm:text-xl">
                                    {{ $class->subject->name ?? 'Asignatura' }}
                                </h3>

                                <p class="mt-1.5 text-sm text-[#789287]">
                                    Información de la sesión
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Fecha, horario y profesor --}}
                    <div class="grid grid-cols-1 gap-3 p-5 sm:grid-cols-2 sm:p-6 lg:grid-cols-3">

                        {{-- Fecha --}}
                        <div class="rounded-2xl border border-[#e3eee8] bg-[#f7fbf8] p-4">
                            <div class="flex items-center gap-2">
                                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white text-[#168d6b] shadow-sm">
                                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <rect x="3.5" y="5" width="17" height="15.5" rx="2"/>
                                        <path stroke-linecap="round" d="M7.5 3.5v3M16.5 3.5v3M3.5 9.5h17"/>
                                    </svg>
                                </span>

                                <p class="text-xs font-bold uppercase tracking-[0.12em] text-[#789287]">
                                    Fecha
                                </p>
                            </div>

                            <p class="mt-3 text-sm font-bold text-[#29483b]">
                                {{ \Illuminate\Support\Carbon::parse($class->date)->format('d/m/Y') }}
                            </p>
                        </div>

                        {{-- Horario --}}
                        <div class="rounded-2xl border border-[#e9e3fb] bg-[#faf8ff] p-4">
                            <div class="flex items-center gap-2">
                                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white text-[#7967b5] shadow-sm">
                                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
                                    </svg>
                                </span>

                                <p class="text-xs font-bold uppercase tracking-[0.12em] text-[#7967b5]">
                                    Horario
                                </p>
                            </div>

                            <p class="mt-3 break-words text-sm font-bold tabular-nums text-[#463b72]">
                                {{ substr($class->start_time, 0, 5) }} - {{ substr($class->end_time, 0, 5) }}
                            </p>
                        </div>

                        {{-- Información del profesor --}}
                        <div class="sm:col-span-2 lg:col-span-1">
                            @if ($teacher)
                                <button
                                    type="button"
                                    onclick="document.getElementById('teacher-profile-modal-{{ $teacher->id }}').classList.remove('hidden')"
                                    class="flex min-h-[6.5rem] w-full items-center gap-3 rounded-2xl border border-[#c9ead8] bg-[#effbf6] p-4 text-left transition hover:border-[#83dbb8] hover:bg-[#e4f8ed] focus:outline-none focus:ring-4 focus:ring-[#b5ebd2]"
                                    aria-haspopup="dialog"
                                    aria-controls="teacher-profile-modal-{{ $teacher->id }}"
                                >
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#168d6b] shadow-sm">
                                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                            <circle cx="12" cy="8" r="3.5"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 20v-1.5A4.5 4.5 0 0 1 9 14h6a4.5 4.5 0 0 1 4.5 4.5V20"/>
                                        </svg>
                                    </span>

                                    <span class="min-w-0 flex-1">
                                        <span class="block text-xs font-semibold text-[#5c7c6e]">
                                            Profesor
                                        </span>

                                        <span class="mt-1 block truncate text-sm font-bold text-[#127257]">
                                            {{ $teacherName }}
                                        </span>

                                        <span class="mt-1 block text-xs font-medium text-[#168d6b]">
                                            Ver perfil →
                                        </span>
                                    </span>
                                </button>
                            @else
                                <div class="flex min-h-[6.5rem] items-center gap-3 rounded-2xl border border-[#e3eee8] bg-[#f7fbf8] p-4">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#789287]">
                                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                            <circle cx="12" cy="8" r="3.5"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 20v-1.5A4.5 4.5 0 0 1 9 14h6a4.5 4.5 0 0 1 4.5 4.5V20"/>
                                        </svg>
                                    </span>

                                    <span>
                                        <span class="block text-xs font-semibold text-[#789287]">Profesor</span>
                                        <span class="mt-1 block text-sm font-semibold text-[#466157]">Sin asignar</span>
                                    </span>
                                </div>
                            @endif
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
                        Todavía no hay clases para mostrar
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#789287]">
                        @if (blank($student?->group_id))
                            Cuando te unas a un grupo, aquí aparecerán sus clases.
                        @else
                            Tu grupo todavía no tiene clases planificadas.
                        @endif
                    </p>
                </div>
            @endforelse
        </section>
    </div>

    {{-- Fichas de información de los profesores --}}
    @foreach ($teachers as $teacher)
        @php
            $teacherInitials = strtoupper(substr($teacher->name ?? '', 0, 1) . substr($teacher->surname ?? '', 0, 1));

            $teacherPhotoUrl = $teacher->photo
                ? asset('storage/' . ltrim($teacher->photo, '/'))
                : null;
        @endphp

        <div
            id="teacher-profile-modal-{{ $teacher->id }}"
            class="fixed inset-0 z-50 hidden overflow-y-auto px-4 py-6 sm:px-6 sm:py-8"
            role="dialog"
            aria-modal="true"
            aria-labelledby="teacher-profile-title-{{ $teacher->id }}"
        >
            <div
                class="fixed inset-0 bg-[#173d31]/50 backdrop-blur-sm"
                onclick="document.getElementById('teacher-profile-modal-{{ $teacher->id }}').classList.add('hidden')"
            ></div>

            <div class="relative mx-auto flex min-h-full max-w-lg items-center justify-center">
                <section class="w-full overflow-hidden rounded-[1.75rem] border border-[#e3eee8] bg-white shadow-[0_28px_80px_rgba(23,61,49,0.18)]">

                    {{-- Cabecera del perfil --}}
                    <div class="border-b border-[#edf3ef] bg-gradient-to-br from-[#eaf8f0] via-white to-[#f1edff] p-5 sm:p-7">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <span class="inline-flex items-center gap-2 rounded-full border border-[#c9ead8] bg-white/80 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.14em] text-[#127257]">
                                    <span class="h-2 w-2 rounded-full bg-[#36b887]"></span>
                                    Información académica
                                </span>

                                <h2 id="teacher-profile-title-{{ $teacher->id }}" class="mt-4 text-xl font-extrabold tracking-tight text-[#173d31] sm:text-2xl">
                                    Perfil del docente
                                </h2>

                                <p class="mt-2 text-sm leading-6 text-[#789287]">
                                    Consulta los datos de contacto. Esta ficha no se puede editar.
                                </p>
                            </div>

                            <button
                                type="button"
                                onclick="document.getElementById('teacher-profile-modal-{{ $teacher->id }}').classList.add('hidden')"
                                class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-[#e3eee8] bg-white text-xl text-[#789287] transition hover:border-[#b5ebd2] hover:bg-[#effbf6] hover:text-[#127257] focus:outline-none focus:ring-4 focus:ring-[#d8f5e7]"
                                aria-label="Cerrar perfil del profesor"
                            >
                                &times;
                            </button>
                        </div>

                        {{-- Foto e identidad --}}
                        <div class="mt-6 flex flex-col items-center gap-4 text-center sm:flex-row sm:text-left">
                            <div class="flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-[1.75rem] bg-white text-2xl font-extrabold text-[#168d6b] shadow-sm ring-1 ring-[#dcefe4]">
                                @if ($teacherPhotoUrl)
                                    <img
                                        src="{{ $teacherPhotoUrl }}"
                                        alt="Foto de {{ $teacher->name }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    <span>{{ $teacherInitials ?: 'P' }}</span>
                                @endif
                            </div>

                            <div class="min-w-0">
                                <p class="break-words text-xl font-extrabold tracking-tight text-[#173d31]">
                                    {{ trim(($teacher->name ?? '') . ' ' . ($teacher->surname ?? '')) }}
                                </p>

                                <p class="mt-2 text-sm font-semibold text-[#168d6b]">
                                    {{ $teacher->subject_name ?: 'Sin asignatura asignada' }}
                                </p>

                                <span class="mt-3 inline-flex items-center gap-1.5 rounded-full border border-[#c9ead8] bg-white/80 px-3 py-1.5 text-xs font-semibold text-[#127257]">
                                    <svg viewBox="0 0 20 20" class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                        <circle cx="10" cy="10" r="7.5"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m6.5 10 2.3 2.3 4.7-4.8"/>
                                    </svg>
                                    Docente de tu grupo
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Datos de contacto --}}
                    <dl class="divide-y divide-[#edf3ef] p-5 sm:p-7">

                        <div class="flex gap-3 py-4 first:pt-0">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#eaf8f0] text-[#168d6b]">
                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                    <circle cx="12" cy="8" r="3.5"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 20v-1.5A4.5 4.5 0 0 1 9 14h6a4.5 4.5 0 0 1 4.5 4.5V20"/>
                                </svg>
                            </span>

                            <div class="min-w-0 flex-1">
                                <dt class="text-xs font-bold uppercase tracking-[0.12em] text-[#789287]">
                                    Nombre
                                </dt>

                                <dd class="mt-1 break-words text-sm font-semibold text-[#29483b]">
                                    {{ $teacher->name }}
                                </dd>
                            </div>
                        </div>

                        <div class="flex gap-3 py-4">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#eaf8f0] text-[#168d6b]">
                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                    <circle cx="12" cy="8" r="3.5"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 20v-1.5A4.5 4.5 0 0 1 9 14h6a4.5 4.5 0 0 1 4.5 4.5V20"/>
                                </svg>
                            </span>

                            <div class="min-w-0 flex-1">
                                <dt class="text-xs font-bold uppercase tracking-[0.12em] text-[#789287]">
                                    Apellidos
                                </dt>

                                <dd class="mt-1 break-words text-sm font-semibold text-[#29483b]">
                                    {{ $teacher->surname }}
                                </dd>
                            </div>
                        </div>

                        <div class="flex gap-3 py-4">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#f1edff] text-[#7967b5]">
                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.75A2.75 2.75 0 0 1 6.75 3H20v16H6.75A2.75 2.75 0 0 0 4 21.75z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.75v16M8 7h8"/>
                                </svg>
                            </span>

                            <div class="min-w-0 flex-1">
                                <dt class="text-xs font-bold uppercase tracking-[0.12em] text-[#7967b5]">
                                    Asignatura
                                </dt>

                                <dd class="mt-1 break-words text-sm font-semibold text-[#29483b]">
                                    {{ $teacher->subject_name ?: 'Sin asignatura asignada' }}
                                </dd>
                            </div>
                        </div>

                        <div class="flex gap-3 py-4 last:pb-0">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#fff0e7] text-[#b96d48]">
                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                    <rect x="3" y="5" width="18" height="14" rx="2"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4 7 8 6 8-6"/>
                                </svg>
                            </span>

                            <div class="min-w-0 flex-1">
                                <dt class="text-xs font-bold uppercase tracking-[0.12em] text-[#b96d48]">
                                    Correo electrónico
                                </dt>

                                <dd class="mt-1 break-words text-sm font-semibold text-[#29483b]">
                                    {{ $teacher->email }}
                                </dd>
                            </div>
                        </div>

                    </dl>
                </section>
            </div>
        </div>
    @endforeach
@endsection
