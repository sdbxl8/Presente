@extends('layouts.app')

@section('content')
    @php
        $student = auth()->user();
        $group = $student->group;
        $attendances = $student->attendances()
            ->with(['classSession.subject', 'justification'])
            ->get();
        $upcomingClasses = \App\Models\ClassSession::with('subject')
            ->whereHas('subject.group', function ($query) use ($student) {
                $query->whereKey($student->group_id);
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
    @endphp

    <div class="mx-auto max-w-6xl space-y-6">

        <header class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <a href="{{ route('student.scan') }}" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-sky-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-200">
                <span class="flex h-6 w-6 items-center justify-center rounded-md bg-white/15 text-xs font-bold" aria-hidden="true">QR</span>
                Escanear asistencia
            </a>
        </header>

        <section class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4" aria-label="Resumen de asistencia">
            <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                <p class="text-sm font-medium text-slate-500">Clases asistidas</p>
                <p class="mt-2 text-3xl font-bold tabular-nums text-emerald-700">{{ $attendedCount }}</p>
            </article>
            <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                <p class="text-sm font-medium text-slate-500">Retrasos</p>
                <p class="mt-2 text-3xl font-bold tabular-nums text-amber-700">{{ $lateCount }}</p>
            </article>
            <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                <p class="text-sm font-medium text-slate-500">Faltas</p>
                <p class="mt-2 text-3xl font-bold tabular-nums text-rose-700">{{ $absenceCount }}</p>
            </article>
            <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                <p class="text-sm font-medium text-slate-500">Justificantes pendientes</p>
                <p class="mt-2 text-3xl font-bold tabular-nums text-sky-700">{{ $pendingJustifications->count() }}</p>
            </article>
        </section>

        @if ($pendingJustifications->isNotEmpty())
            <div class="flex flex-col gap-3 rounded-2xl border border-amber-200 bg-amber-50 p-4 sm:flex-row sm:items-center sm:justify-between sm:px-5">
                <p class="text-sm font-medium text-amber-900">
                    Tienes {{ $pendingJustifications->count() }} justificante(s) pendiente(s) de revisión.
                </p>
                <a href="{{ route('student.justifications') }}" class="inline-flex min-h-10 items-center justify-center rounded-lg border border-amber-300 bg-white px-4 py-2 text-sm font-semibold text-amber-900 transition hover:bg-amber-100 focus:outline-none focus:ring-4 focus:ring-amber-200">
                    Ver justificantes
                </a>
            </div>
        @endif

        <section class="space-y-3" aria-labelledby="upcoming-classes-title">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 id="upcoming-classes-title" class="text-lg font-semibold text-slate-900">Mis próximas clases</h2>
                    <p class="mt-1 text-sm text-slate-500">Clases programadas para tu grupo.</p>
                </div>
                <a href="{{ route('student.classes') }}" class="shrink-0 text-sm font-semibold text-sky-700 transition hover:text-sky-900">
                    Ver todas
                </a>
            </div>

            @forelse ($upcomingClasses as $class)
                <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div class="min-w-0">
                            <p class="text-xs font-semibold uppercase tracking-wide text-sky-700">
                                {{ $class->subject->group->name ?? $group?->name ?? 'Mi grupo' }}
                            </p>
                            <h3 class="mt-1 truncate font-semibold text-slate-900">
                                {{ $class->subject->name ?? 'Clase' }}
                            </h3>
                        </div>
                        <div class="flex gap-3 text-sm sm:shrink-0">
                            <div class="rounded-lg bg-slate-50 px-3 py-2">
                                <p class="text-xs text-slate-500">Fecha</p>
                                <p class="mt-1 font-semibold text-slate-700">{{ \Illuminate\Support\Carbon::parse($class->date)->format('d/m/Y') }}</p>
                            </div>
                            <div class="rounded-lg bg-slate-50 px-3 py-2">
                                <p class="text-xs text-slate-500">Hora</p>
                                <p class="mt-1 font-semibold text-slate-700">{{ substr($class->start_time, 0, 5) }}</p>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white/70 px-5 py-10 text-center sm:px-8">
                    <h3 class="font-semibold text-slate-900">No tienes próximas clases</h3>
                    <p class="mt-2 text-sm text-slate-500">
                        @if ($group)
                            Cuando tu profesor programe clases para tu grupo, aparecerán aquí.
                        @else
                            Cuando te unas a un grupo, podrás consultar aquí tus clases.
                        @endif
                    </p>
                </div>
            @endforelse
        </section>
    </div>
@endsection
