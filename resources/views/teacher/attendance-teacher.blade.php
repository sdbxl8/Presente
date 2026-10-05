@extends('layouts.app')

@section('content')
	@php
		$justifications = $justifications ?? collect();
	@endphp

	<div class="mx-auto max-w-5xl space-y-6">
		<header class="space-y-2">
			<p class="text-sm font-semibold uppercase tracking-[0.18em] text-sky-700">Profesor</p>
			<h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Justificantes</h1>
			<p class="max-w-2xl text-sm leading-6 text-slate-600">Revisa los justificantes enviados por tus alumnos.</p>
		</header>

		<section class="grid grid-cols-2 gap-3 sm:max-w-md sm:gap-4" aria-label="Resumen de justificantes">
			<div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
				<p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Recibidos</p>
				<p class="mt-2 text-2xl font-bold text-slate-900">{{ $justifications->count() }}</p>
			</div>
			<div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 shadow-sm sm:p-5">
				<p class="text-xs font-semibold uppercase tracking-wide text-amber-800">Pendientes</p>
				<p class="mt-2 text-2xl font-bold text-amber-900">{{ $justifications->count() }}</p>
			</div>
		</section>

		<section class="space-y-3" aria-labelledby="justifications-title">
			<div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
				<div>
					<h2 id="justifications-title" class="text-lg font-semibold text-slate-900">Solicitudes recibidas</h2>
					<p class="mt-1 text-sm text-slate-500">Cada solicitud incluye el motivo y, si se adjuntó, su documento.</p>
				</div>
			</div>

			@forelse ($justifications as $justification)
				@php
					$attendance = $justification->attendance;
					$student = $attendance?->student;
					$classSession = $attendance?->classSession;
					$studentName = trim(($student?->name ?? '') . ' ' . ($student?->surname ?? ''));
					$documentPath = $justification->document_path;
				@endphp

				<article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
					<div class="space-y-4 p-4 sm:p-5 lg:p-6">
						<div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
							<div class="min-w-0">
								<p class="text-xs font-semibold uppercase tracking-[0.16em] text-sky-700">
									{{ $classSession?->subject?->group?->name ?? 'Grupo pendiente' }}
								</p>
								<h3 class="mt-1 wrap-break-word text-base font-semibold text-slate-900">
									{{ $studentName !== '' ? $studentName : 'Alumno' }}
								</h3>
								<p class="mt-1 text-sm text-slate-600">
									{{ $classSession?->subject?->name ?? 'Clase' }}
									<span class="px-1 text-slate-300" aria-hidden="true">|</span>
									{{ $classSession?->date ? \Illuminate\Support\Carbon::parse($classSession->date)->format('d/m/Y') : 'Fecha pendiente' }}
								</p>
							</div>

							<span class="inline-flex w-fit shrink-0 items-center rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-800">
								Pendiente de revisión
							</span>
						</div>

						<div class="rounded-xl bg-slate-50 p-3 sm:p-4">
							<p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Motivo</p>
							<p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-700">{{ $justification->reason }}</p>
						</div>

						<div class="flex flex-col gap-3 border-t border-slate-100 pt-4 sm:flex-row sm:items-center sm:justify-between">
							<div class="min-w-0">
								<p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Documento</p>
								<p class="mt-1 truncate text-sm text-slate-700">
									{{ $documentPath ? basename($documentPath) : 'No se adjuntó ningún archivo' }}
								</p>
							</div>

							@if ($documentPath)
								<button type="button" data-justification-download="{{ $justification->id }}" data-document-path="{{ $documentPath }}" class="inline-flex min-h-10 w-full items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-sky-300 hover:bg-sky-50 hover:text-sky-800 focus:outline-none focus:ring-4 focus:ring-sky-100 sm:w-auto">
									Descargar documento
								</button>
							@endif
						</div>

						<div class="grid grid-cols-1 gap-2 border-t border-slate-100 pt-4 sm:grid-cols-2 sm:justify-end">
							<button type="button" data-justification-action="reject" data-justification-id="{{ $justification->id }}" class="inline-flex min-h-11 items-center justify-center rounded-xl border border-rose-200 px-4 py-2.5 text-sm font-semibold text-rose-700 transition hover:bg-rose-50 focus:outline-none focus:ring-4 focus:ring-rose-100">
								Denegar justificante
							</button>
							<button type="button" data-justification-action="approve" data-justification-id="{{ $justification->id }}" class="inline-flex min-h-11 items-center justify-center rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-200">
								Aceptar justificante
							</button>
						</div>
					</div>
				</article>
			@empty
				<div class="rounded-2xl border border-dashed border-slate-300 bg-white/70 px-5 py-12 text-center sm:px-8">
					<h3 class="text-base font-semibold text-slate-900">No hay justificantes recibidos</h3>
					<p class="mt-2 text-sm text-slate-500">Cuando un alumno envíe uno, aparecerá aquí para su revisión.</p>
				</div>
			@endforelse
		</section>
	</div>
@endsection
