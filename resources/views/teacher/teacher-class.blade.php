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

		<button type="button" onclick="document.getElementById('calendar-modal').classList.remove('hidden')" class="flex w-full items-center justify-between gap-4 rounded-2xl border border-slate-200 bg-white px-4 py-4 text-left shadow-sm transition hover:border-sky-200 hover:bg-sky-50/40 focus:outline-none focus:ring-4 focus:ring-sky-100 sm:px-5">
			<span class="flex min-w-0 items-center gap-3">
				<span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sm font-bold text-sky-700">C</span>
				<span class="min-w-0">
					<span class="block text-xs font-semibold uppercase tracking-[0.16em] text-sky-700">Agenda</span>
					<span class="mt-1 block truncate text-base font-semibold text-slate-900">Calendario de clases</span>
				</span>
			</span>
			<span class="shrink-0 text-xl text-slate-400" aria-hidden="true">&rsaquo;</span>
		</button>

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

	<div id="calendar-modal" class="fixed inset-0 z-50 hidden overflow-y-auto px-4 py-8 sm:px-6" role="dialog" aria-modal="true" aria-labelledby="calendar-title">
		<div class="fixed inset-0 bg-slate-950/40" onclick="document.getElementById('calendar-modal').classList.add('hidden')"></div>

		<div class="relative mx-auto flex min-h-full max-w-3xl items-center justify-center">
			<section class="w-full overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-slate-200">
				<div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
					<div>
						<p class="text-xs font-semibold uppercase tracking-[0.16em] text-sky-700">Agenda</p>
						<h2 id="calendar-title" class="mt-1 text-xl font-bold text-slate-900">Calendario de clases</h2>
					</div>
					<div class="flex items-center gap-2">
						<button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-lg text-slate-500" aria-label="Mes anterior">&lsaquo;</button>
						<span class="min-w-28 text-center text-sm font-semibold text-slate-700">Mes actual</span>
						<button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-lg text-slate-500" aria-label="Mes siguiente">&rsaquo;</button>
					</div>
					<button type="button" onclick="document.getElementById('calendar-modal').classList.add('hidden')" class="absolute right-4 top-4 inline-flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 text-lg text-slate-500 transition hover:bg-slate-200 hover:text-slate-800 sm:right-6" aria-label="Cerrar calendario">
						&times;
					</button>
				</div>
				<div class="p-3 sm:p-6">
					<div class="grid grid-cols-7 gap-px overflow-hidden rounded-xl border border-slate-200 bg-slate-200">
						@foreach (['L', 'M', 'X', 'J', 'V', 'S', 'D'] as $weekday)
							<div class="bg-slate-50 px-1 py-2 text-center text-[11px] font-semibold uppercase text-slate-500 sm:py-3 sm:text-xs">{{ $weekday }}</div>
						@endforeach
						@for ($day = 1; $day <= 35; $day++)
							<div class="min-h-16 bg-white p-2 sm:min-h-24 sm:p-3">
								@if ($day <= 31)
									<span class="text-xs font-medium text-slate-400">{{ $day }}</span>
								@endif
							</div>
						@endfor
					</div>
					<p class="mt-3 text-center text-xs text-slate-400">Aquí aparecerán las asignaturas, grupos y horarios de cada clase.</p>
				</div>
			</section>
		</div>
	</div>

	<div id="create-class-modal" class="fixed inset-0 z-50 hidden overflow-y-auto px-4 py-8 sm:px-6" role="dialog" aria-modal="true" aria-labelledby="create-class-title">
		<div class="fixed inset-0 bg-slate-950/40" onclick="document.getElementById('create-class-modal').classList.add('hidden')"></div>

		<div class="relative mx-auto flex min-h-full max-w-lg items-center justify-center">
			<section class="w-full rounded-2xl bg-white p-5 shadow-2xl ring-1 ring-slate-200 sm:p-6">
				<div class="flex items-start justify-between gap-4">
					<div>
						<p class="text-sm font-semibold uppercase tracking-[0.18em] text-sky-700">Planificación</p>
						<h2 id="create-class-title" class="mt-2 text-xl font-bold text-slate-900">Nueva clase</h2>
						<p class="mt-1 text-sm text-slate-500">Completa los datos de la sesión.</p>
					</div>
					<button type="button" onclick="document.getElementById('create-class-modal').classList.add('hidden')" class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-100 text-lg text-slate-500 transition hover:bg-slate-200 hover:text-slate-800" aria-label="Cerrar ventana">
						&times;
					</button>
				</div>

				<form class="mt-6 space-y-5" action="{{ route('teacher.classes.store') }}" method="POST">
					@csrf
					<div class="grid gap-5 sm:grid-cols-2">
						<div class="sm:col-span-2">
							<label for="group_id" class="mb-2 block text-sm font-medium text-slate-700">Grupo</label>
							<select id="group_id" name="group_id" required onchange="filterSubjects()" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100">
								<option value="">Selecciona un grupo</option>
								@foreach (($groups ?? collect()) as $group)
									<option value="{{ $group->id }}">{{ $group->name }}</option>
								@endforeach
							</select>
						</div>

						<div class="sm:col-span-2">
							<label for="subject_id" class="mb-2 block text-sm font-medium text-slate-700">Asignatura</label>
							<select id="subject_id" name="subject_id" required disabled class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100">
								<option value="">Primero selecciona un grupo</option>
								@foreach (($groups ?? collect()) as $group)
									@foreach ($group->subjects as $subject)
										<option value="{{ $subject->id }}" data-group-id="{{ $group->id }}">{{ $subject->name }}</option>
									@endforeach
								@endforeach
							</select>
						</div>

						<div>
							<label for="date" class="mb-2 block text-sm font-medium text-slate-700">Fecha</label>
							<input id="date" name="date" type="date" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100">
						</div>
						<div></div>
						<div>
							<label for="start_time" class="mb-2 block text-sm font-medium text-slate-700">Hora de comienzo</label>
							<input id="start_time" name="start_time" type="time" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100">
						</div>
						<div>
							<label for="end_time" class="mb-2 block text-sm font-medium text-slate-700">Hora de finalización</label>
							<input id="end_time" name="end_time" type="time" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100">
						</div>
					</div>

					<button type="submit" class="w-full min-h-11 rounded-xl bg-sky-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-200">
						Guardar clase
					</button>
				</form>
			</section>
		</div>
	</div>
@endsection

<script>
	function filterSubjects() {
		const groupSelect = document.getElementById('group_id');
		const subjectSelect = document.getElementById('subject_id');
		const groupId = groupSelect.value;
		let visibleSubjects = 0;

		subjectSelect.value = '';
		Array.from(subjectSelect.options).forEach((option) => {
			const belongsToGroup = option.dataset.groupId === groupId;
			option.hidden = option.value !== '' && !belongsToGroup;
			option.disabled = option.value !== '' && !belongsToGroup;
			if (belongsToGroup) {
				visibleSubjects++;
			}
		});

		subjectSelect.disabled = !groupId || visibleSubjects === 0;
		subjectSelect.options[0].textContent = groupId && visibleSubjects === 0
			? 'No hay asignaturas en este grupo'
			: 'Selecciona una asignatura';
	}
</script>
