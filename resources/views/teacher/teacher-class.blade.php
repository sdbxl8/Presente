@extends('layouts.app')

@section('content')
	<div class="mx-auto max-w-5xl space-y-6">
		<div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
			<div>
				<p class="text-sm font-semibold uppercase tracking-[0.18em] text-sky-700">Profesor</p>
				<h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Mis clases</h1>
				<p class="mt-2 max-w-xl text-sm leading-6 text-slate-600">Planifica y consulta las clases de tus grupos.</p>
			</div>

			<button type="button" onclick="document.getElementById('create-class-modal').classList.remove('hidden')" class="inline-flex min-h-11 items-center justify-center rounded-xl bg-sky-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-200">
				Planificar clase
			</button>
		</div>

		@include('layouts.calendar')

		<section class="space-y-3" aria-labelledby="classes-title">
			<div class="flex items-center justify-between gap-3">
				<h2 id="classes-title" class="text-lg font-semibold text-slate-900">Clases planificadas</h2>
				<span class="rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700">{{ ($classes ?? collect())->count() }} clases</span>
			</div>

			@forelse (($classes ?? collect()) as $class)
				<article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
					<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
						<div class="min-w-0">
							<p class="text-xs font-semibold uppercase tracking-[0.16em] text-sky-700">{{ $class->subject->group->name ?? 'Grupo' }}</p>
							<h3 class="mt-1 truncate text-base font-semibold text-slate-900">{{ $class->subject->name ?? 'Asignatura' }}</h3>
						</div>
						<div class="flex flex-col gap-3 sm:flex-row sm:items-center">
							<div class="grid grid-cols-2 gap-3 text-sm sm:min-w-64">
							<div class="rounded-xl bg-slate-50 px-3 py-2">
								<p class="text-xs text-slate-500">Fecha</p>
								<p class="mt-1 font-semibold text-slate-700">{{ \Illuminate\Support\Carbon::parse($class->date)->format('d/m/Y') }}</p>
							</div>
							<div class="rounded-xl bg-slate-50 px-3 py-2">
								<p class="text-xs text-slate-500">Horario</p>
								<p class="mt-1 font-semibold text-slate-700">{{ substr($class->start_time, 0, 5) }} - {{ substr($class->end_time, 0, 5) }}</p>
							</div>
							</div>
							<form action="{{ route('teacher.classes.destroy', $class) }}" method="POST" onsubmit="return confirm('¿Quieres borrar esta clase?');">
								@csrf
								@method('DELETE')
								<button type="submit" class="inline-flex min-h-10 w-full items-center justify-center rounded-xl border border-rose-200 px-3 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-50 focus:outline-none focus:ring-4 focus:ring-rose-100 sm:w-auto" aria-label="Borrar clase">
									Borrar
								</button>
							</form>
			<button type="button" onclick="document.getElementById('start-class-modal-{{ $class->id }}').classList.remove('hidden')" class="inline-flex min-h-10 w-full items-center justify-center rounded-xl bg-emerald-600 px-3 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-200 sm:w-auto">
				Abrir clase
			</button>
						</div>
					</div>
				</article>
			@empty
				<div class="rounded-2xl border border-dashed border-slate-300 bg-white/70 px-5 py-12 text-center sm:px-8">
					<h3 class="text-base font-semibold text-slate-900">Todavía no hay clases planificadas</h3>
					<p class="mt-2 text-sm text-slate-500">Añade la primera clase con el botón superior.</p>
				</div>
			@endforelse
		</section>
	</div>

	@foreach (($classes ?? collect()) as $class)
		@include('teacher.teacher-class-open', [
        'classSession' => $class,
        'attendanceUrl' => session('open_class_id') == $class->id
            ? session('attendance_url')
            : null,
    ])
	@endforeach

@include('teacher.create-class-modal', ['groups' => $groups ?? collect()])
@endsection
