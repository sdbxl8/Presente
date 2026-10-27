@extends('layouts.app')

@section('content')

    @php
        $student = auth()->user();

        $studentGroups = $student->studentGroups()
            ->with('subjects')
            ->get();

    // Se mantiene para el texto de respaldo de las tarjetas.
        $group = $studentGroups->first();

        $attendances = $student->attendances()
            ->with(['classSession.subject', 'justification'])
            ->get();

        $upcomingClasses = \App\Models\ClassSession::with('subject.group')
            ->whereHas('subject.group.students', function ($query) use ($student) {
        $query->whereKey($student->id);
        })
            ->whereDate('date', '>=', today())
            ->whereIn('status', ['scheduled', 'open'])
            ->orderBy('date')
            ->orderBy('start_time')
            ->limit(5)
            ->get();

        $attendedCount = $attendances->whereIn('status', ['present', 'late'])->count();

        $lateCount = $attendances->where('status', 'late')->count();

        $absenceCount = $attendances->where('status', 'absent')->count();

        $pendingJustifications = $attendances->filter(
            fn ($attendance) => $attendance->justification?->status === 'pending'
        );
        $rejectedJustifications = $attendances->filter(
            fn ($attendance) => $attendance->justification?->status === 'rejected'
        );

        $acceptedJustifications = $attendances->where(
            'status',
            'excused'
        );

        $recentJustifications = $attendances
            ->filter(fn ($attendance) => $attendance->justification !== null)
            ->sortByDesc(
            fn ($attendance) => $attendance->justification->created_at
                ?? $attendance->created_at
            )
            ->take(4);
    @endphp

    <div class="mx-auto max-w-7xl space-y-7 sm:space-y-8">

        {{-- Cabecera del alumno --}}
        <header class="relative overflow-hidden rounded-[2rem] border border-[#dcefe4] bg-gradient-to-br from-[#eaf8f0] via-white to-[#f1edff] p-6 sm:p-8 lg:p-10">

            <div class="pointer-events-none absolute -right-12 -top-16 h-48 w-48 rounded-full border border-[#c9ead8] sm:h-64 sm:w-64"></div>
            <div class="pointer-events-none absolute -bottom-16 right-24 h-32 w-32 rounded-full bg-[#d8f5e7]/60 blur-2xl"></div>

            <div class="relative z-10 flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">

                <div class="max-w-2xl">
                    <span class="inline-flex items-center gap-2 rounded-full border border-[#c9ead8] bg-white/80 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.14em] text-[#127257]">
                        <span class="h-2 w-2 rounded-full bg-[#36b887]"></span>
                        Espacio del alumno
                    </span>

                    <h1 class="mt-5 text-3xl font-extrabold tracking-tight text-[#173d31] sm:text-4xl lg:text-5xl">
                        ¡Hola, {{ $student->name }}!
                    </h1>

                    <p class="mt-3 max-w-xl text-sm leading-6 text-[#5c7c6e] sm:text-base">
                        Consulta tu asistencia, revisa tus próximas clases y mantén tu actividad académica al día.
                    </p>

                    @if ($studentGroups->isNotEmpty())
                        <div class="mt-5 inline-flex max-w-full items-center gap-2 rounded-full border border-[#dcefe4] bg-white/80 px-4 py-2 text-sm font-semibold text-[#466157]">
                            <svg viewBox="0 0 24 24" class="h-4 w-4 shrink-0 text-[#168d6b]" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <circle cx="9" cy="8" r="3.5"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 20v-1.5A4.5 4.5 0 0 1 7 14h4a4.5 4.5 0 0 1 4.5 4.5V20M16 5a3.5 3.5 0 0 1 0 6.5"/>
                            </svg>

                            <span class="truncate">
                                {{ $group->name }}
                            </span>
                        </div>
                    @endif
                </div>

                {{-- Acceso al escáner existente --}}
                <a
                    href="{{ route('student.scan') }}"
                    class="inline-flex min-h-12 shrink-0 items-center justify-center gap-2 rounded-2xl bg-[#168d6b] px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-emerald-900/10 transition hover:-translate-y-0.5 hover:bg-[#127257] hover:shadow-md focus:outline-none focus:ring-4 focus:ring-[#b5ebd2]"
                >
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 9V5a1 1 0 0 1 1-1h4M15 4h4a1 1 0 0 1 1 1v4M20 15v4a1 1 0 0 1-1 1h-4M9 20H5a1 1 0 0 1-1-1v-4"/>
                        <rect x="9" y="9" width="6" height="6" rx="1"/>
                    </svg>
                    Escanear asistencia
                </a>

            </div>
        </header>

        {{-- Indicadores de asistencia --}}
        <section class="space-y-4" aria-label="Resumen de asistencia">

            <div>
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#168d6b]">
                    Tu seguimiento
                </p>

                <h2 class="mt-2 text-xl font-extrabold tracking-tight text-[#173d31] sm:text-2xl">
                    Resumen de asistencia
                </h2>

                <p class="mt-1 text-sm leading-6 text-[#789287]">
                    Consulta tus registros y el estado de tus incidencias.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

                {{-- Clases asistidas --}}
                <article class="group rounded-[1.5rem] border border-[#dcefe4] bg-white p-5 shadow-[0_14px_40px_rgba(30,70,54,0.045)] transition duration-200 hover:-translate-y-0.5 hover:shadow-md sm:p-6">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-[#789287]">
                                Clases asistidas
                            </p>

                            <p class="mt-3 text-4xl font-extrabold tabular-nums tracking-tight text-[#168d6b]">
                                {{ $attendedCount }}
                            </p>

                            <p class="mt-2 text-xs text-[#789287]">
                                Presentes y retrasos
                            </p>
                        </div>

                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#eaf8f0] text-[#168d6b] transition group-hover:bg-[#d8f5e7]">
                            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <circle cx="12" cy="12" r="9"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8 12 2.5 2.5L16 9"/>
                            </svg>
                        </span>
                    </div>
                </article>

                {{-- Retrasos --}}
                <article class="group rounded-[1.5rem] border border-[#f5d8c8] bg-gradient-to-br from-white to-[#fff5eb] p-5 shadow-[0_14px_40px_rgba(30,70,54,0.035)] transition duration-200 hover:-translate-y-0.5 hover:shadow-md sm:p-6">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-[#98613c]">
                                Retrasos
                            </p>

                            <p class="mt-3 text-4xl font-extrabold tabular-nums tracking-tight text-[#b96d48]">
                                {{ $lateCount }}
                            </p>

                            <p class="mt-2 text-xs text-[#a87958]">
                                Registros fuera de hora
                            </p>
                        </div>

                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#fff0e7] text-[#b96d48] transition group-hover:bg-[#ffe6d7]">
                            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <circle cx="12" cy="12" r="9"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
                            </svg>
                        </span>
                    </div>
                </article>

                {{-- Ausencias --}}
                <article class="group rounded-[1.5rem] border border-[#f3cdca] bg-white p-5 shadow-[0_14px_40px_rgba(30,70,54,0.035)] transition duration-200 hover:-translate-y-0.5 hover:shadow-md sm:p-6">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-[#789287]">
                                Faltas
                            </p>

                            <p class="mt-3 text-4xl font-extrabold tabular-nums tracking-tight text-rose-600">
                                {{ $absenceCount }}
                            </p>

                            <p class="mt-2 text-xs text-[#789287]">
                                Ausencias registradas
                            </p>
                        </div>

                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#fff0ef] text-rose-600 transition group-hover:bg-[#ffe4e2]">
                            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <circle cx="12" cy="12" r="9"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9 9 6 6m0-6-6 6"/>
                            </svg>
                        </span>
                    </div>
                </article>

                {{-- Justificantes pendientes --}}
                <article class="group rounded-[1.5rem] border border-[#e9e3fb] bg-gradient-to-br from-white to-[#f7f4ff] p-5 shadow-[0_14px_40px_rgba(30,70,54,0.035)] transition duration-200 hover:-translate-y-0.5 hover:shadow-md sm:p-6">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-[#7967b5]">
                                Justificantes pendientes
                            </p>

                            <p class="mt-3 text-4xl font-extrabold tabular-nums tracking-tight text-[#7967b5]">
                                {{ $pendingJustifications->count() }}
                            </p>

                            <p class="mt-2 text-xs text-[#9183bf]">
                                Solicitudes por revisar
                            </p>
                        </div>

                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#f1edff] text-[#7967b5] transition group-hover:bg-[#e8e1ff]">
                            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 3.75h7l5 5v11.5a.75.75 0 0 1-.75.75h-11.5a.75.75 0 0 1-.75-.75v-15.75A.75.75 0 0 1 6.75 3.75Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 4v5h5M9 14h6M9 17h4"/>
                            </svg>
                        </span>
                    </div>
                </article>

            </div>
        </section>

        {{-- Aviso de justificantes pendientes --}}
        @if ($pendingJustifications->isNotEmpty())
            <section class="overflow-hidden rounded-[1.5rem] border border-[#f5d8c8] bg-gradient-to-r from-[#fff5eb] via-[#fffaf5] to-white p-5 sm:p-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-start gap-3">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#fff0e7] text-[#b96d48]">
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <circle cx="12" cy="12" r="9"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
                            </svg>
                        </span>

                        <div>
                            <h2 class="font-extrabold text-[#75472c]">
                                Tienes justificantes pendientes
                            </h2>

                            <p class="mt-1 text-sm leading-6 text-[#98613c]">
                                Tienes {{ $pendingJustifications->count() }} solicitud(es) a la espera de revisión del profesor.
                            </p>
                        </div>
                    </div>

                    <a
                        href="{{ route('student.justifications') }}"
                        class="inline-flex min-h-11 shrink-0 items-center justify-center gap-2 rounded-xl border border-[#f5d8c8] bg-white px-4 py-3 text-sm font-bold text-[#98613c] transition hover:bg-[#fff0e7] focus:outline-none focus:ring-4 focus:ring-[#ffe6d7]"
                    >
                        Ver justificantes
                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/>
                        </svg>
                    </a>
                </div>
            </section>
        @endif

        {{-- Estado de las justificaciones del alumno --}}
<section class="overflow-hidden rounded-[1.5rem] border border-[#e3eee8] bg-white shadow-[0_14px_40px_rgba(30,70,54,0.045)]">

    {{-- Cabecera --}}
    <div class="flex flex-col gap-4 border-b border-[#edf3ef] bg-gradient-to-r from-[#effbf6] via-white to-[#f1edff] px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
        <div class="flex items-center gap-3">
            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white text-[#168d6b] shadow-sm ring-1 ring-[#e3eee8]">
                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 3.75h7l5 5v11.5a.75.75 0 0 1-.75.75h-11.5a.75.75 0 0 1-.75-.75v-15.75A.75.75 0 0 1 6.75 3.75Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 4v5h5M9 14h6M9 17h4"/>
                </svg>
            </span>

            <div>
                <h2 class="text-lg font-extrabold tracking-tight text-[#173d31]">
                    Mis justificantes
                </h2>
                <p class="mt-1 text-sm text-[#789287]">
                    Consulta el estado de tus solicitudes.
                </p>
            </div>
        </div>

        <a
            href="{{ route('student.justifications') }}"
            class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl border border-[#c9ead8] bg-white px-4 py-2.5 text-sm font-bold text-[#127257] transition hover:bg-[#effbf6] focus:outline-none focus:ring-4 focus:ring-[#d8f5e7]"
        >
            Ver historial completo
            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/>
            </svg>
        </a>
    </div>

    <div class="space-y-5 p-5 sm:p-6">

        {{-- Resumen de estados --}}
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">

            <div class="rounded-2xl border border-[#f5d8c8] bg-[#fff5eb] p-4">
                <div class="flex items-center gap-2">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-white text-[#b96d48]">
                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <circle cx="12" cy="12" r="9"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
                        </svg>
                    </span>
                    <span class="text-sm font-semibold text-[#98613c]">Pendientes</span>
                </div>

                <p class="mt-3 text-3xl font-extrabold tabular-nums text-[#75472c]">
                    {{ $pendingJustifications->count() }}
                </p>
                <p class="mt-1 text-xs text-[#a87958]">Esperando revisión</p>
            </div>

            <div class="rounded-2xl border border-[#f3cdca] bg-[#fff0ef] p-4">
                <div class="flex items-center gap-2">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-white text-rose-600">
                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <circle cx="12" cy="12" r="9"/>
                            <path stroke-linecap="round" d="m9 9 6 6m0-6-6 6"/>
                        </svg>
                    </span>
                    <span class="text-sm font-semibold text-rose-700">Rechazados</span>
                </div>

                <p class="mt-3 text-3xl font-extrabold tabular-nums text-rose-800">
                    {{ $rejectedJustifications->count() }}
                </p>
                <p class="mt-1 text-xs text-rose-700">Solicitudes rechazadas</p>
            </div>

            <div class="rounded-2xl border border-[#c9ead8] bg-[#effbf6] p-4">
                <div class="flex items-center gap-2">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-white text-[#168d6b]">
                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <circle cx="12" cy="12" r="9"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8 12 2.5 2.5L16 9"/>
                        </svg>
                    </span>
                    <span class="text-sm font-semibold text-[#127257]">Justificadas</span>
                </div>

                <p class="mt-3 text-3xl font-extrabold tabular-nums text-[#127257]">
                    {{ $acceptedJustifications->count() }}
                </p>
                <p class="mt-1 text-xs text-[#168d6b]">Ausencias justificadas</p>
            </div>

        </div>

        {{-- Últimas solicitudes --}}
        <div>
            <div class="mb-3">
                <h3 class="text-sm font-extrabold text-[#173d31]">
                    Actividad reciente
                </h3>
                <p class="mt-1 text-xs text-[#789287]">
                    Consulta las últimas solicitudes que has enviado.
                </p>
            </div>

            <div class="space-y-3">
                @forelse ($recentJustifications as $attendance)
                    @php
                        $justification = $attendance->justification;
                        $classSession = $attendance->classSession;

                        [$statusLabel, $statusClasses] = match (true) {
                            $justification->status === 'pending' => [
                                'Pendiente de revisión',
                                'border-[#f5d8c8] bg-[#fff5eb] text-[#98613c]',
                            ],
                            $justification->status === 'rejected' => [
                                'Rechazado',
                                'border-[#f3cdca] bg-[#fff0ef] text-rose-700',
                            ],
                            $attendance->status === 'excused' => [
                                'Aceptado',
                                'border-[#c9ead8] bg-[#effbf6] text-[#127257]',
                            ],
                            default => [
                                'Registrado',
                                'border-[#e3eee8] bg-[#f7fbf8] text-[#466157]',
                            ],
                        };
                    @endphp

                    <article class="rounded-2xl border border-[#e3eee8] bg-white p-4 transition hover:bg-[#f7fbf8] sm:p-5">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">

                            <div class="flex min-w-0 items-start gap-3">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#f1edff] text-[#7967b5]">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 3.75h7l5 5v11.5a.75.75 0 0 1-.75.75h-11.5a.75.75 0 0 1-.75-.75v-15.75A.75.75 0 0 1 6.75 3.75Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 4v5h5M9 14h6M9 17h4"/>
                                    </svg>
                                </span>

                                <div class="min-w-0">
                                    <h4 class="break-words text-sm font-bold text-[#29483b]">
                                        {{ $classSession?->subject?->name ?? 'Asignatura' }}
                                    </h4>

                                    <p class="mt-1 text-xs text-[#789287]">
                                        {{ $classSession?->date ? \Illuminate\Support\Carbon::parse($classSession->date)->format('d/m/Y') : 'Fecha no disponible' }}
                                    </p>

                                    <p class="mt-2 line-clamp-2 whitespace-pre-line text-sm leading-5 text-[#5c7c6e]">
                                        {{ $justification->reason }}
                                    </p>
                                </div>
                            </div>

                            <span class="inline-flex w-fit shrink-0 items-center gap-1.5 rounded-full border px-3 py-1.5 text-xs font-bold {{ $statusClasses }}">
                                {{ $statusLabel }}
                            </span>

                        </div>
                    </article>

                @empty
                    <div class="rounded-2xl border border-dashed border-[#cfe7d9] bg-[#f7fbf8] px-4 py-8 text-center">
                        <span class="mx-auto flex h-11 w-11 items-center justify-center rounded-xl bg-white text-[#168d6b] shadow-sm">
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6"/>
                                <circle cx="12" cy="12" r="9"/>
                            </svg>
                        </span>

                        <p class="mt-3 text-sm font-bold text-[#466157]">
                            Todavía no has enviado justificantes
                        </p>
                        <p class="mt-1 text-xs leading-5 text-[#789287]">
                            Cuando envíes una solicitud, podrás consultar aquí su estado.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</section>

        {{-- Próximas clases --}}
        <section class="overflow-hidden rounded-[1.5rem] border border-[#e3eee8] bg-white shadow-[0_14px_40px_rgba(30,70,54,0.045)]">

            <div class="flex flex-col gap-4 border-b border-[#edf3ef] bg-gradient-to-r from-[#effbf6] via-white to-white px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-7">
                <div class="flex items-center gap-3">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#eaf8f0] text-[#168d6b]">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <rect x="3.5" y="5" width="17" height="15.5" rx="2"/>
                            <path stroke-linecap="round" d="M7.5 3.5v3M16.5 3.5v3M3.5 9.5h17"/>
                        </svg>
                    </span>

                    <div>
                        <h2 class="text-lg font-extrabold tracking-tight text-[#173d31]">
                            Mis próximas clases
                        </h2>

                        <p class="mt-1 text-sm text-[#789287]">
                            Las siguientes sesiones programadas para tu grupo.
                        </p>
                    </div>
                </div>

                <a
                    href="{{ route('student.classes') }}"
                    class="inline-flex min-h-10 w-fit items-center justify-center gap-2 rounded-xl border border-[#c9ead8] bg-white px-4 py-2.5 text-sm font-bold text-[#127257] transition hover:bg-[#effbf6] focus:outline-none focus:ring-4 focus:ring-[#d8f5e7]"
                >
                    Ver todas
                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/>
                    </svg>
                </a>
            </div>

            <div class="space-y-3 p-4 sm:p-5 lg:p-6">

                @forelse ($upcomingClasses as $class)
                    <article class="rounded-2xl border border-[#e3eee8] bg-white p-4 transition hover:border-[#b5ebd2] hover:bg-[#f7fbf8] sm:p-5">

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                            <div class="flex min-w-0 items-start gap-3">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#eaf8f0] text-[#168d6b]">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.75A2.75 2.75 0 0 1 6.75 3H20v16H6.75A2.75 2.75 0 0 0 4 21.75z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.75v16M8 7h8M8 10.5h8"/>
                                    </svg>
                                </span>

                                <div class="min-w-0">
                                    <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#168d6b]">
                                        {{ $class->subject->group->name ?? $group?->name ?? 'Mi grupo' }}
                                    </p>

                                    <h3 class="mt-1.5 break-words text-base font-extrabold tracking-tight text-[#173d31]">
                                        {{ $class->subject->name ?? 'Clase' }}
                                    </h3>

                                    <span class="mt-2 inline-flex items-center gap-1.5 rounded-full border border-[#c9ead8] bg-[#effbf6] px-2.5 py-1 text-xs font-semibold text-[#127257]">
                                        <span class="h-1.5 w-1.5 rounded-full bg-[#36b887]"></span>
                                        Clase programada
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3 sm:w-auto sm:shrink-0">

                                <div class="min-w-0 rounded-xl border border-[#e3eee8] bg-[#f7fbf8] px-3 py-3">
                                    <div class="flex items-center gap-1.5 text-[#789287]">
                                        <svg viewBox="0 0 24 24" class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <rect x="3.5" y="5" width="17" height="15.5" rx="2"/>
                                            <path stroke-linecap="round" d="M7.5 3.5v3M16.5 3.5v3M3.5 9.5h17"/>
                                        </svg>
                                        <p class="text-xs font-semibold">Fecha</p>
                                    </div>

                                    <p class="mt-2 whitespace-nowrap text-sm font-bold text-[#29483b]">
                                        {{ \Illuminate\Support\Carbon::parse($class->date)->format('d/m/Y') }}
                                    </p>
                                </div>

                                <div class="min-w-0 rounded-xl border border-[#e9e3fb] bg-[#faf8ff] px-3 py-3">
                                    <div class="flex items-center gap-1.5 text-[#7967b5]">
                                        <svg viewBox="0 0 24 24" class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <circle cx="12" cy="12" r="9"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
                                        </svg>
                                        <p class="text-xs font-semibold">Hora</p>
                                    </div>

                                    <p class="mt-2 whitespace-nowrap text-sm font-bold tabular-nums text-[#463b72]">
                                        {{ substr($class->start_time, 0, 5) }}
                                    </p>
                                </div>

                            </div>
                        </div>
                    </article>

                @empty
                    <div class="rounded-[1.5rem] border border-dashed border-[#cfe7d9] bg-[#f7fbf8] px-5 py-10 text-center sm:px-8 sm:py-12">

                        <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-[#168d6b] shadow-sm">
                            <svg viewBox="0 0 24 24" class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                                <rect x="3.5" y="5" width="17" height="15.5" rx="2"/>
                                <path stroke-linecap="round" d="M7.5 3.5v3M16.5 3.5v3M3.5 9.5h17"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 12v5M9.5 14.5h5"/>
                            </svg>
                        </span>

                        <h3 class="mt-4 text-lg font-extrabold text-[#173d31]">
                            No tienes próximas clases
                        </h3>

                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#789287]">
                            @if ({{ $studentGroups->pluck('name')->join(' · ') }})
                                Cuando tu profesor programe nuevas sesiones para tu grupo, aparecerán aquí.
                            @else
                                Cuando te unas a un grupo, podrás consultar aquí tus próximas clases.
                            @endif
                        </p>

                        @if ({{ $studentGroups->pluck('name')->join(' · ') }})
                            <a
                                href="{{ route('student.classes') }}"
                                class="mt-5 inline-flex min-h-11 items-center justify-center gap-2 rounded-xl border border-[#c9ead8] bg-white px-4 py-3 text-sm font-bold text-[#127257] transition hover:bg-[#effbf6] focus:outline-none focus:ring-4 focus:ring-[#d8f5e7]"
                            >
                                Consultar mis clases
                                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>
        </section>

        {{-- Acceso rápido a justificar una ausencia --}}
        <section class="flex flex-col gap-4 rounded-[1.5rem] border border-[#e9e3fb] bg-gradient-to-r from-[#f7f4ff] via-white to-[#effbf6] p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6">
            <div class="flex items-start gap-3">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white text-[#7967b5] shadow-sm ring-1 ring-[#e9e3fb]">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 3.75h7l5 5v11.5a.75.75 0 0 1-.75.75h-11.5a.75.75 0 0 1-.75-.75v-15.75A.75.75 0 0 1 6.75 3.75Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 4v5h5M9 14h6M9 17h4"/>
                    </svg>
                </span>

                <div>
                    <h2 class="font-extrabold text-[#463b72]">
                        ¿Necesitas justificar una ausencia?
                    </h2>

                    <p class="mt-1 text-sm leading-6 text-[#7967b5]">
                        Consulta tus solicitudes y su estado de revisión.
                    </p>
                </div>
            </div>

            <a
                href="{{ route('student.justifications') }}"
                class="inline-flex min-h-11 shrink-0 items-center justify-center gap-2 rounded-xl border border-[#dcd2fb] bg-white px-4 py-3 text-sm font-bold text-[#7967b5] transition hover:bg-[#f1edff] focus:outline-none focus:ring-4 focus:ring-[#e9e3fb]"
            >
                Mis justificantes
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/>
                </svg>
            </a>
        </section>

    </div>
@endsection
