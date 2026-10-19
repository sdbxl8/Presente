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

    <div class="mx-auto max-w-5xl space-y-6">
        <header class="space-y-2">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-sky-700">Alumno</p>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Mis clases</h1>
            <p class="max-w-xl text-sm leading-6 text-slate-600">
                Consulta el calendario y las clases de tu grupo. Pulsa el nombre del profesor para ver su perfil.
            </p>
        </header>

        @include('layouts.calendar')

        <section class="space-y-3" aria-labelledby="student-classes-title">
            <div class="flex items-center justify-between gap-3">
                <h2 id="student-classes-title" class="text-lg font-semibold text-slate-900">Clases de tu grupo</h2>
                <span class="rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700">{{ $classes->count() }} clases</span>
            </div>

            @forelse ($classes as $class)
                @php
                    $teacher = $class->subject?->group?->teacher;
                    $teacherName = trim(($teacher->name ?? '') . ' ' . ($teacher->surname ?? ''));
                @endphp

                <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                    <div class="flex flex-col gap-4">
                        <div class="min-w-0">
                            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-sky-700">{{ $class->subject->group->name ?? 'Grupo' }}</p>
                            <h3 class="mt-1 truncate text-base font-semibold text-slate-900">{{ $class->subject->name ?? 'Asignatura' }}</h3>
                        </div>

                        <div class="grid grid-cols-2 gap-3 text-sm sm:grid-cols-3">
                            <div class="rounded-xl bg-slate-50 px-3 py-2">
                                <p class="text-xs text-slate-500">Fecha</p>
                                <p class="mt-1 font-semibold text-slate-700">{{ \Illuminate\Support\Carbon::parse($class->date)->format('d/m/Y') }}</p>
                            </div>
                            <div class="rounded-xl bg-slate-50 px-3 py-2">
                                <p class="text-xs text-slate-500">Horario</p>
                                <p class="mt-1 font-semibold text-slate-700">{{ substr($class->start_time, 0, 5) }} - {{ substr($class->end_time, 0, 5) }}</p>
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                @if ($teacher)
                                    <button
                                        type="button"
                                        onclick="document.getElementById('teacher-profile-modal-{{ $teacher->id }}').classList.remove('hidden')"
                                        class="flex min-h-14 w-full flex-col items-start justify-center rounded-xl border border-sky-200 bg-sky-50 px-3 py-2 text-left transition hover:bg-sky-100 focus:outline-none focus:ring-4 focus:ring-sky-200"
                                        aria-haspopup="dialog"
                                        aria-controls="teacher-profile-modal-{{ $teacher->id }}"
                                    >
                                        <span class="text-xs text-sky-700">Profesor</span>
                                        <span class="mt-1 truncate text-sm font-semibold text-sky-900">{{ $teacherName }}</span>
                                    </button>
                                @else
                                    <div class="rounded-xl bg-slate-50 px-3 py-2">
                                        <p class="text-xs text-slate-500">Profesor</p>
                                        <p class="mt-1 font-semibold text-slate-700">Sin asignar</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white/70 px-5 py-12 text-center sm:px-8">
                    <h3 class="text-base font-semibold text-slate-900">Todavía no hay clases para mostrar</h3>
                    <p class="mt-2 text-sm text-slate-500">
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

    @foreach ($teachers as $teacher)
        @php
            $teacherInitials = strtoupper(substr($teacher->name ?? '', 0, 1) . substr($teacher->surname ?? '', 0, 1));
            $teacherPhotoUrl = $teacher->photo
                ? asset('storage/' . ltrim($teacher->photo, '/'))
                : null;
        @endphp

        <div id="teacher-profile-modal-{{ $teacher->id }}" class="hidden fixed inset-0 z-50 overflow-y-auto px-4 py-8 sm:px-6" role="dialog" aria-modal="true" aria-labelledby="teacher-profile-title-{{ $teacher->id }}">
            <div class="fixed inset-0 bg-slate-950/40" onclick="document.getElementById('teacher-profile-modal-{{ $teacher->id }}').classList.add('hidden')"></div>

            <div class="relative mx-auto flex min-h-full max-w-lg items-center justify-center">
                <section class="w-full rounded-2xl bg-white p-5 shadow-2xl ring-1 ring-slate-200 sm:p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-sky-700">Profesor</p>
                            <h2 id="teacher-profile-title-{{ $teacher->id }}" class="mt-2 text-xl font-bold text-slate-900">Perfil del docente</h2>
                            <p class="mt-1 text-sm text-slate-500">Consulta los datos de contacto. Esta ficha no se puede editar.</p>
                        </div>
                        <button type="button" onclick="document.getElementById('teacher-profile-modal-{{ $teacher->id }}').classList.add('hidden')" class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-100 text-lg text-slate-500 transition hover:bg-slate-200 hover:text-slate-800" aria-label="Cerrar perfil del profesor">
                            &times;
                        </button>
                    </div>

                    <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center">
                        <div class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-full bg-sky-50 text-xl font-bold text-sky-700 ring-1 ring-sky-100">
                            @if ($teacherPhotoUrl)
                                <img src="{{ $teacherPhotoUrl }}" alt="Foto de {{ $teacher->name }}" class="h-full w-full object-cover">
                            @else
                                <span>{{ $teacherInitials ?: 'P' }}</span>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="truncate text-lg font-semibold text-slate-900">{{ trim(($teacher->name ?? '') . ' ' . ($teacher->surname ?? '')) }}</p>
                            <p class="mt-1 text-sm text-slate-500">{{ $teacher->subject_name ?: 'Sin asignatura asignada' }}</p>
                        </div>
                    </div>

                    <dl class="mt-6 divide-y divide-slate-200 rounded-2xl border border-slate-200">
                        <div class="px-4 py-3 sm:px-5">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Nombre</dt>
                            <dd class="mt-1 text-sm font-medium text-slate-900">{{ $teacher->name }}</dd>
                        </div>
                        <div class="px-4 py-3 sm:px-5">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Apellidos</dt>
                            <dd class="mt-1 text-sm font-medium text-slate-900">{{ $teacher->surname }}</dd>
                        </div>
                        <div class="px-4 py-3 sm:px-5">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Asignatura</dt>
                            <dd class="mt-1 text-sm font-medium text-slate-900">{{ $teacher->subject_name ?: 'Sin asignatura asignada' }}</dd>
                        </div>
                        <div class="px-4 py-3 sm:px-5">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Correo electrónico</dt>
                            <dd class="mt-1 wrap-break-word text-sm font-medium text-slate-900">{{ $teacher->email }}</dd>
                        </div>
                    </dl>
                </section>
            </div>
        </div>
    @endforeach
@endsection
