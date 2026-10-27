@extends('layouts.app')

@section('content')

    <div class="mx-auto max-w-7xl space-y-7 sm:space-y-8">

        {{-- Cabecera --}}
        <header class="relative overflow-hidden rounded-[2rem] border border-[#dcefe4] bg-gradient-to-br from-[#eaf8f0] via-white to-[#f1edff] p-6 sm:p-8 lg:p-10">
            <div class="pointer-events-none absolute -right-12 -top-16 h-48 w-48 rounded-full border border-[#c9ead8] sm:h-64 sm:w-64"></div>
            <div class="pointer-events-none absolute -bottom-16 right-24 h-32 w-32 rounded-full bg-[#d8f5e7]/60 blur-2xl"></div>

            <div class="relative z-10 flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
                <div class="max-w-2xl">
                    <span class="inline-flex items-center gap-2 rounded-full border border-[#c9ead8] bg-white/80 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.14em] text-[#127257]">
                        <span class="h-2 w-2 rounded-full bg-[#36b887]"></span>
                        Espacio del profesor
                    </span>

                    <h1 class="mt-5 text-3xl font-extrabold tracking-tight text-[#173d31] sm:text-4xl">
                        Mis grupos
                    </h1>

                    <p class="mt-3 max-w-xl text-sm leading-6 text-[#5c7c6e] sm:text-base">
                        Organiza tus grupos, consulta sus alumnos y gestiona las asignaturas que impartes.
                    </p>
                </div>

                <button
                    type="button"
                    onclick="document.getElementById('create-group-modal').classList.remove('hidden')"
                    class="inline-flex min-h-12 shrink-0 items-center justify-center gap-2 rounded-2xl bg-[#168d6b] px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-emerald-900/10 transition hover:-translate-y-0.5 hover:bg-[#127257] hover:shadow-md focus:outline-none focus:ring-4 focus:ring-[#b5ebd2]"
                >
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>
                    </svg>
                    Crear grupo
                </button>
            </div>
        </header>

        {{-- Resumen de grupos --}}
        <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3" aria-label="Resumen de grupos">
            <article class="rounded-[1.5rem] border border-[#e3eee8] bg-white p-5 shadow-[0_14px_40px_rgba(30,70,54,0.045)] sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold text-[#789287]">Grupos creados</p>
                        <p class="mt-3 text-4xl font-extrabold tracking-tight text-[#173d31]">
                            {{ $groups->count() }}
                        </p>
                        <p class="mt-2 text-xs text-[#789287]">Grupos que gestionas</p>
                    </div>

                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#eaf8f0] text-[#168d6b]">
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                            <circle cx="9" cy="8" r="3.5"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 20v-1.5A4.5 4.5 0 0 1 7 14h4a4.5 4.5 0 0 1 4.5 4.5V20M16 5a3.5 3.5 0 0 1 0 6.5M18 14.5a4.5 4.5 0 0 1 3.5 4.4V20"/>
                        </svg>
                    </span>
                </div>
            </article>

            <article class="rounded-[1.5rem] border border-[#e3eee8] bg-white p-5 shadow-[0_14px_40px_rgba(30,70,54,0.045)] sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold text-[#789287]">Alumnos vinculados</p>
                        <p class="mt-3 text-4xl font-extrabold tracking-tight text-[#173d31]">
                            {{ $groups->sum(fn ($group) => $group->students->count()) }}
                        </p>
                        <p class="mt-2 text-xs text-[#789287]">Suma de alumnos de tus grupos</p>
                    </div>

                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#f1edff] text-[#7967b5]">
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                            <circle cx="9" cy="8" r="3.5"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 20v-1.5A4.5 4.5 0 0 1 7 14h4a4.5 4.5 0 0 1 4.5 4.5V20"/>
                        </svg>
                    </span>
                </div>
            </article>

            <article class="rounded-[1.5rem] border border-[#f5d8c8] bg-gradient-to-br from-white to-[#fff5eb] p-5 shadow-[0_14px_40px_rgba(30,70,54,0.035)] sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold text-[#98613c]">Asignaturas</p>
                        <p class="mt-3 text-4xl font-extrabold tracking-tight text-[#75472c]">
                            {{ $groups->sum(fn ($group) => $group->subjects->count()) }}
                        </p>
                        <p class="mt-2 text-xs text-[#a87958]">Asignaturas asociadas a tus grupos</p>
                    </div>

                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#fff0e7] text-[#b96d48]">
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.75A2.75 2.75 0 0 1 6.75 3H20v16H6.75A2.75 2.75 0 0 0 4 21.75z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.75v16M8 7h8M8 10.5h8"/>
                        </svg>
                    </span>
                </div>
            </article>
        </section>

        {{-- Listado de grupos --}}
        <section class="space-y-5" aria-labelledby="groups-title">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#168d6b]">
                        Organización académica
                    </p>

                    <h2 id="groups-title" class="mt-2 text-xl font-extrabold tracking-tight text-[#173d31] sm:text-2xl">
                        Tus grupos
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-[#789287]">
                        Accede a cada grupo para consultar sus alumnos y asignaturas.
                    </p>
                </div>

                <span class="inline-flex w-fit items-center gap-2 rounded-full border border-[#c9ead8] bg-[#effbf6] px-3.5 py-2 text-xs font-bold text-[#127257]">
                    <span class="h-2 w-2 rounded-full bg-[#36b887]"></span>
                    {{ $groups->count() }} grupos
                </span>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($groups as $group)
                 @php
                    $availableStudentsForGroup = ($students ?? collect())
                        ->whereNotIn('id', $group->students->modelKeys());
                @endphp

                    <article class="group flex min-w-0 flex-col overflow-hidden rounded-[1.5rem] border border-[#e3eee8] bg-white shadow-[0_14px_40px_rgba(30,70,54,0.045)] transition duration-200 hover:-translate-y-0.5 hover:border-[#b5ebd2] hover:shadow-[0_18px_42px_rgba(30,70,54,0.075)]">

                        <div class="border-b border-[#edf3ef] bg-gradient-to-br from-[#effbf6] via-white to-[#f1edff] p-5 sm:p-6">
                            <div class="flex items-start justify-between gap-3">
                                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-lg font-extrabold text-[#168d6b] shadow-sm ring-1 ring-[#e3eee8]">
                                    {{ strtoupper(substr($group->name, 0, 1)) }}
                                </span>

                                <span class="inline-flex items-center gap-1.5 rounded-full border border-[#c9ead8] bg-white/90 px-3 py-1.5 text-xs font-bold text-[#127257]">
                                    <span class="h-1.5 w-1.5 rounded-full bg-[#36b887]"></span>
                                    Grupo activo
                                </span>
                            </div>

                            <h3 class="mt-5 break-words text-xl font-extrabold tracking-tight text-[#173d31]">
                                {{ $group->name }}
                            </h3>

                            <p class="mt-1 text-sm text-[#789287]">
                                Grupo académico
                            </p>
                        </div>

                        <div class="flex flex-1 flex-col p-5 sm:p-6">
                            <div class="grid grid-cols-2 gap-3">
                                <div class="rounded-2xl border border-[#e3eee8] bg-[#f7fbf8] p-3.5">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white text-[#168d6b] shadow-sm">
                                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <circle cx="9" cy="8" r="3.5"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 20v-1.5A4.5 4.5 0 0 1 7 14h4a4.5 4.5 0 0 1 4.5 4.5V20"/>
                                        </svg>
                                    </span>

                                    <p class="mt-3 text-2xl font-extrabold tabular-nums text-[#173d31]">
                                        {{ $group->students->count() }}
                                    </p>

                                    <p class="mt-1 text-xs font-medium text-[#789287]">
                                        Alumnos
                                    </p>
                                </div>

                                <div class="rounded-2xl border border-[#e9e3fb] bg-[#faf8ff] p-3.5">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white text-[#7967b5] shadow-sm">
                                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.75A2.75 2.75 0 0 1 6.75 3H20v16H6.75A2.75 2.75 0 0 0 4 21.75z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.75v16M8 7h8"/>
                                        </svg>
                                    </span>

                                    <p class="mt-3 text-2xl font-extrabold tabular-nums text-[#173d31]">
                                        {{ $group->subjects->count() }}
                                    </p>

                                    <p class="mt-1 text-xs font-medium text-[#789287]">
                                        Asignaturas
                                    </p>
                                </div>
                            </div>

                            <div class="mt-5 flex-1">
                                <p class="text-xs font-bold uppercase tracking-[0.13em] text-[#789287]">
                                    Asignaturas del grupo
                                </p>

                                <div class="mt-3 space-y-2">
                                    @forelse ($group->subjects->take(3) as $subject)
                                        <div class="flex items-center gap-2 rounded-xl border border-[#edf3ef] bg-white px-3 py-2.5">
                                            <span class="h-2 w-2 shrink-0 rounded-full bg-[#9b8bd8]"></span>
                                            <span class="min-w-0 truncate text-sm font-medium text-[#466157]">
                                                {{ $subject->name }}
                                            </span>
                                        </div>
                                    @empty
                                        <p class="rounded-xl border border-dashed border-[#e3eee8] bg-[#f7fbf8] px-3 py-3 text-sm text-[#789287]">
                                            Todavía no hay asignaturas añadidas.
                                        </p>
                                    @endforelse

                                    @if ($group->subjects->count() > 3)
                                        <p class="px-1 text-xs font-semibold text-[#789287]">
                                            Y {{ $group->subjects->count() - 3 }} asignaturas más
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <button
                                type="button"
                                onclick="document.getElementById('edit-group-modal-{{ $group->id }}').classList.remove('hidden')"
                                class="mt-6 inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-2xl bg-[#168d6b] px-4 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-[#127257] focus:outline-none focus:ring-4 focus:ring-[#b5ebd2]"
                            >
                                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.5a2.12 2.12 0 0 1 3 3L9 17l-4 1 1-4Z"/>
                                </svg>
                                Gestionar grupo
                            </button>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full rounded-[1.75rem] border border-dashed border-[#cfe7d9] bg-white/80 px-5 py-12 text-center shadow-[0_14px_40px_rgba(30,70,54,0.035)] sm:px-8 sm:py-16">
                        <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-[#eaf8f0] text-[#168d6b]">
                            <svg viewBox="0 0 24 24" class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                                <circle cx="9" cy="8" r="3.5"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 20v-1.5A4.5 4.5 0 0 1 7 14h4a4.5 4.5 0 0 1 4.5 4.5V20M18 8v6M15 11h6"/>
                            </svg>
                        </span>

                        <h3 class="mt-5 text-lg font-extrabold text-[#173d31]">
                            Todavía no hay grupos
                        </h3>

                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#789287]">
                            Crea tu primer grupo para organizar al alumnado y asociar sus asignaturas.
                        </p>

                        <button
                            type="button"
                            onclick="document.getElementById('create-group-modal').classList.remove('hidden')"
                            class="mt-6 inline-flex min-h-12 items-center justify-center gap-2 rounded-2xl bg-[#168d6b] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#127257] focus:outline-none focus:ring-4 focus:ring-[#b5ebd2]"
                        >
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>
                            </svg>
                            Crear primer grupo
                        </button>
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    {{-- Modal para modificar un grupo --}}
    @foreach ($groups as $group)
        <div
            id="edit-group-modal-{{ $group->id }}"
            class="fixed inset-0 z-50 hidden overflow-y-auto px-4 py-6 sm:px-6 sm:py-8"
            role="dialog"
            aria-modal="true"
            aria-labelledby="edit-group-title-{{ $group->id }}"
        >
            <div
                class="fixed inset-0 bg-[#173d31]/50 backdrop-blur-sm"
                onclick="document.getElementById('edit-group-modal-{{ $group->id }}').classList.add('hidden')"
            ></div>

            <div class="relative mx-auto flex min-h-full max-w-lg items-center justify-center">
                <section class="w-full overflow-hidden rounded-[1.75rem] border border-[#e3eee8] bg-white shadow-[0_28px_80px_rgba(23,61,49,0.18)]">

                    <div class="border-b border-[#edf3ef] bg-gradient-to-br from-[#effbf6] via-white to-[#f1edff] p-5 sm:p-7">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#168d6b]">
                                    Gestión de grupo
                                </p>

                                <h2 id="edit-group-title-{{ $group->id }}" class="mt-2 break-words text-xl font-extrabold tracking-tight text-[#173d31]">
                                    {{ $group->name }}
                                </h2>

                                <p class="mt-2 text-sm leading-6 text-[#789287]">
                                    Consulta a los alumnos y las asignaturas asociadas.
                                </p>
                            </div>

                            <button
                                type="button"
                                onclick="document.getElementById('edit-group-modal-{{ $group->id }}').classList.add('hidden')"
                                class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-[#e3eee8] bg-white text-xl text-[#789287] transition hover:border-[#b5ebd2] hover:bg-[#effbf6] hover:text-[#127257]"
                                aria-label="Cerrar ventana"
                            >
                                &times;
                            </button>
                        </div>
                    </div>

                    <form class="space-y-6 p-5 sm:p-7" action="#" method="POST">
                        @csrf

                        {{-- Alumnos actuales --}}
                        <div>
                            <div class="mb-3 flex items-center justify-between gap-3">
                                <div>
                                    <h3 class="text-sm font-extrabold text-[#29483b]">
                                        Alumnos
                                    </h3>
                                    <p class="mt-1 text-xs text-[#789287]">
                                        {{ $group->students->count() }} alumnos en el grupo
                                    </p>
                                </div>

                                <button
                                    type="button"
                                    onclick="document.getElementById('add-student-modal-{{ $group->id }}').classList.remove('hidden')"
                                    class="inline-flex min-h-10 shrink-0 items-center justify-center gap-1.5 rounded-xl border border-[#c9ead8] bg-white px-3 py-2 text-xs font-bold text-[#127257] transition hover:bg-[#effbf6] focus:outline-none focus:ring-4 focus:ring-[#d8f5e7]"
                                >
                                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>
                                    </svg>
                                    Añadir
                                </button>
                            </div>

                            <ul class="max-h-48 space-y-2 overflow-y-auto rounded-2xl border border-[#e3eee8] bg-[#f7fbf8] p-3">
                                @forelse ($group->students as $student)
                                    <li class="flex items-center gap-3 rounded-xl border border-[#edf3ef] bg-white px-3 py-2.5 text-sm text-[#466157]">
                                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-[#eaf8f0] text-xs font-bold text-[#168d6b]">
                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                        </span>
                                        <span class="min-w-0 truncate font-medium">
                                            {{ $student->name }} {{ $student->surname }}
                                        </span>
                                    </li>
                                @empty
                                    <li class="px-3 py-4 text-center text-sm text-[#789287]">
                                        Todavía no hay alumnos añadidos.
                                    </li>
                                @endforelse
                            </ul>
                        </div>

                        {{-- Asignaturas --}}
                        <div>
                            <div class="mb-3">
                                <h3 class="text-sm font-extrabold text-[#29483b]">
                                    Asignaturas
                                </h3>
                                <p class="mt-1 text-xs text-[#789287]">
                                    {{ $group->subjects->count() }} asignaturas asociadas
                                </p>
                            </div>

                            <ul class="max-h-48 space-y-2 overflow-y-auto rounded-2xl border border-[#e3eee8] bg-[#f7fbf8] p-3">
                                @forelse ($group->subjects as $subject)
                                    <li class="flex items-center gap-3 rounded-xl border border-[#edf3ef] bg-white px-3 py-2.5 text-sm text-[#466157]">
                                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-[#f1edff] text-[#7967b5]">
                                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.75A2.75 2.75 0 0 1 6.75 3H20v16H6.75A2.75 2.75 0 0 0 4 21.75z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.75v16M8 7h8"/>
                                            </svg>
                                        </span>
                                        <span class="min-w-0 truncate font-medium">
                                            {{ $subject->name }}
                                        </span>
                                    </li>
                                @empty
                                    <li class="px-3 py-4 text-center text-sm text-[#789287]">
                                        Todavía no hay asignaturas añadidas.
                                    </li>
                                @endforelse
                            </ul>
                        </div>

                        <button
                            type="submit"
                            class="inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-2xl bg-[#168d6b] px-5 py-3.5 text-sm font-bold text-white transition hover:bg-[#127257] focus:outline-none focus:ring-4 focus:ring-[#b5ebd2]"
                        >
                            Guardar cambios
                        </button>
                    </form>
                </section>
            </div>
        </div>

        {{-- Modal para añadir alumnos --}}
        <div
            id="add-student-modal-{{ $group->id }}"
            class="fixed inset-0 z-[60] hidden overflow-y-auto px-4 py-6 sm:px-6 sm:py-8"
            role="dialog"
            aria-modal="true"
            aria-labelledby="add-student-title-{{ $group->id }}"
        >
            <div
                class="fixed inset-0 bg-[#173d31]/50 backdrop-blur-sm"
                onclick="document.getElementById('add-student-modal-{{ $group->id }}').classList.add('hidden')"
            ></div>

            <div class="relative mx-auto flex min-h-full max-w-md items-center justify-center">
                <section class="w-full overflow-hidden rounded-[1.75rem] border border-[#e3eee8] bg-white shadow-[0_28px_80px_rgba(23,61,49,0.18)]">

                    <div class="border-b border-[#edf3ef] bg-gradient-to-br from-[#effbf6] via-white to-[#f1edff] p-5 sm:p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#168d6b]">
                                    {{ $group->name }}
                                </p>

                                <h2 id="add-student-title-{{ $group->id }}" class="mt-2 text-xl font-extrabold tracking-tight text-[#173d31]">
                                    Añadir alumnos
                                </h2>

                                <p class="mt-2 text-sm leading-6 text-[#789287]">
                                    Selecciona los alumnos que quieres incorporar al grupo.
                                </p>
                            </div>

                            <button
                                type="button"
                                onclick="document.getElementById('add-student-modal-{{ $group->id }}').classList.add('hidden')"
                                class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-[#e3eee8] bg-white text-xl text-[#789287] transition hover:bg-[#effbf6]"
                                aria-label="Cerrar ventana"
                            >
                                &times;
                            </button>
                        </div>
                    </div>

                    <form class="space-y-5 p-5 sm:p-6" action="{{ route('teacher.groups.students', $group) }}" method="POST">
                        @csrf

                        <fieldset class="space-y-2">
                            <legend class="mb-3 text-sm font-bold text-[#466157]">
                                Selecciona los alumnos
                            </legend>

                            <div class="max-h-72 space-y-2 overflow-y-auto">
                                @forelse ($availableStudentsForGroup as $student)
                                    <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-[#e3eee8] bg-[#f7fbf8] px-3 py-3 text-sm text-[#466157] transition hover:border-[#b5ebd2] hover:bg-[#effbf6]">
                                        <input
                                            type="checkbox"
                                            name="student_ids[]"
                                            value="{{ $student->id }}"
                                            class="h-4 w-4 rounded border-[#c8d9cf] text-[#168d6b] focus:ring-[#5dc9a0]"
                                        >

                                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-xs font-bold text-[#168d6b] shadow-sm">
                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                        </span>

                                        <span class="min-w-0 flex-1 font-medium">
                                            {{ $student->name }} {{ $student->surname }}
                                        </span>
                                    </label>
                                @empty
                                    <p class="rounded-xl border border-dashed border-[#cfe7d9] bg-[#f7fbf8] px-3 py-5 text-center text-sm text-[#789287]">
                                        No hay alumnos disponibles.
                                    </p>
                                @endforelse
                            </div>
                        </fieldset>

                        <button
                            type="submit"
                            class="inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-2xl bg-[#168d6b] px-5 py-3.5 text-sm font-bold text-white transition hover:bg-[#127257] focus:outline-none focus:ring-4 focus:ring-[#b5ebd2]"
                        >
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>
                            </svg>
                            Añadir seleccionados
                        </button>
                    </form>
                </section>
            </div>
        </div>
    @endforeach

    {{-- Modal para crear un grupo --}}
    <div
        id="create-group-modal"
        class="fixed inset-0 z-50 hidden overflow-y-auto px-4 py-6 sm:px-6 sm:py-8"
        role="dialog"
        aria-modal="true"
        aria-labelledby="create-group-title"
    >
        <div
            class="fixed inset-0 bg-[#173d31]/50 backdrop-blur-sm"
            onclick="document.getElementById('create-group-modal').classList.add('hidden')"
        ></div>

        <div class="relative mx-auto flex min-h-full max-w-lg items-center justify-center">
            <section class="w-full overflow-hidden rounded-[1.75rem] border border-[#e3eee8] bg-white shadow-[0_28px_80px_rgba(23,61,49,0.18)]">

                <div class="border-b border-[#edf3ef] bg-gradient-to-br from-[#effbf6] via-white to-[#f1edff] p-5 sm:p-7">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#168d6b]">
                                Organización académica
                            </p>

                            <h2 id="create-group-title" class="mt-2 text-xl font-extrabold tracking-tight text-[#173d31]">
                                Nuevo grupo
                            </h2>

                            <p class="mt-2 text-sm leading-6 text-[#789287]">
                                Asigna un nombre para identificar al grupo.
                            </p>
                        </div>

                        <button
                            type="button"
                            onclick="document.getElementById('create-group-modal').classList.add('hidden')"
                            class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-[#e3eee8] bg-white text-xl text-[#789287] transition hover:bg-[#effbf6]"
                            aria-label="Cerrar ventana"
                        >
                            &times;
                        </button>
                    </div>
                </div>

                <form class="space-y-5 p-5 sm:p-7" action="{{ route('teacher.groups.store') }}" method="POST">
                    @csrf

                    <div>
                        <label for="group_name" class="mb-2 block text-sm font-bold text-[#466157]">
                            Nombre del grupo
                        </label>

                        <input
                            id="group_name"
                            name="name"
                            type="text"
                            placeholder="Ejemplo: 1º DAW A"
                            class="w-full rounded-2xl border border-[#dce8e2] bg-[#f8fbf9] px-4 py-3.5 text-sm text-[#29483b] outline-none transition placeholder:text-[#9aaea4] focus:border-[#5dc9a0] focus:bg-white focus:ring-4 focus:ring-[#5dc9a0]/15"
                        >

                        <p class="mt-2 text-xs text-[#8ba197]">
                            Utiliza un nombre fácil de identificar para ti y tus alumnos.
                        </p>
                    </div>

                    <button
                        type="submit"
                        class="inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-2xl bg-[#168d6b] px-5 py-3.5 text-sm font-bold text-white transition hover:bg-[#127257] focus:outline-none focus:ring-4 focus:ring-[#b5ebd2]"
                    >
                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>
                        </svg>
                        Guardar grupo
                    </button>
                </form>
            </section>
        </div>
    </div>
@endsection
