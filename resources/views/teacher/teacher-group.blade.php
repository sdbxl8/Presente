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
            <h2 id="groups-title" class="text-lg font-semibold text-slate-900">Todavía no hay grupos</h2>
            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">Cuando guardes un grupo, aquí podrás modificarlo para añadir alumnos y asignaturas.</p>
            <button type="button" class="mt-5 inline-flex min-h-11 items-center justify-center rounded-xl bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-500" disabled>
                Modificar grupo
            </button>
        </section>
    </div>

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

                <form class="mt-6 space-y-5" action="#" method="POST">
                    @csrf
                    <div>
                        <label for="group_name" class="mb-2 block text-sm font-medium text-slate-700">Nombre del grupo</label>
                        <input
                            id="group_name"
                            name="group_name"
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
