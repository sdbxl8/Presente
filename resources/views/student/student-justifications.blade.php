@extends('layouts.app')

@section('content')
    @php
        $student = auth()->user();
        $attendances = $attendances ?? collect();
    @endphp

    <div class="mx-auto max-w-5xl space-y-6">
        <header class="space-y-2">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-sky-700">Alumno</p>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Justificaciones</h1>
            <p class="max-w-xl text-sm leading-6 text-slate-600">
                Consulta retrasos, ausencias y justificadas. Si hace falta, envía un justificante al profesor de la clase.
            </p>
        </header>

        @if (session('success'))
            <p class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800" role="status">
                {{ session('success') }}
            </p>
        @endif

        @if (session('error'))
            <p class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800" role="alert">
                {{ session('error') }}
            </p>
        @endif

        <section class="space-y-3" aria-labelledby="student-attendances-title">
            <div class="flex items-center justify-between gap-3">
                <h2 id="student-attendances-title" class="text-lg font-semibold text-slate-900">Tu asistencia</h2>
                <span class="rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700">{{ $attendances->count() }} registros</span>
            </div>

            @forelse ($attendances as $attendance)
                @php
                    $classSession = $attendance->classSession;
                    $justification = $attendance->justification;
                    $canSubmit = in_array($attendance->status, ['absent', 'late'], true) && ! $justification;
                    $statusLabel = match (true) {
                        $justification?->status === 'pending' => 'Pendiente de revisión',
                        $justification?->status === 'rejected' => 'Justificante rechazado',
                        $attendance->status === 'excused' => 'Justificada',
                        $attendance->status === 'late' => 'Retraso',
                        $attendance->status === 'absent' => 'Injustificada',
                        default => $attendance->status,
                    };
                    $statusClasses = match (true) {
                        $justification?->status === 'pending' => 'border-amber-200 bg-amber-50 text-amber-800',
                        $justification?->status === 'rejected' => 'border-rose-200 bg-rose-50 text-rose-800',
                        $attendance->status === 'excused' => 'border-emerald-200 bg-emerald-50 text-emerald-800',
                        $attendance->status === 'late' => 'border-orange-200 bg-orange-50 text-orange-800',
                        default => 'border-slate-200 bg-slate-50 text-slate-700',
                    };
                @endphp

                <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div class="min-w-0">
                                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-sky-700">{{ $classSession?->subject?->group?->name ?? 'Grupo' }}</p>
                                <h3 class="mt-1 truncate text-base font-semibold text-slate-900">{{ $classSession?->subject?->name ?? 'Asignatura' }}</h3>
                            </div>
                            <span class="inline-flex w-fit shrink-0 items-center rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClasses }}">
                                {{ $statusLabel }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div class="rounded-xl bg-slate-50 px-3 py-2">
                                <p class="text-xs text-slate-500">Fecha</p>
                                <p class="mt-1 font-semibold text-slate-700">
                                    {{ $classSession?->date ? \Illuminate\Support\Carbon::parse($classSession->date)->format('d/m/Y') : '—' }}
                                </p>
                            </div>
                            <div class="rounded-xl bg-slate-50 px-3 py-2">
                                <p class="text-xs text-slate-500">Horario</p>
                                <p class="mt-1 font-semibold text-slate-700">
                                    {{ $classSession ? substr($classSession->start_time, 0, 5) . ' - ' . substr($classSession->end_time, 0, 5) : '—' }}
                                </p>
                            </div>
                        </div>

                        @if ($justification)
                            <div class="rounded-xl bg-slate-50 px-3 py-3">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Motivo enviado</p>
                                <p class="mt-1 whitespace-pre-line text-sm leading-6 text-slate-700">{{ $justification->reason }}</p>
                            </div>
                        @endif

                        @if ($canSubmit)
                            <button
                                type="button"
                                onclick="document.getElementById('justification-modal-{{ $attendance->id }}').classList.remove('hidden')"
                                class="inline-flex min-h-11 w-full items-center justify-center rounded-xl bg-sky-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-200 sm:w-auto"
                            >
                                Enviar justificante
                            </button>
                        @endif
                    </div>
                </article>
            @empty
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white/70 px-5 py-12 text-center sm:px-8">
                    <h3 class="text-base font-semibold text-slate-900">Todavía no hay asistencias para mostrar</h3>
                    <p class="mt-2 text-sm text-slate-500">
                        Aquí aparecerán tus retrasos, ausencias y clases justificadas.
                    </p>
                </div>
            @endforelse
        </section>
    </div>

    @foreach ($attendances as $attendance)
        @if (in_array($attendance->status, ['absent', 'late'], true) && ! $attendance->justification)
            @php
                $classSession = $attendance->classSession;
            @endphp

            <div id="justification-modal-{{ $attendance->id }}" class="hidden fixed inset-0 z-50 overflow-y-auto px-4 py-8 sm:px-6" role="dialog" aria-modal="true" aria-labelledby="justification-title-{{ $attendance->id }}">
                <div class="fixed inset-0 bg-slate-950/40" onclick="document.getElementById('justification-modal-{{ $attendance->id }}').classList.add('hidden')"></div>

                <div class="relative mx-auto flex min-h-full max-w-lg items-center justify-center">
                    <section class="w-full rounded-2xl bg-white p-5 shadow-2xl ring-1 ring-slate-200 sm:p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-sky-700">Justificante</p>
                                <h2 id="justification-title-{{ $attendance->id }}" class="mt-2 text-xl font-bold text-slate-900">Enviar al profesor</h2>
                                <p class="mt-1 text-sm text-slate-500">
                                    {{ $classSession?->subject?->name ?? 'Clase' }}
                                    ·
                                    {{ $classSession?->date ? \Illuminate\Support\Carbon::parse($classSession->date)->format('d/m/Y') : '' }}
                                </p>
                            </div>
                            <button type="button" onclick="document.getElementById('justification-modal-{{ $attendance->id }}').classList.add('hidden')" class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-100 text-lg text-slate-500 transition hover:bg-slate-200 hover:text-slate-800" aria-label="Cerrar justificante">
                                &times;
                            </button>
                        </div>

                        <form method="POST" action="{{ route('student.justifications.store', $attendance) }}" enctype="multipart/form-data" class="mt-6 space-y-4">
                            @csrf

                            <div>
                                <label for="reason-{{ $attendance->id }}" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Texto para el profesor</label>
                                <textarea
                                    id="reason-{{ $attendance->id }}"
                                    name="reason"
                                    rows="4"
                                    required
                                    maxlength="500"
                                    placeholder="Explica brevemente el motivo de la ausencia o el retraso."
                                    class="mt-2 min-h-28 w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100"
                                >{{ old('reason') }}</textarea>
                                @error('reason')
                                    <p class="mt-1 text-sm text-rose-700">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="document-{{ $attendance->id }}" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Documento (opcional)</label>
                                <input
                                    id="document-{{ $attendance->id }}"
                                    name="document"
                                    type="file"
                                    accept=".pdf,image/*"
                                    class="mt-2 block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-sky-50 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-sky-700"
                                >
                                <p class="mt-1 text-xs text-slate-500">PDF o imagen, máximo 5 MB.</p>
                                @error('document')
                                    <p class="mt-1 text-sm text-rose-700">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="inline-flex min-h-11 w-full items-center justify-center rounded-xl bg-sky-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-200">
                                Enviar justificante
                            </button>
                        </form>
                    </section>
                </div>
            </div>
        @endif
    @endforeach
@endsection
