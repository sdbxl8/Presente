@extends('layouts.app')

@section('content')
	@php
		$profileSubject = $profileUser->role === 'teacher'
			? ($profileUser->subject_name ?: 'Sin asignatura asignada')
			: ($profileUser->group?->subjects?->pluck('name')->filter()->implode(', ') ?: 'Sin asignatura asignada');
		$profileInitials = strtoupper(substr($profileUser->name, 0, 1) . substr($profileUser->surname, 0, 1));
		$profilePhotoUrl = $profileUser->photo
			? asset('storage/' . ltrim($profileUser->photo, '/'))
			: null;
	@endphp

	<div class="mx-auto max-w-4xl space-y-6">
		<header class="space-y-2">
			<p class="text-sm font-semibold uppercase tracking-[0.18em] text-sky-700">Cuenta</p>
			<h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Mi perfil</h1>
			<p class="text-sm leading-6 text-slate-600">{{ $profileUser->role === 'teacher' ? 'Profesor' : 'Alumno' }}</p>
		</header>

		@if (session('success'))
			<p class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800" role="status">
				{{ session('success') }}
			</p>
		@endif

		<section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm" aria-labelledby="profile-details-title">
			<div class="flex flex-col gap-5 border-b border-slate-200 p-4 sm:flex-row sm:items-center sm:p-6">
				<div class="flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-full bg-sky-50 text-2xl font-bold text-sky-700 ring-1 ring-sky-100">
					<img
						id="profile-photo-preview"
						src="{{ $profilePhotoUrl ?? '' }}"
						alt="Foto de perfil de {{ $profileUser->name }}"
						class="{{ $profilePhotoUrl ? '' : 'hidden' }} h-full w-full object-cover"
					>
					<span id="profile-photo-fallback" class="{{ $profilePhotoUrl ? 'hidden' : '' }}">
						{{ $profileInitials }}
					</span>
				</div>

				<div class="min-w-0 flex-1">
					<h2 id="profile-details-title" class="text-lg font-semibold text-slate-900">Foto de perfil</h2>
					<p id="profile-photo-feedback" class="mt-1 min-h-5 text-sm text-slate-500" aria-live="polite"></p>
				</div>

				<form method="POST" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data" class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row">
					@csrf
					<input id="profile-photo-input" name="photo" type="file" accept="image/*" required class="sr-only">
					<button
						type="button"
						id="profile-photo-button"
						class="inline-flex min-h-11 items-center justify-center rounded-xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-200"
					>
						Elegir foto
					</button>
					<button
						type="submit"
						id="profile-photo-save"
						hidden
						class="inline-flex min-h-11 items-center justify-center rounded-xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-200"
					>
						Guardar foto
					</button>
					<button
						type="button"
						id="profile-photo-reset"
						hidden
						class="inline-flex min-h-11 items-center justify-center rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-200"
					>
						Descartar
					</button>
					@error('photo')
						<p class="text-sm text-rose-700">{{ $message }}</p>
					@enderror
				</form>
			</div>

			<div class="p-4 sm:p-6">
				<h2 class="text-base font-semibold text-slate-900">Datos personales</h2>

				<div class="mt-3 divide-y divide-slate-200">
					@foreach ([
						['key' => 'name', 'label' => 'Nombre', 'value' => $profileUser->name, 'type' => 'text', 'editable' => true, 'maxlength' => 25],
						['key' => 'surname', 'label' => 'Apellidos', 'value' => $profileUser->surname, 'type' => 'text', 'editable' => true, 'maxlength' => 40],
						['key' => 'subject_name', 'label' => 'Asignatura', 'value' => $profileSubject, 'type' => 'text', 'editable' => $profileUser->role === 'teacher', 'maxlength' => 100],
						['key' => 'email', 'label' => 'Correo electrónico', 'value' => $profileUser->email, 'type' => 'email', 'editable' => true, 'maxlength' => 255],
					] as $field)
						@if ($field['editable'])
						<form method="POST" action="{{ route('profile.update') }}" class="flex flex-col gap-3 py-4 sm:flex-row sm:items-center sm:justify-between" data-profile-row>
							@csrf
							@method('PATCH')
						@else
						<div class="flex flex-col gap-3 py-4 sm:flex-row sm:items-center sm:justify-between">
						@endif
							<div class="min-w-0 flex-1">
								<label for="profile-{{ $field['key'] }}" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
									{{ $field['label'] }}
								</label>
								<p class="mt-1 wrap-break-word text-sm font-medium text-slate-900" data-profile-display>
									{{ $field['value'] }}
								</p>
								<input
									id="profile-{{ $field['key'] }}"
									name="{{ $field['key'] }}"
									type="{{ $field['type'] }}"
									value="{{ old($field['key'], $field['value']) }}"
									maxlength="{{ $field['maxlength'] }}"
									required
									class="hidden mt-2 min-h-11 w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100"
									data-profile-input
								>
								@error($field['key'])
									<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>
								@enderror
							</div>

							@if ($field['editable'])
							<div class="flex w-full gap-2 sm:w-auto">
								<button type="button" class="min-h-10 flex-1 rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-200 sm:flex-none" data-profile-edit>
									Editar
								</button>
								<button type="submit" class="hidden min-h-10 flex-1 rounded-lg bg-sky-600 px-3 py-2 text-sm font-semibold text-white transition hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-200 sm:flex-none" data-profile-save>
									Guardar
								</button>
								<button type="button" class="hidden min-h-10 flex-1 rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-200 sm:flex-none" data-profile-cancel>
									Cancelar
								</button>
							</div>
							@endif
						@if ($field['editable'])
						</form>
						@else
						</div>
						@endif
					@endforeach
				</div>
			</div>
		</section>
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', () => {
			document.querySelectorAll('[data-profile-row]').forEach((row) => {
				const display = row.querySelector('[data-profile-display]');
				const input = row.querySelector('[data-profile-input]');
				const editButton = row.querySelector('[data-profile-edit]');
				const saveButton = row.querySelector('[data-profile-save]');
				const cancelButton = row.querySelector('[data-profile-cancel]');
				let originalValue = input.value;

				editButton.addEventListener('click', () => {
					originalValue = display.textContent.trim();
					input.value = originalValue;
					display.classList.add('hidden');
					input.classList.remove('hidden');
					editButton.classList.add('hidden');
					saveButton.classList.remove('hidden');
					cancelButton.classList.remove('hidden');
					input.focus();
				});

				cancelButton.addEventListener('click', () => {
					input.value = originalValue;
					finishEditing();
				});

				function finishEditing() {
					display.classList.remove('hidden');
					input.classList.add('hidden');
					editButton.classList.remove('hidden');
					saveButton.classList.add('hidden');
					cancelButton.classList.add('hidden');
				}
			});

			const photoInput = document.getElementById('profile-photo-input');
			const photoButton = document.getElementById('profile-photo-button');
			const photoSaveButton = document.getElementById('profile-photo-save');
			const resetButton = document.getElementById('profile-photo-reset');
			const photoPreview = document.getElementById('profile-photo-preview');
			const photoFallback = document.getElementById('profile-photo-fallback');
			const photoFeedback = document.getElementById('profile-photo-feedback');
			let originalPhoto = photoPreview.getAttribute('src');
			let previewUrl = null;

			photoButton.addEventListener('click', () => photoInput.click());

			photoInput.addEventListener('change', () => {
				const file = photoInput.files[0];
				if (!file) {
					return;
				}

				if (!file.type.startsWith('image/')) {
					photoFeedback.textContent = 'Selecciona un archivo de imagen.';
					photoInput.value = '';
					photoSaveButton.hidden = true;
					return;
				}

				if (file.size > 5 * 1024 * 1024) {
					photoFeedback.textContent = 'La imagen debe ocupar menos de 5 MB.';
					photoInput.value = '';
					photoSaveButton.hidden = true;
					return;
				}

				if (previewUrl) {
					URL.revokeObjectURL(previewUrl);
				}

				previewUrl = URL.createObjectURL(file);
				photoPreview.src = previewUrl;
				photoPreview.classList.remove('hidden');
				photoFallback.classList.add('hidden');
				photoFeedback.textContent = file.name;
				photoSaveButton.hidden = false;
				resetButton.hidden = false;
			});

			resetButton.addEventListener('click', () => {
				if (previewUrl) {
					URL.revokeObjectURL(previewUrl);
					previewUrl = null;
				}

				photoInput.value = '';
				photoPreview.src = originalPhoto || '';
				photoPreview.classList.toggle('hidden', !originalPhoto);
				photoFallback.classList.toggle('hidden', Boolean(originalPhoto));
				photoFeedback.textContent = '';
				photoSaveButton.hidden = true;
				resetButton.hidden = true;
			});
		});
	</script>
@endsection
