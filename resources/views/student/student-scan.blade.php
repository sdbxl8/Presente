@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-5xl space-y-7 sm:space-y-8" data-student-qr-scanner>

        {{-- Cabecera --}}
        <header class="relative overflow-hidden rounded-[2rem] border border-[#dcefe4] bg-gradient-to-br from-[#eaf8f0] via-white to-[#f1edff] p-6 sm:p-8 lg:p-10">
            <div class="pointer-events-none absolute -right-12 -top-16 h-48 w-48 rounded-full border border-[#c9ead8] sm:h-64 sm:w-64"></div>
            <div class="pointer-events-none absolute -bottom-16 right-24 h-32 w-32 rounded-full bg-[#d8f5e7]/60 blur-2xl"></div>

            <div class="relative z-10 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div class="max-w-xl">
                    <span class="inline-flex items-center gap-2 rounded-full border border-[#c9ead8] bg-white/80 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.14em] text-[#127257]">
                        <span class="h-2 w-2 rounded-full bg-[#36b887]"></span>
                        Asistencia presencial
                    </span>

                    <h1 class="mt-5 text-3xl font-extrabold tracking-tight text-[#173d31] sm:text-4xl">
                        Escanear asistencia
                    </h1>

                    <p class="mt-3 text-sm leading-6 text-[#5c7c6e] sm:text-base">
                        Apunta la cámara al código QR que muestra tu profesor para registrar tu presencia en clase.
                    </p>
                </div>

                <span class="flex h-16 w-16 shrink-0 items-center justify-center self-start rounded-[1.35rem] bg-white text-[#168d6b] shadow-sm ring-1 ring-[#dcefe4] sm:h-20 sm:w-20 sm:self-center">
                    <svg viewBox="0 0 32 32" class="h-9 w-9 sm:h-11 sm:w-11" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12V6a1 1 0 0 1 1-1h6M20 5h6a1 1 0 0 1 1 1v6M27 20v6a1 1 0 0 1-1 1h-6M12 27H6a1 1 0 0 1-1-1v-6"/>
                        <rect x="11" y="11" width="10" height="10" rx="1.5"/>
                        <path stroke-linecap="round" d="M14 14h4v4h-4zM5 16h4M23 16h4M16 5v4M16 23v4"/>
                    </svg>
                </span>
            </div>
        </header>

        {{-- Mensaje de operación correcta --}}
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

        {{-- Mensaje de error --}}
        @if (session('error'))
            <div class="flex items-start gap-3 rounded-2xl border border-[#f3cdca] bg-[#fff0ef] px-4 py-4 text-sm font-medium leading-6 text-rose-800 sm:px-5" role="alert">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white text-rose-600 shadow-sm">
                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" d="m9 9 6 6m0-6-6 6"/>
                    </svg>
                </span>

                <p>{{ session('error') }}</p>
            </div>
        @endif

        {{-- Contenido principal del escáner --}}
        <section class="overflow-hidden rounded-[1.75rem] border border-[#e3eee8] bg-white shadow-[0_14px_40px_rgba(30,70,54,0.045)]" aria-labelledby="scanner-title">

            {{-- Cabecera del lector --}}
            <div class="border-b border-[#edf3ef] bg-gradient-to-r from-[#effbf6] via-white to-white px-5 py-5 sm:px-7 sm:py-6">
                <div class="flex items-center gap-3">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#eaf8f0] text-[#168d6b]">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 9V5a1 1 0 0 1 1-1h4M15 4h4a1 1 0 0 1 1 1v4M20 15v4a1 1 0 0 1-1 1h-4M9 20H5a1 1 0 0 1-1-1v-4"/>
                            <rect x="9" y="9" width="6" height="6" rx="1"/>
                        </svg>
                    </span>

                    <div>
                        <h2 id="scanner-title" class="text-lg font-extrabold tracking-tight text-[#173d31]">
                            Lector QR
                        </h2>

                        <p class="mt-1 text-sm text-[#789287]">
                            Coloca el código dentro del área de la cámara.
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-7 lg:p-8">

                {{-- Instrucciones --}}
                <div class="mx-auto mb-6 max-w-xl text-center">
                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-[#f1edff] text-[#7967b5]">
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                            <rect x="3.5" y="3.5" width="6" height="6" rx="1"/>
                            <rect x="14.5" y="3.5" width="6" height="6" rx="1"/>
                            <rect x="3.5" y="14.5" width="6" height="6" rx="1"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.5 14.5h2v2h-2zM18.5 14.5h2M18.5 18.5v2M14.5 20.5h2"/>
                        </svg>
                    </span>

                    <p class="mt-4 text-base font-extrabold text-[#173d31]">
                        Prepara tu cámara
                    </p>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#789287]">
                        Pulsa «Iniciar cámara» y acepta el permiso del navegador. Cuando la cámara esté activa, apunta al QR que proyecta tu profesor.
                    </p>
                </div>

                {{-- Estado dinámico controlado por el JavaScript existente --}}
                <div class="mx-auto mb-5 flex max-w-lg items-start gap-3 rounded-2xl border border-[#e3eee8] bg-[#f7fbf8] p-4">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-[#168d6b] shadow-sm">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <circle cx="12" cy="12" r="9"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 11v5M12 7.5h.01"/>
                        </svg>
                    </span>

                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-bold uppercase tracking-[0.12em] text-[#789287]">
                            Estado del lector
                        </p>

                        <p id="student-scan-status" class="mt-1 min-h-6 text-sm leading-6 text-[#466157]" role="status" aria-live="polite">
                            Pulsa “Iniciar cámara” y permite el acceso cuando el navegador lo solicite.
                        </p>
                    </div>
                </div>

                {{-- Zona de cámara. Se conserva el ID que necesita el escáner. --}}
                <div class="relative mx-auto w-full max-w-md overflow-hidden rounded-[1.5rem] border border-[#dce8e2] bg-[#173d31] p-2 shadow-inner">
                    <div class="pointer-events-none absolute inset-5 z-10 rounded-2xl border border-white/25"></div>

                    <div class="pointer-events-none absolute left-1/2 top-5 z-20 h-0.5 w-3/5 -translate-x-1/2 rounded-full bg-[#72e1b5] opacity-70"></div>

                    <div
                        id="student-qr-reader"
                        class="mx-auto aspect-square w-full overflow-hidden rounded-[1.1rem] bg-[#173d31]"
                    ></div>
                </div>

                {{-- Botones existentes --}}
                <div class="mx-auto mt-6 flex w-full max-w-md flex-col gap-3 sm:flex-row">

                    <button
                        id="student-scan-start"
                        type="button"
                        class="inline-flex min-h-12 flex-1 items-center justify-center gap-2 rounded-2xl bg-[#168d6b] px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-emerald-900/10 transition hover:-translate-y-0.5 hover:bg-[#127257] focus:outline-none focus:ring-4 focus:ring-[#b5ebd2]"
                    >
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 9V5a1 1 0 0 1 1-1h4M15 4h4a1 1 0 0 1 1 1v4M20 15v4a1 1 0 0 1-1 1h-4M9 20H5a1 1 0 0 1-1-1v-4"/>
                            <rect x="9" y="9" width="6" height="6" rx="1"/>
                        </svg>

                        Iniciar cámara
                    </button>

                    <button
                        id="student-scan-stop"
                        type="button"
                        hidden
                        class="inline-flex min-h-12 flex-1 items-center justify-center gap-2 rounded-2xl border border-[#e3eee8] bg-white px-5 py-3.5 text-sm font-bold text-[#466157] transition hover:border-[#f3cdca] hover:bg-[#fff0ef] hover:text-rose-700 focus:outline-none focus:ring-4 focus:ring-[#d8f5e7]"
                    >
                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <rect x="6" y="6" width="12" height="12" rx="2"/>
                        </svg>

                        Detener cámara
                    </button>

                </div>

                {{-- Formulario original: JavaScript gestiona el envío --}}
                <form id="student-attendance-submit" method="POST" class="hidden">
                    @csrf
                </form>

            </div>
        </section>

        {{-- Ayuda contextual --}}
        <section class="grid grid-cols-1 gap-3 sm:grid-cols-2">

            <div class="flex items-start gap-3 rounded-2xl border border-[#e3eee8] bg-white p-4">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#eaf8f0] text-[#168d6b]">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3 4 6v5c0 5.1 3.4 8.5 8 10 4.6-1.5 8-4.9 8-10V6z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12 2.2 2.2 4.8-5"/>
                    </svg>
                </span>

                <div>
                    <h3 class="text-sm font-bold text-[#29483b]">
                        Comprueba el registro
                    </h3>

                    <p class="mt-1 text-xs leading-5 text-[#789287]">
                        Espera a que la aplicación confirme si la asistencia se ha registrado correctamente.
                    </p>
                </div>
            </div>

            <div class="flex items-start gap-3 rounded-2xl border border-[#e9e3fb] bg-white p-4">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#f1edff] text-[#7967b5]">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8.5 9a3.5 3.5 0 1 1 5.7 2.7c-1.4 1.1-2.2 1.7-2.2 3.3"/>
                        <circle cx="12" cy="12" r="9"/>
                    </svg>
                </span>

                <div>
                    <h3 class="text-sm font-bold text-[#463b72]">
                        ¿No funciona la cámara?
                    </h3>

                    <p class="mt-1 text-xs leading-5 text-[#7967b5]">
                        Comprueba los permisos del navegador y que estás utilizando una conexión segura.
                    </p>
                </div>
            </div>

        </section>
    </div>
@endsection
