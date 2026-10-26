@extends('layouts.login-register')

@section('content')
<div class="min-h-screen bg-[#f5f9f7] text-slate-800 antialiased">
    <div class="mx-auto grid min-h-screen max-w-[1440px] lg:grid-cols-2">

        {{-- Panel visual --}}
        <section class="relative hidden overflow-hidden bg-[#eaf8f0] p-10 lg:flex lg:flex-col lg:justify-between xl:p-14">

            <div class="pointer-events-none absolute -right-20 -top-20 h-72 w-72 rounded-full border border-[#bdebd3]"></div>
            <div class="pointer-events-none absolute -bottom-24 -left-16 h-80 w-80 rounded-full bg-[#c9f0dc]/70 blur-2xl"></div>

            <a href="{{ url('/') }}" class="relative z-10 inline-flex w-fit items-center gap-3">
                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#168d6b] text-white shadow-lg shadow-emerald-900/10">
                    <svg viewBox="0 0 32 32" class="h-7 w-7" fill="none" aria-hidden="true">
                        <path d="M10 5H7a2 2 0 0 0-2 2v3M22 5h3a2 2 0 0 1 2 2v3M5 22v3a2 2 0 0 0 2 2h3M27 22v3a2 2 0 0 1-2 2h-3"
                              stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
                        <path d="m10 16 4 4 8-9" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>

                <span>
                    <span class="block text-2xl font-extrabold tracking-tight text-[#173d31]">Presente</span>
                    <span class="mt-1 block text-[10px] font-bold tracking-[0.16em] text-[#729587]">
                        ASISTENCIA UNIVERSITARIA
                    </span>
                </span>
            </a>

            <div class="relative z-10 my-12 max-w-lg">
                <span class="inline-flex items-center gap-2 rounded-full border border-[#c9ead8] bg-white/70 px-3 py-1.5 text-xs font-bold text-[#168d6b]">
                    <span class="h-2 w-2 rounded-full bg-[#36b887]"></span>
                    TU CAMPUS, MÁS CONECTADO
                </span>

                <h1 class="mt-6 text-4xl font-extrabold leading-tight tracking-tight text-[#173d31] xl:text-5xl">
                    Tu día académico, más sencillo.
                </h1>

                <p class="mt-5 max-w-md text-base leading-7 text-[#5c7c6e]">
                    Organiza tus clases, registra tu asistencia y consulta tu actividad universitaria desde un mismo lugar.
                </p>

                <div class="mt-8 grid max-w-md grid-cols-3 gap-3">
                    <div class="rounded-2xl border border-white/80 bg-white/75 p-4">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#eaf8f0] text-[#168d6b]">
                            <i data-lucide="scan-qr-code" class="h-5 w-5"></i>
                        </span>
                        <p class="mt-3 text-sm font-bold text-[#173d31]">Escanea</p>
                        <p class="mt-1 text-xs leading-5 text-[#729587]">Registra tu asistencia.</p>
                    </div>

                    <div class="rounded-2xl border border-white/80 bg-white/75 p-4">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#fff0e7] text-[#b96d48]">
                            <i data-lucide="calendar-days" class="h-5 w-5"></i>
                        </span>
                        <p class="mt-3 text-sm font-bold text-[#173d31]">Organiza</p>
                        <p class="mt-1 text-xs leading-5 text-[#729587]">Consulta tus clases.</p>
                    </div>

                    <div class="rounded-2xl border border-white/80 bg-white/75 p-4">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#f1edff] text-[#7967b5]">
                            <i data-lucide="clipboard-check" class="h-5 w-5"></i>
                        </span>
                        <p class="mt-3 text-sm font-bold text-[#173d31]">Consulta</p>
                        <p class="mt-1 text-xs leading-5 text-[#729587]">Revisa tu historial.</p>
                    </div>
                </div>
            </div>

            <p class="relative z-10 text-xs font-medium text-[#729587]">
                Menos gestiones, más tiempo para aprender.
            </p>
        </section>

        {{-- Formulario de acceso --}}
        <main class="flex items-center justify-center px-5 py-10 sm:px-8 lg:px-12 xl:px-16">
            <div class="w-full max-w-md">

                <a href="{{ url('/') }}" class="mb-9 inline-flex items-center gap-3 lg:hidden">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#168d6b] text-white">
                        <span class="text-xl font-bold">P</span>
                    </span>
                    <span class="text-2xl font-extrabold tracking-tight text-[#173d31]">Presente</span>
                </a>

                <div class="rounded-[2rem] border border-[#e4eee9] bg-white p-6 shadow-[0_24px_70px_rgba(30,70,54,0.07)] sm:p-9">

                    <div class="mb-8">
                        <span class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-[#eaf8f0] text-[#168d6b]">
                            <i data-lucide="log-in" class="h-6 w-6"></i>
                        </span>

                        <p class="text-sm font-bold text-[#168d6b]">¡Qué bueno verte de nuevo!</p>

                        <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-800">
                            Iniciar sesión
                        </h2>

                        <p class="mt-3 text-sm leading-6 text-slate-500">
                            Accede a tu cuenta para continuar con tu actividad académica.
                        </p>
                    </div>

                    {{-- Mensajes de error --}}
                    @if ($errors->any())
                        <div role="alert" class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    {{-- Se conserva la ruta original de autenticación --}}
                    <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">
                                Correo electrónico
                            </label>

                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                autocomplete="email"
                                required
                                autofocus
                                placeholder="tu@email.com"
                                class="w-full rounded-2xl border border-[#dce8e2] bg-[#f8fbf9] px-4 py-3.5 text-sm text-slate-800 outline-none transition placeholder:text-[#9aaea4] focus:border-[#5dc9a0] focus:bg-white focus:ring-4 focus:ring-[#5dc9a0]/15"
                            >
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">
                                Contraseña
                            </label>

                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                required
                                placeholder="Introduce tu contraseña"
                                class="w-full rounded-2xl border border-[#dce8e2] bg-[#f8fbf9] px-4 py-3.5 text-sm text-slate-800 outline-none transition placeholder:text-[#9aaea4] focus:border-[#5dc9a0] focus:bg-white focus:ring-4 focus:ring-[#5dc9a0]/15"
                            >
                        </div>

                        <button
                            type="submit"
                            class="flex w-full items-center justify-center gap-2 rounded-2xl bg-[#168d6b] px-4 py-3.5 text-sm font-bold text-white shadow-lg shadow-emerald-900/10 transition hover:-translate-y-0.5 hover:bg-[#127257] focus:outline-none focus:ring-4 focus:ring-[#5dc9a0]/30"
                        >
                            Iniciar sesión
                            <i data-lucide="arrow-right" class="h-4 w-4"></i>
                        </button>
                    </form>

                    <div class="my-6 flex items-center gap-3">
                        <span class="h-px flex-1 bg-[#edf3ef]"></span>
                        <span class="text-xs font-medium text-slate-400">¿Todavía no tienes cuenta?</span>
                        <span class="h-px flex-1 bg-[#edf3ef]"></span>
                    </div>

                    <a
                        href="{{ route('register') }}"
                        class="flex w-full items-center justify-center rounded-2xl border border-[#dce8e2] bg-white px-4 py-3.5 text-sm font-bold text-[#466157] transition hover:border-[#b9e6d1] hover:bg-[#f3fbf6]"
                    >
                        Registrarse
                    </a>
                </div>

                <p class="mt-6 text-center text-xs leading-5 text-slate-400">
                    Presente · Asistencia universitaria
                </p>
            </div>
        </main>
    </div>
</div>
@endsection
