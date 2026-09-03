@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-5xl space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-sky-700">Profesor</p>
                <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Mis grupos</h1>
                <p class="mt-2 max-w-xl text-sm leading-6 text-slate-600">Crea y organiza los grupos que impartes.</p>
            </div>

            <button type="button" onclick="document.getElementById('create-group-modal').classList.remove('hidden')" class="inline-flex min-h-11 items-center justify-center rounded-xl bg-sky-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-200">
                Crear grupo
            </button>
        </div>

        <section class="rounded-2xl border border-dashed border-slate-300 bg-white/70 px-5 py-10 text-center sm:px-8" aria-labelledby="groups-title">
            @forelse ($groups as $group)
                <div class="flex flex-col items-center justify-center gap-4">
                    <h2 class="text-lg font-semibold text-slate-900">{{ $group->name }}</h2>
                </div>
                <button type="button" onclick="document.getElementById('edit-group-modal-{{ $group->id }}').classList.remove('hidden')" class="mt-5 inline-flex min-h-11 items-center justify-center rounded-xl bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-sky-50 hover:text-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-100">
                    Modificar grupo
                </button>
            @empty
             <h2 id="groups-title" class="text-lg font-semibold text-slate-900">Todavía no hay grupos</h2>
            @endforelse
        </section>
    </div>

    @foreach ($groups as $group)
        <div id="edit-group-modal-{{ $group->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto px-4 py-8 sm:px-6" role="dialog" aria-modal="true" aria-labelledby="edit-group-title-{{ $group->id }}">
            <div class="fixed inset-0 bg-slate-950/40" onclick="document.getElementById('edit-group-modal-{{ $group->id }}').classList.add('hidden')"></div>

            <div class="relative mx-auto flex min-h-full max-w-lg items-center justify-center">
                <section class="w-full rounded-2xl bg-white p-5 shadow-2xl ring-1 ring-slate-200 sm:p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-sky-700">Modificar grupo</p>
                            <h2 id="edit-group-title-{{ $group->id }}" class="mt-2 text-xl font-bold text-slate-900">{{ $group->name }}</h2>
                            <p class="mt-1 text-sm text-slate-500">Añade alumnos y asigna las asignaturas del grupo.</p>
                        </div>
                        <button type="button" onclick="document.getElementById('edit-group-modal-{{ $group->id }}').classList.add('hidden')" class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-100 text-lg text-slate-500 transition hover:bg-slate-200 hover:text-slate-800" aria-label="Cerrar ventana">
                            &times;
                        </button>
                    </div>

                    <form class="mt-6 space-y-5" action="#" method="POST">
                        @csrf
                        <div class="space-y-3">
                            <div class="flex items-center justify-between gap-3">
                                <h3 class="text-sm font-semibold text-slate-800">Alumnos</h3>
                                <button type="button" onclick="document.getElementById('add-student-modal-{{ $group->id }}').classList.remove('hidden')" class="inline-flex min-h-9 items-center justify-center rounded-lg border border-sky-200 px-3 py-2 text-xs font-semibold text-sky-700 transition hover:bg-sky-50 focus:outline-none focus:ring-4 focus:ring-sky-100">
                                    Añadir alumno
                                </button>
                            </div>
                            <ul class="space-y-2 rounded-xl border border-slate-200 bg-slate-50 p-3">
                                @forelse ($group->students as $student)
                                    <li class="rounded-lg bg-white px-3 py-2 text-sm text-slate-700 shadow-sm">
                                        {{ $student->name }} {{ $student->surname }}
                                    </li>
                                @empty
                                    <li class="px-3 py-2 text-sm text-slate-500">Todavía no hay alumnos añadidos.</li>
                                @endforelse
                            </ul>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between gap-3">
                                <h3 class="text-sm font-semibold text-slate-800">Asignaturas</h3>
                                <button type="button" onclick="document.getElementById('add-subject-modal-{{ $group->id }}').classList.remove('hidden')" class="inline-flex min-h-9 items-center justify-center rounded-lg border border-sky-200 px-3 py-2 text-xs font-semibold text-sky-700 transition hover:bg-sky-50 focus:outline-none focus:ring-4 focus:ring-sky-100">
                                    Añadir asignatura
                                </button>
                            </div>
                            <ul class="space-y-2 rounded-xl border border-slate-200 bg-slate-50 p-3">
                                @forelse ($group->subjects as $subject)
                                    <li class="rounded-lg bg-white px-3 py-2 text-sm text-slate-700 shadow-sm">
                                        {{ $subject->name }}
                                    </li>
                                @empty
                                    <li class="px-3 py-2 text-sm text-slate-500">Todavía no hay asignaturas añadidas.</li>
                                @endforelse
                            </ul>
                        </div>

                        <button type="submit" class="w-full min-h-11 rounded-xl bg-sky-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-200">
                            Guardar cambios
                        </button>
                    </form>
                </section>
            </div>
        </div>

        <div id="add-student-modal-{{ $group->id }}" class="fixed inset-0 z-[60] hidden overflow-y-auto px-4 py-8 sm:px-6" role="dialog" aria-modal="true" aria-labelledby="add-student-title-{{ $group->id }}">
            <div class="fixed inset-0 bg-slate-950/40" onclick="document.getElementById('add-student-modal-{{ $group->id }}').classList.add('hidden')"></div>

            <div class="relative mx-auto flex min-h-full max-w-md items-center justify-center">
                <section class="w-full rounded-2xl bg-white p-5 shadow-2xl ring-1 ring-slate-200 sm:p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-sky-700">{{ $group->name }}</p>
                            <h2 id="add-student-title-{{ $group->id }}" class="mt-2 text-xl font-bold text-slate-900">Añadir alumnos</h2>
                        </div>
                        <button type="button" onclick="document.getElementById('add-student-modal-{{ $group->id }}').classList.add('hidden')" class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-100 text-lg text-slate-500 transition hover:bg-slate-200 hover:text-slate-800" aria-label="Cerrar ventana">
                            &times;
                        </button>
                    </div>

                    <form class="mt-6 space-y-5" action="#" method="POST">
                        @csrf
                        <fieldset class="space-y-2">
                            <legend class="mb-3 text-sm font-medium text-slate-700">Selecciona los alumnos</legend>
                            @forelse (($students ?? collect()) as $student)
                                <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 px-3 py-3 text-sm text-slate-700 transition hover:border-sky-200 hover:bg-sky-50">
                                    <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                                    <span>{{ $student->name }} {{ $student->surname }}</span>
                                </label>
                            @empty
                                <p class="rounded-xl bg-slate-50 px-3 py-4 text-sm text-slate-500">No hay alumnos disponibles.</p>
                            @endforelse
                        </fieldset>

                        <button type="submit" class="w-full min-h-11 rounded-xl bg-sky-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-200">
                            Añadir seleccionados
                        </button>
                    </form>
                </section>
            </div>
        </div>

        <div id="add-subject-modal-{{ $group->id }}" class="fixed inset-0 z-[60] hidden overflow-y-auto px-4 py-8 sm:px-6" role="dialog" aria-modal="true" aria-labelledby="add-subject-title-{{ $group->id }}">
            <div class="fixed inset-0 bg-slate-950/40" onclick="document.getElementById('add-subject-modal-{{ $group->id }}').classList.add('hidden')"></div>

            <div class="relative mx-auto flex min-h-full max-w-md items-center justify-center">
                <section class="w-full rounded-2xl bg-white p-5 shadow-2xl ring-1 ring-slate-200 sm:p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-sky-700">{{ $group->name }}</p>
                            <h2 id="add-subject-title-{{ $group->id }}" class="mt-2 text-xl font-bold text-slate-900">Añadir asignaturas</h2>
                        </div>
                        <button type="button" onclick="document.getElementById('add-subject-modal-{{ $group->id }}').classList.add('hidden')" class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-100 text-lg text-slate-500 transition hover:bg-slate-200 hover:text-slate-800" aria-label="Cerrar ventana">
                            &times;
                        </button>
                    </div>

                    <form class="mt-6 space-y-5" action="#" method="POST">
                        @csrf
                        <div>
                            <label for="subject_ids-{{ $group->id }}" class="mb-2 block text-sm font-medium text-slate-700">Selecciona una o varias asignaturas</label>
                            <select id="subject_ids-{{ $group->id }}" name="subject_ids[]" multiple class="min-h-32 w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100" onchange="showSelectedSubjects({{ $group->id }})">
                                @forelse (($subjects ?? $group->subjects ?? collect()) as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @empty
                                    <option disabled>No hay asignaturas disponibles</option>
                                @endforelse
                            </select>
                            <p class="mt-2 text-xs text-slate-500">Mantén pulsada la tecla Ctrl o Cmd para elegir varias.</p>
                        </div>

                        <div id="selected-subjects-{{ $group->id }}" class="hidden rounded-xl border border-sky-100 bg-sky-50 p-3">
                            <p class="text-xs font-semibold uppercase tracking-wide text-sky-700">Asignaturas seleccionadas</p>
                            <ul class="mt-2 space-y-1 text-sm text-slate-700"></ul>
                        </div>

                        <button type="submit" class="w-full min-h-11 rounded-xl bg-sky-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-200">
                            Añadir seleccionadas
                        </button>
                    </form>
                </section>
            </div>
        </div>
    @endforeach

    <div id="create-group-modal" class="fixed inset-0 z-50 hidden overflow-y-auto px-4 py-8 sm:px-6" role="dialog" aria-modal="true" aria-labelledby="create-group-title">
        <div class="fixed inset-0 bg-slate-950/40" onclick="document.getElementById('create-group-modal').classList.add('hidden')"></div>

        <div class="relative mx-auto flex min-h-full max-w-lg items-center justify-center">
            <section class="w-full rounded-2xl bg-white p-5 shadow-2xl ring-1 ring-slate-200 sm:p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-sky-700">Grupos</p>
                        <h2 id="create-group-title" class="mt-2 text-xl font-bold text-slate-900">Nuevo grupo</h2>
                        <p class="mt-1 text-sm text-slate-500">El formulario se conectará más adelante con el controlador.</p>
                    </div>
                    <button type="button" onclick="document.getElementById('create-group-modal').classList.add('hidden')" class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-100 text-lg text-slate-500 transition hover:bg-slate-200 hover:text-slate-800" aria-label="Cerrar ventana">
                        &times;
                    </button>
                </div>

                <form class="mt-6 space-y-5" action="{{ route('teacher.groups.store') }}" method="POST">
                    @csrf
                    <div>
                        <label for="group_name" class="mb-2 block text-sm font-medium text-slate-700">Nombre del grupo</label>
                        <input
                            id="group_name"
                            name="name"
                            type="text"
                            placeholder="Ejemplo: 1º DAW A"
                            class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100"
                        >
                    </div>
                    <button type="submit" class="w-full min-h-11 rounded-xl bg-sky-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-200">
                        Guardar grupo
                    </button>
                </form>
            </section>
        </div>
    </div>
@endsection

<script>
    function showSelectedSubjects(groupId) {
        const select = document.getElementById(`subject_ids-${groupId}`);
        const container = document.getElementById(`selected-subjects-${groupId}`);
        const list = container.querySelector('ul');

        list.innerHTML = '';

        Array.from(select.selectedOptions).forEach((option) => {
            const item = document.createElement('li');
            item.textContent = option.text;
            list.appendChild(item);
        });

        container.classList.toggle('hidden', select.selectedOptions.length === 0);
    }
</script>
