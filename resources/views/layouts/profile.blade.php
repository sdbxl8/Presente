@extends('layouts.app')

@section('content')

@php
    $profileSubject = $profileUser->role === 'teacher'
    ? ($profileUser->subject_name ?: 'Sin asignatura asignada')
    : (
        $profileUser->studentGroups
            ->flatMap(fn ($group) => $group->subjects)
            ->pluck('name')
            ->filter()
            ->unique()
            ->implode(', ')
        ?: 'Sin asignatura asignada'
    );
    $profileInitials = strtoupper(
        substr($profileUser->name, 0, 1) . substr($profileUser->surname, 0, 1)
    );

    $profilePhotoUrl = $profileUser->photo
        ? asset('storage/' . ltrim($profileUser->photo, '/'))
        : null;
@endphp

<div class="mx-auto max-w-4xl space-y-7 sm:space-y-8">

    {{-- Cabecera del perfil --}}
    <header class="relative overflow-hidden rounded-[2rem] border border-[#dcefe4] bg-gradient-to-br from-[#eaf8f0] via-white to-[#f1edff] p-6 sm:p-8 lg:p-10">
        <div class="pointer-events-none absolute -right-12 -top-16 h-48 w-48 rounded-full border border-[#c9ead8] sm:h-64 sm:w-64"></div>
        <div class="pointer-events-none absolute -bottom-16 right-24 h-32 w-32 rounded-full bg-[#d8f5e7]/60 blur-2xl"></div>

        <div class="relative z-10">
            <span class="inline-flex items-center gap-2 rounded-full border border-[#c9ead8] bg-white/80 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.14em] text-[#127257]">
                <span class="h-2 w-2 rounded-full bg-[#36b887]"></span>
                Cuenta personal
            </span>

            <h1 class="mt-5 text-3xl font-extrabold tracking-tight text-[#173d31] sm:text-4xl">
                Mi perfil
            </h1>

            <p class="mt-3 max-w-xl text-sm leading-6 text-[#5c7c6e] sm:text-base">
                Consulta y actualiza tus datos personales y tu fotografía de perfil.
            </p>
        </div>
    </header>

    {{-- Mensaje de éxito original --}}
    @if (session('success'))
        <div class="flex items-start gap-3 rounded-2xl border border-[#c9ead8] bg-[#effbf6] px-4 py-4 text-sm font-medium leading-6 text-[#127257] sm:px-5" role="status">
            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white text-[#168d6b] shadow-sm">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6"/>
                </svg>
            </span>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- Tarjeta principal --}}
    <section class="overflow-hidden rounded-[1.75rem] border border-[#e3eee8] bg-white shadow-[0_14px_40px_rgba(30,70,54,0.045)]" aria-labelledby="profile-details-title">

        {{-- Fotografía --}}
        <div class="border-b border-[#edf3ef] bg-gradient-to-r from-[#effbf6] via-white to-white p-5 sm:p-7">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center">

                <div class="flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-[1.75rem] bg-[#eaf8f0] text-2xl font-extrabold text-[#168d6b] shadow-sm ring-1 ring-[#dcefe4]">
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
                    <h2 id="profile-details-title" class="text-lg font-extrabold tracking-tight text-[#173d31]">
                        Tu fotografía
                    </h2>

                    <p class="mt-1 text-sm leading-6 text-[#789287]">
                        Elige una imagen para personalizar tu perfil.
                    </p>

                    <p id="profile-photo-feedback" class="mt-2 min-h-5 break-words text-sm text-[#168d6b]" aria-live="polite"></p>
                </div>

                <form method="POST" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data" class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row sm:flex-wrap">
                    @csrf

                    <input
                        id="profile-photo-input"
                        name="photo"
                        type="file"
                        accept="image/*"
                        required
                        class="sr-only"
                    >

                    <button
                        type="button"
                        id="profile-photo-button"
                        class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-[#168d6b] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#127257] focus:outline-none focus:ring-4 focus:ring-[#b5ebd2]"
                    >
                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 0L8 8m4-4 4 4M4 15v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4"/>
                        </svg>
                        Elegir foto
                    </button>

                    <button
                        type="submit"
                        id="profile-photo-save"
                        hidden
                        class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-[#168d6b] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#127257] focus:outline-none focus:ring-4 focus:ring-[#b5ebd2]"
                    >
                        Guardar foto
                    </button>

                    <button
                        type="button"
                        id="profile-photo-reset"
                        hidden
                        class="inline-flex min-h-11 items-center justify-center rounded-xl border border-[#e3eee8] bg-white px-4 py-2.5 text-sm font-bold text-[#466157] transition hover:bg-[#f7fbf8] focus:outline-none focus:ring-4 focus:ring-[#d8f5e7]"
                    >
                        Descartar
                    </button>

                    @error('photo')
                        <p class="w-full text-sm text-rose-700">{{ $message }}</p>
                    @enderror
                </form>
            </div>
        </div>

        {{-- Datos personales --}}
        <div class="p-5 sm:p-7">
            <div class="mb-5">
                <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#168d6b]">
                    Información de la cuenta
                </p>

                <h2 class="mt-2 text-xl font-extrabold tracking-tight text-[#173d31]">
                    Datos personales
                </h2>

                <p class="mt-1 text-sm leading-6 text-[#789287]">
                    Edita los campos permitidos y guarda los cambios cuando termines.
                </p>
            </div>

            <div class="divide-y divide-[#edf3ef]">
                @foreach ([
                    ['key' => 'name', 'label' => 'Nombre', 'value' => $profileUser->name, 'type' => 'text', 'editable' => true, 'maxlength' => 25],
                    ['key' => 'surname', 'label' => 'Apellidos', 'value' => $profileUser->surname, 'type' => 'text', 'editable' => true, 'maxlength' => 40],
                    ['key' => 'subject_name', 'label' => 'Asignatura', 'value' => $profileSubject, 'type' => 'text', 'editable' => $profileUser->role === 'teacher', 'maxlength' => 100],
                    ['key' => 'email', 'label' => 'Correo electrónico', 'value' => $profileUser->email, 'type' => 'email', 'editable' => true, 'maxlength' => 255],
                ] as $field)

                    @if ($field['editable'])
                        <form method="POST" action="{{ route('profile.update') }}" class="flex flex-col gap-4 py-5 sm:flex-row sm:items-center sm:justify-between sm:gap-6" data-profile-row>
                            @csrf
                            @method('PATCH')
                    @else
                        <div class="flex flex-col gap-4 py-5 sm:flex-row sm:items-center sm:justify-between sm:gap-6">
                    @endif

                        <div class="min-w-0 flex-1">
                            <label for="profile-{{ $field['key'] }}" class="text-xs font-bold uppercase tracking-[0.12em] text-[#789287]">
                                {{ $field['label'] }}
                            </label>

                            <p class="mt-2 break-words text-sm font-semibold leading-6 text-[#29483b]" data-profile-display>
                                {{ $field['value'] }}
                            </p>

                            <input
                                id="profile-{{ $field['key'] }}"
                                name="{{ $field['key'] }}"
                                type="{{ $field['type'] }}"
                                value="{{ old($field['key'], $field['value']) }}"
                                maxlength="{{ $field['maxlength'] }}"
                                required
                                class="mt-2 hidden min-h-11 w-full rounded-xl border border-[#dce8e2] bg-[#f8fbf9] px-3 py-2.5 text-sm text-[#29483b] outline-none transition focus:border-[#5dc9a0] focus:bg-white focus:ring-4 focus:ring-[#5dc9a0]/15"
                                data-profile-input
                            >

                            @error($field['key'])
                                <p class="mt-2 text-sm font-medium text-rose-700">{{ $message }}</p>
                            @enderror
                        </div>

                        @if ($field['editable'])
                            <div class="flex w-full flex-wrap gap-2 sm:w-auto sm:shrink-0">
                                <button
                                    type="button"
                                    class="inline-flex min-h-10 flex-1 items-center justify-center rounded-xl border border-[#e3eee8] bg-white px-4 py-2 text-sm font-bold text-[#466157] transition hover:border-[#b5ebd2] hover:bg-[#effbf6] hover:text-[#127257] focus:outline-none focus:ring-4 focus:ring-[#d8f5e7] sm:flex-none"
                                    data-profile-edit
                                >
                                    Editar
                                </button>

                                <button
                                    type="submit"
                                    class="hidden min-h-10 flex-1 items-center justify-center rounded-xl bg-[#168d6b] px-4 py-2 text-sm font-bold text-white transition hover:bg-[#127257] focus:outline-none focus:ring-4 focus:ring-[#b5ebd2] sm:flex-none"
                                    data-profile-save
                                >
                                    Guardar
                                </button>

                                <button
                                    type="button"
                                    class="hidden min-h-10 flex-1 items-center justify-center rounded-xl border border-[#e3eee8] bg-white px-4 py-2 text-sm font-bold text-[#466157] transition hover:bg-[#f7fbf8] focus:outline-none focus:ring-4 focus:ring-[#d8f5e7] sm:flex-none"
                                    data-profile-cancel
                                >
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

{{-- JavaScript original: edición de datos y previsualización de fotografía --}}
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
