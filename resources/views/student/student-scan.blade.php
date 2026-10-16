@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-3xl space-y-6" data-student-qr-scanner>
        <header class="space-y-2">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-sky-700">Asistencia</p>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Escanear clase</h1>
            <p class="text-sm leading-6 text-slate-600">Escanea el código QR que muestra tu profesor para registrar la asistencia.</p>
        </header>

        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800" role="status">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <section class="space-y-5 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6" aria-labelledby="scanner-title">
            <div class="flex flex-col gap-1 text-center">
                <h2 id="scanner-title" class="text-lg font-semibold text-slate-900">Lector QR</h2>
                <p id="student-scan-status" class="min-h-6 text-sm text-slate-600" role="status" aria-live="polite">
                    Pulsa “Iniciar cámara” y permite el acceso cuando el navegador lo solicite.
                </p>
            </div>

            <div id="student-qr-reader" class="mx-auto aspect-square w-full max-w-sm overflow-hidden rounded-xl border border-slate-200 bg-slate-950"></div>

            <div class="mx-auto flex w-full max-w-sm flex-col gap-2 sm:flex-row">
                <button id="student-scan-start" type="button" class="inline-flex min-h-11 flex-1 items-center justify-center rounded-xl bg-sky-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-200">
                    Iniciar cámara
                </button>
                <button id="student-scan-stop" type="button" hidden class="inline-flex min-h-11 flex-1 items-center justify-center rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-200">
                    Detener
                </button>
            </div>

            <form id="student-attendance-submit" method="POST" class="hidden">
                @csrf
            </form>
        </section>
    </div>
@endsection
