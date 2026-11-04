@extends('layouts.app')

@section('content')
    @php
        $student = auth()->user();
        $attendances = $attendances ?? collect();
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
                    Mis justificantes
                </h1>

                <p class="mt-3 max-w-2xl text-sm leading-6 text-[#5c7c6e] sm:text-base">
                    Consulta tus ausencias y retrasos, comprueba el estado de tus solicitudes y envía la documentación necesaria al profesor.
                </p>

                <div class="mt-6 flex flex-wrap gap-3">
                    <span class="inline-flex items-center gap-2 rounded-full border border-[#dcefe4] bg-white/80 px-4 py-2 text-sm font-semibold text-[#466157]">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 text-[#168d6b]" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 3.75h7l5 5v11.5a.75.75 0 0 1-.75.75h-11.5a.75.75 0 0 1-.75-.75v-15.75A.75.75 0 0 1 6.75 3.75Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 4v5h5M9 14h6M9 17h4"/>
                        </svg>
                        {{ $attendances->count() }} registros
                    </span>

                    <span class="inline-flex items-center gap-2 rounded-full border border-[#e9e3fb] bg-white/80 px-4 py-2 text-sm font-semibold text-[#7967b5]">
                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <circle cx="12" cy="12" r="9"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
                        </svg>
                        Seguimiento de solicitudes
                    </span>
                </div>
            </div>
        </header>

        {{-- Mensajes de resultado: se conservan las sesiones originales --}}
        @if (session('success'))
            <div class="flex items-start gap-3 rounded-2xl border border-[#c9ead8] bg-[#effbf6] px-4 py-4 text-sm font-medium text-[#127257] sm:px-5" role="status">
                <svg viewBox="0 0 24 24" class="mt-0.5 h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8 12 2.5 2.5L16 9"/>
                </svg>

                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="flex items-start gap-3 rounded-2xl border border-[#f3cdca] bg-[#fff0ef] px-4 py-4 text-sm font-medium text-rose-800 sm:px-5" role="alert">
                <svg viewBox="0 0 24 24" class="mt-0.5 h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" d="m9 9 6 6m0-6-6 6"/>
                </svg>

                <p>{{ session('error') }}</p>
            </div>
        @endif

        {{-- Historial de asistencia --}}
        <section class="space-y-5" aria-labelledby="student-attendances-title">

            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#168d6b]">
                        Tu seguimiento académico
                    </p>

                    <h2 id="student-attendances-title" class="mt-2 text-xl font-extrabold tracking-tight text-[#173d31] sm:text-2xl">
                        Historial de asistencia
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-[#789287]">
                        Consulta el estado de cada sesión y justifica las ausencias o retrasos que lo permitan.
                    </p>
                </div>

                <span class="inline-flex w-fit items-center gap-2 rounded-full border border-[#c9ead8] bg-[#effbf6] px-3.5 py-2 text-xs font-bold text-[#127257]">
                    <span class="h-2 w-2 rounded-full bg-[#36b887]"></span>
                    {{ $attendances->count() }} registros
                </span>
            </div>

            <div class="space-y-4">
                @forelse ($attendances as $attendance)
    @php
        $classSession = $attendance->classSession;
        $justification = $attendance->justification;

        $canSubmit = in_array($attendance->status, ['absent', 'late'], true)
            && ! $justification;

        $statusLabel = match (true) {
            $justification?->status === 'pending' => 'Pendiente de revisión',
            $justification?->status === 'rejected' => 'Justificante rechazado',
            $attendance->status === 'excused' => 'Justificada',
            $attendance->status === 'late' => 'Retraso',
            $attendance->status === 'absent' => 'Ausente',
            $attendance->status === 'present' => 'Presente',
            default => ucfirst($attendance->status),
        };

        $statusClasses = match (true) {
            $justification?->status === 'pending' => 'border-[#f5d8c8] bg-[#fff5eb] text-[#98613c]',
            $justification?->status === 'rejected' => 'border-[#f3cdca] bg-[#fff0ef] text-rose-800',
            $attendance->status === 'excused' => 'border-[#c9ead8] bg-[#effbf6] text-[#127257]',
            $attendance->status === 'late' => 'border-[#f5d8c8] bg-[#fff5eb] text-[#98613c]',
            $attendance->status === 'absent' => 'border-[#f3cdca] bg-[#fff0ef] text-rose-700',
            default => 'border-[#c9ead8] bg-[#effbf6] text-[#127257]',
        };
    @endphp

    <details class="group overflow-hidden rounded-[1.5rem] border border-[#e3eee8] bg-white shadow-[0_10px_30px_rgba(30,70,54,0.035)] transition duration-200 open:shadow-[0_14px_40px_rgba(30,70,54,0.06)]">

        {{-- Resumen visible mientras el registro está cerrado --}}
        <summary class="flex cursor-pointer list-none items-center gap-3 p-4 transition hover:bg-[#f7fbf8] focus:outline-none focus-visible:ring-4 focus-visible:ring-[#d8f5e7] sm:gap-4 sm:p-5 [&::-webkit-details-marker]:hidden">

            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#eaf8f0] text-[#168d6b]">
                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.75A2.75 2.75 0 0 1 6.75 3H20v16H6.75A2.75 2.75 0 0 0 4 21.75z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.75v16M8 7h8M8 10.5h8"/>
                </svg>
            </span>

            <span class="min-w-0 flex-1">
                <span class="block truncate text-sm font-extrabold text-[#173d31] sm:text-base">
                    {{ $classSession?->subject?->name ?? 'Asignatura' }}
                </span>

                <span class="mt-1 block truncate text-xs text-[#789287]">
                    {{ $classSession?->subject?->group?->name ?? 'Grupo' }}
                    <span class="px-1">·</span>
                    {{ $classSession?->date ? \Illuminate\Support\Carbon::parse($classSession->date)->format('d/m/Y') : '—' }}
                </span>
            </span>

            <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full border px-2.5 py-1.5 text-[10px] font-bold sm:px-3 sm:text-xs {{ $statusClasses }}">
                {{ $statusLabel }}
            </span>

            <svg viewBox="0 0 24 24" class="h-5 w-5 shrink-0 text-[#789287] transition-transform duration-200 group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/>
            </svg>
        </summary>

        {{-- Información completa, visible al desplegar --}}
        <div class="space-y-5 border-t border-[#edf3ef] p-4 sm:p-6">

            {{-- Fecha y horario --}}
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">

                <div class="rounded-2xl border border-[#e3eee8] bg-[#f7fbf8] p-4">
                    <div class="flex items-center gap-2">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 text-[#168d6b]" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <rect x="3.5" y="5" width="17" height="15.5" rx="2"/>
                            <path stroke-linecap="round" d="M7.5 3.5v3M16.5 3.5v3M3.5 9.5h17"/>
                        </svg>

                        <p class="text-xs font-bold uppercase tracking-[0.12em] text-[#789287]">
                            Fecha
                        </p>
                    </div>

                    <p class="mt-3 text-sm font-bold text-[#29483b]">
                        {{ $classSession?->date ? \Illuminate\Support\Carbon::parse($classSession->date)->format('d/m/Y') : '—' }}
                    </p>
                </div>

                <div class="rounded-2xl border border-[#e9e3fb] bg-[#faf8ff] p-4">
                    <div class="flex items-center gap-2">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 text-[#7967b5]" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <circle cx="12" cy="12" r="9"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
                        </svg>

                        <p class="text-xs font-bold uppercase tracking-[0.12em] text-[#7967b5]">
                            Horario
                        </p>
                    </div>

                    <p class="mt-3 text-sm font-bold tabular-nums text-[#463b72]">
                        {{ $classSession ? substr($classSession->start_time, 0, 5) . ' - ' . substr($classSession->end_time, 0, 5) : '—' }}
                    </p>
                </div>
            </div>

            {{-- Justificante enviado --}}
            @if ($justification)
                <div class="rounded-2xl border border-[#e3eee8] bg-[#f7fbf8] p-4 sm:p-5">

                    <div class="flex items-center gap-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-white text-[#168d6b] shadow-sm">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 3.75h7l5 5v11.5a.75.75 0 0 1-.75.75h-11.5a.75.75 0 0 1-.75-.75v-15.75A.75.75 0 0 1 6.75 3.75Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 4v5h5M9 14h6M9 17h4"/>
                            </svg>
                        </span>

                        <p class="text-xs font-bold uppercase tracking-[0.12em] text-[#789287]">
                            Motivo enviado
                        </p>
                    </div>

                    <p class="mt-3 whitespace-pre-line break-words text-sm leading-6 text-[#466157]">{{ $justification->reason }}</p>

                    @if ($justification->status === 'pending')
                        <div class="mt-4 flex items-start gap-2 rounded-xl border border-[#f5d8c8] bg-[#fff5eb] p-3 text-sm leading-5 text-[#98613c]">
                            <svg viewBox="0 0 24 24" class="mt-0.5 h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <circle cx="12" cy="12" r="9"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
                            </svg>
                            Tu solicitud está pendiente de revisión por parte del profesor.
                        </div>
                    @elseif ($justification->status === 'rejected')
                        <div class="mt-4 flex items-start gap-2 rounded-xl border border-[#f3cdca] bg-[#fff0ef] p-3 text-sm leading-5 text-rose-700">
                            <svg viewBox="0 0 24 24" class="mt-0.5 h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <circle cx="12" cy="12" r="9"/>
                                <path stroke-linecap="round" d="m9 9 6 6m0-6-6 6"/>
                            </svg>
                            El justificante ha sido rechazado. Consulta con tu profesor si necesitas más información.
                        </div>
                    @endif
                </div>
            @endif

            {{-- Envío de justificante --}}
            @if ($canSubmit)
                <div class="border-t border-[#edf3ef] pt-5">
                    <p class="mb-3 text-sm leading-6 text-[#789287]">
                        ¿Necesitas justificar esta ausencia o retraso? Puedes enviar una explicación y adjuntar documentación.
                    </p>

                    <button
                        type="button"
                        onclick="document.getElementById('justification-modal-{{ $attendance->id }}').classList.remove('hidden')"
                        class="inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-2xl bg-[#168d6b] px-4 py-3.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#127257] focus:outline-none focus:ring-4 focus:ring-[#b5ebd2] sm:w-auto"
                    >
                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 3.75h7l5 5v11.5a.75.75 0 0 1-.75.75h-11.5a.75.75 0 0 1-.75-.75v-15.75A.75.75 0 0 1 6.75 3.75Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 4v5h5M12 13v5M9.5 15.5h5"/>
                        </svg>
                        Enviar justificante
                    </button>
                </div>
            @endif

        </div>
    </details>

@empty
    <div class="rounded-[1.75rem] border border-dashed border-[#cfe7d9] bg-white/80 px-5 py-12 text-center shadow-[0_14px_40px_rgba(30,70,54,0.035)] sm:px-8 sm:py-16">
        <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-[#eaf8f0] text-[#168d6b]">
            <svg viewBox="0 0 24 24" class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 3.75h7l5 5v11.5a.75.75 0 0 1-.75.75h-11.5a.75.75 0 0 1-.75-.75v-15.75A.75.75 0 0 1 6.75 3.75Z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 4v5h5M9 14h6M9 17h4"/>
            </svg>
        </span>

        <h3 class="mt-5 text-lg font-extrabold text-[#173d31]">
            Todavía no hay asistencias para mostrar
        </h3>

        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#789287]">
            Aquí aparecerán tus ausencias y retrasos cuando existan registros de asistencia.
        </p>
    </div>
@endforelse
@endsection
