@extends('layouts.app')

@section('content')
    @php
        $justifications = $justifications ?? collect();
    @endphp

    <div class="mx-auto max-w-6xl space-y-8">

        {{-- Cabecera de la página --}}
        <header class="relative overflow-hidden rounded-[2rem] border border-[#dcefe4] bg-gradient-to-br from-[#eaf8f0] via-white to-[#f1edff] p-6 sm:p-8 lg:p-10">
            <div class="pointer-events-none absolute -right-12 -top-16 h-48 w-48 rounded-full border border-[#c9ead8] sm:h-64 sm:w-64"></div>
            <div class="pointer-events-none absolute -bottom-16 right-24 h-32 w-32 rounded-full bg-[#d8f5e7]/60 blur-2xl"></div>

            <div class="relative z-10 max-w-2xl">
                <span class="inline-flex items-center gap-2 rounded-full border border-[#c9ead8] bg-white/80 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.14em] text-[#127257]">
                    <span class="h-2 w-2 rounded-full bg-[#36b887]"></span>
                    Espacio del profesor
                </span>

                <h1 class="mt-5 text-3xl font-extrabold tracking-tight text-[#173d31] sm:text-4xl">
                    Justificantes
                </h1>

                <p class="mt-3 max-w-xl text-sm leading-6 text-[#5c7c6e] sm:text-base">
                    Revisa las solicitudes de tus alumnos, consulta sus motivos y documentos y gestiona cada resolución desde un mismo lugar.
                </p>
            </div>

            <div class="relative z-10 mt-6 flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-[#168d6b] shadow-sm ring-1 ring-[#dcefe4] sm:absolute sm:bottom-8 sm:right-9 sm:mt-0 sm:h-14 sm:w-14">
                <svg viewBox="0 0 24 24" class="h-6 w-6 sm:h-7 sm:w-7" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 3.75h7l5 5v11.5a.75.75 0 0 1-.75.75h-11.5a.75.75 0 0 1-.75-.75v-15.75A.75.75 0 0 1 6.75 3.75Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 4v5h5M9 14h6M9 17h6"/>
                </svg>
            </div>
        </header>

        {{-- Resumen de justificantes --}}
        <section class="grid grid-cols-1 gap-4 sm:grid-cols-2" aria-label="Resumen de justificantes">

            <div class="group rounded-[1.5rem] border border-[#e3eee8] bg-white p-5 shadow-[0_14px_40px_rgba(30,70,54,0.045)] transition duration-200 hover:-translate-y-0.5 hover:shadow-[0_18px_42px_rgba(30,70,54,0.08)] sm:p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold text-[#789287]">
                            Justificantes recibidos
                        </p>

                        <p class="mt-3 text-3xl font-extrabold tracking-tight text-[#173d31] sm:text-4xl">
                            {{ $justifications->count() }}
                        </p>

                        <p class="mt-2 text-xs text-[#789287]">
                            Solicitudes registradas
                        </p>
                    </div>

                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#eaf8f0] text-[#168d6b] transition group-hover:bg-[#d8f5e7]">
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 3.75h7l5 5v11.5a.75.75 0 0 1-.75.75h-11.5a.75.75 0 0 1-.75-.75v-15.75A.75.75 0 0 1 6.75 3.75Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 4v5h5M9 14h6M9 17h4"/>
                        </svg>
                    </span>
                </div>
            </div>

            <div class="group rounded-[1.5rem] border border-[#f5d8c8] bg-gradient-to-br from-white to-[#fff5eb] p-5 shadow-[0_14px_40px_rgba(30,70,54,0.035)] transition duration-200 hover:-translate-y-0.5 hover:shadow-[0_18px_42px_rgba(30,70,54,0.07)] sm:p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold text-[#98613c]">
                            Pendientes de revisión
                        </p>

                        <p class="mt-3 text-3xl font-extrabold tracking-tight text-[#75472c] sm:text-4xl">
                            {{ $justifications->count() }}
                        </p>

                        <p class="mt-2 text-xs text-[#a87958]">
                            Revisa las solicitudes recibidas
                        </p>
                    </div>

                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#fff0e7] text-[#b96d48] transition group-hover:bg-[#ffe6d7]">
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                            <circle cx="12" cy="12" r="9"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
                        </svg>
                    </span>
                </div>
            </div>

        </section>

        {{-- Listado de solicitudes --}}
        <section class="space-y-5" aria-labelledby="justifications-title">

            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#168d6b]">
                        Gestión académica
                    </p>

                    <h2 id="justifications-title" class="mt-2 text-xl font-extrabold tracking-tight text-[#173d31] sm:text-2xl">
                        Solicitudes recibidas
                    </h2>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-[#789287]">
                        Cada solicitud incluye el motivo de la ausencia y, cuando se ha adjuntado, el documento correspondiente.
                    </p>
                </div>

                <span class="inline-flex w-fit items-center gap-2 rounded-full border border-[#e3eee8] bg-white px-3 py-2 text-xs font-semibold text-[#5c7c6e]">
                    <svg viewBox="0 0 20 20" class="h-4 w-4 text-[#168d6b]" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 5h12M4 10h12M4 15h8"/>
                    </svg>
                    {{ $justifications->count() }} solicitudes
                </span>
            </div>

            @forelse ($justifications as $justification)
                @php
                    $attendance = $justification->attendance;
                    $student = $attendance?->student;
                    $classSession = $attendance?->classSession;
                    $studentName = trim(($student?->name ?? '') . ' ' . ($student?->surname ?? ''));
                    $documentPath = $justification->document_path;
                @endphp

                <article class="overflow-hidden rounded-[1.5rem] border border-[#e3eee8] bg-white shadow-[0_14px_40px_rgba(30,70,54,0.045)] transition duration-200 hover:shadow-[0_18px_42px_rgba(30,70,54,0.075)]">

                    {{-- Información principal --}}
                    <div class="space-y-5 p-5 sm:p-6 lg:p-7">

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                            <div class="flex min-w-0 gap-4">
                                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#eaf8f0] text-[#168d6b]">
                                    <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10l5 5v3"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 4v5h5M7 13h8M7 16h6"/>
                                        <circle cx="18" cy="18" r="3"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 16.5v1.8l1 .6"/>
                                    </svg>
                                </span>

                                <div class="min-w-0">
                                    <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#168d6b]">
                                        {{ $classSession?->subject?->group?->name ?? 'Grupo pendiente' }}
                                    </p>

                                    <h3 class="mt-1.5 break-words text-lg font-bold tracking-tight text-[#173d31]">
                                        {{ $studentName !== '' ? $studentName : 'Alumno' }}
                                    </h3>

                                    <p class="mt-1.5 text-sm leading-6 text-[#789287]">
                                        {{ $classSession?->subject?->name ?? 'Clase' }}

                                        <span class="px-1 text-[#c1d2c8]" aria-hidden="true">·</span>

                                        {{ $classSession?->date ? \Illuminate\Support\Carbon::parse($classSession->date)->format('d/m/Y') : 'Fecha pendiente' }}
                                    </p>
                                </div>
                            </div>

                            <span class="inline-flex w-fit shrink-0 items-center gap-2 rounded-full border border-[#f5d8c8] bg-[#fff5eb] px-3.5 py-2 text-xs font-bold text-[#98613c]">
                                <span class="h-2 w-2 rounded-full bg-[#d99a65]"></span>
                                Pendiente de revisión
                            </span>
                        </div>

                        {{-- Motivo de la solicitud --}}
                        <div class="rounded-2xl border border-[#e3eee8] bg-[#f7fbf8] p-4 sm:p-5">
                            <div class="flex items-center gap-2">
                                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-white text-[#168d6b] shadow-sm">
                                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 3.75h7l5 5v11.5a.75.75 0 0 1-.75.75h-11.5a.75.75 0 0 1-.75-.75v-15.75A.75.75 0 0 1 6.75 3.75Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 4v5h5M9 14h6M9 17h6"/>
                                    </svg>
                                </span>

                                <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#5c7c6e]">
                                    Motivo de la ausencia
                                </p>
                            </div>

                            <p class="mt-3 whitespace-pre-line break-words text-sm leading-7 text-[#466157]">{{ $justification->reason }}</p>
                        </div>

                        {{-- Documento adjunto --}}
                        <div class="flex flex-col gap-3 rounded-2xl border border-[#edf3ef] p-4 sm:flex-row sm:items-center sm:justify-between sm:p-5">
                            <div class="flex min-w-0 items-center gap-3">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#f1edff] text-[#7967b5]">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 3.75h6l5 5v11.5a.75.75 0 0 1-.75.75h-11.5a.75.75 0 0 1-.75-.75V5.25a1.5 1.5 0 0 1 1.5-1.5Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 4v5h5M9 14h6M9 17h4"/>
                                    </svg>
                                </span>

                                <div class="min-w-0">
                                    <p class="text-xs font-bold uppercase tracking-[0.12em] text-[#789287]">
                                        Documento adjunto
                                    </p>

                                    <p class="mt-1 break-words text-sm font-medium text-[#466157]">
                                        {{ $documentPath ? basename($documentPath) : 'No se adjuntó ningún archivo' }}
                                    </p>
                                </div>
                            </div>

                            @if ($documentPath)
                                <button
                                    type="button"
                                    data-justification-download="{{ $justification->id }}"
                                    data-document-path="{{ $documentPath }}"
                                    class="inline-flex min-h-11 w-full shrink-0 items-center justify-center gap-2 rounded-xl border border-[#c9ead8] bg-white px-4 py-2.5 text-sm font-bold text-[#127257] transition hover:border-[#83dbb8] hover:bg-[#effbf6] focus:outline-none focus:ring-4 focus:ring-[#d8f5e7] sm:w-auto"
                                >
                                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0 4-4m-4 4-4-4M5 16v3a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-3"/>
                                    </svg>
                                    Descargar documento
                                </button>
                            @endif
                        </div>

                        {{-- Acciones: se conservan las rutas y los métodos originales --}}
                        <div class="grid grid-cols-1 gap-3 border-t border-[#edf3ef] pt-5 sm:grid-cols-2">

                            <form action="{{ route('teacher.justifications.reject', $justification) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-xl border border-[#f0ceca] bg-white px-4 py-3 text-sm font-bold text-rose-700 transition hover:border-rose-300 hover:bg-rose-50 focus:outline-none focus:ring-4 focus:ring-rose-100"
                                >
                                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m7 7 10 10M17 7 7 17"/>
                                        <circle cx="12" cy="12" r="9"/>
                                    </svg>
                                    Denegar justificante
                                </button>
                            </form>

                            <form action="{{ route('teacher.justifications.approve', $justification) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-xl bg-[#168d6b] px-4 py-3 text-sm font-bold text-white shadow-sm shadow-emerald-900/10 transition hover:bg-[#127257] hover:shadow-md focus:outline-none focus:ring-4 focus:ring-[#b5ebd2]"
                                >
                                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6"/>
                                    </svg>
                                    Aceptar justificante
                                </button>
                            </form>

                        </div>
                    </div>
                </article>

            @empty
                {{-- Estado vacío --}}
                <div class="rounded-[1.75rem] border border-dashed border-[#cfe7d9] bg-white/80 px-5 py-12 text-center shadow-[0_14px_40px_rgba(30,70,54,0.035)] sm:px-8 sm:py-16">
                    <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-[#eaf8f0] text-[#168d6b]">
                        <svg viewBox="0 0 24 24" class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 3.75h7l5 5v11.5a.75.75 0 0 1-.75.75h-11.5a.75.75 0 0 1-.75-.75v-15.75A.75.75 0 0 1 6.75 3.75Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 4v5h5M9 14h6M9 17h4"/>
                        </svg>
                    </span>

                    <h3 class="mt-5 text-lg font-extrabold text-[#173d31]">
                        No hay justificantes recibidos
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#789287]">
                        Cuando un alumno envíe un justificante, aparecerá aquí para que puedas revisarlo.
                    </p>
                </div>
            @endforelse

        </section>
    </div>
@endsection
