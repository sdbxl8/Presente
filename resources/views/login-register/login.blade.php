@extends('layouts.app')

@section('content')
    <div class="mx-auto flex min-h-[calc(100vh-10rem)] w-full max-w-6xl items-center justify-center py-2 sm:py-5">
        <div class="grid w-full overflow-hidden rounded-[2rem] border border-[#e4eee9] bg-white shadow-[0_24px_70px_rgba(30,70,54,0.08)] lg:min-h-[590px] lg:grid-cols-2">

            {{-- Panel visual de marca: solo presentación, sin lógica de aplicación --}}
            <section class="relative hidden overflow-hidden bg-[#eaf8f0] p-9 lg:flex lg:flex-col lg:justify-between xl:p-12">
                <div class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full border border-[#bdebd3]"></div>
                <div class="pointer-events-none absolute -right-5 -top-5 h-40 w-40 rounded-full border border-[#ccefdc]"></div>
                <div class="pointer-events-none absolute -bottom-28 -left-20 h-80 w-80 rounded-full bg-[#c9f0dc]/70 blur-2xl"></div>

                <div class="relative z-10 inline-flex items-center gap-3">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#168d6b] text-white shadow-lg shadow-emerald-900/10">
                        <svg viewBox="0 0 32 32" class="h-7 w-7" fill="none" aria-hidden="true">
                            <path d="M10 5H7a2 2 0 0 0-2 2v3M22 5h3a2 2 0 0 1 2 2v3M5 22v3a2 2 0 0 0 2 2h3M27 22v3a2 2 0 0 1-2 2h-3" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
                            <path d="m10 16 4 4 8-9" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span>
                        <span class="block text-xl font-extrabold tracking-tight text-[#173d31]">Presente</span>
                        <span class="mt-0.5 block text-[10px] font-bold tracking-[0.16em] text-[#729587]">ASISTENCIA UNIVERSITARIA</span>
                    </span>
                </div>

                <div class="relative z-10 my-10 max-w-lg xl:my-0">
                    <span class="inline-flex items-center gap-2 rounded-full border border-[#c9ead8] bg-white/70 px-3 py-1.5 text-xs font-bold text-[#168d6b]">
                        <span class="h-2 w-2 rounded-full bg-[#36b887]"></span>
                        TU CAMPUS, MÁS CONECTADO
                    </span>

                    <h2 class="mt-6 text-4xl font-extrabold leading-[1.12] tracking-tight text-[#173d31] xl:text-5xl">
                        Tu día académico,<br>más sencillo.
                    </h2>
                    <p class="mt-5 max-w-md text-base leading-7 text-[#5c7c6e]">
                        Organiza tus clases, registra tu asistencia y ten tu actividad universitaria siempre a mano.
                    </p>

                    <div class="mt-6 flex flex-wrap gap-2 text-xs font-bold">
                        <span class="rounded-full bg-[#eaf8f0] px-3 py-1.5 text-[#168d6b]">Asistencia QR</span>
                        <span class="rounded-full bg-[#fff0e7] px-3 py-1.5 text-[#a9603d]">Clases</span>
                        <span class="rounded-full bg-[#f1edff] px-3 py-1.5 text-[#7563ac]">Historial</span>
                    </div>

                    {{-- Tarjeta decorativa --}}
                    <div class="mt-9 max-w-sm rounded-3xl border border-white/80 bg-white/85 p-5 shadow-[0_16px_40px_rgba(30,70,54,0.07)] backdrop-blur-sm">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#eaf8f0] text-[#168d6b]">
                                    <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <rect x="4" y="4" width="6" height="6" rx="1"/>
                                        <rect x="14" y="4" width="6" height="6" rx="1"/>
                                        <rect x="4" y="14" width="6" height="6" rx="1"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 14h2v2h-2zM18 14h2M18 18v2M14 20h2"/>
                                    </svg>
                                </span>
                                <span>
                                    <span class="block text-sm font-bold text-slate-800">Registro de asistencia</span>
                                    <span class="mt-1 block text-xs text-slate-500">Rápido, claro y organizado</span>
                                </span>
                            </div>
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#e5f8ee] text-[#168d6b]">
                                <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4 10 4 4 8-8"/>
                                </svg>
                            </span>
                        </div>
                        <div class="mt-5 flex gap-1.5" aria-hidden="true">
                            <span class="h-1.5 flex-1 rounded-full bg-[#168d6b]"></span>
                            <span class="h-1.5 flex-1 rounded-full bg-[#8ddbb9]"></span>
                            <span class="h-1.5 flex-1 rounded-full bg-[#d6f1e2]"></span>
                            <span class="h-1.5 flex-1 rounded-full bg-[#d6f1e2]"></span>
                            <span class="h-1.5 flex-1 rounded-full bg-[#d6f1e2]"></span>
                        </div>
                    </div>
                </div>

                <p class="relative z-10 text-xs font-medium text-[#729587]">
                    Menos gestiones, más tiempo para aprender.
                </p>
            </section>

            {{-- Formulario original: mismos campos, nombres y tipos de botón --}}
            <section class="flex items-center justify-center px-5 py-9 sm:px-9 sm:py-12 lg:px-12 xl:px-16">
                <div class="w-full max-w-md">
                    <div class="mb-8 lg:hidden">
                        <div class="inline-flex items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#168d6b] text-white shadow-sm">
                                <svg viewBox="0 0 32 32" class="h-6 w-6" fill="none" aria-hidden="true">
                                    <path d="M10 5H7a2 2 0 0 0-2 2v3M22 5h3a2 2 0 0 1 2 2v3M5 22v3a2 2 0 0 0 2 2h3M27 22v3a2 2 0 0 1-2 2h-3" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
                                    <path d="m10 16 4 4 8-9" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span class="text-2xl font-extrabold tracking-tight text-[#173d31]">Presente</span>
                        </div>
                    </div>

                    <div class="mb-8">
                        <span class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-[#eaf8f0] text-[#168d6b]">
                            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/>
                            </svg>
                        </span>
                        <p class="text-sm font-bold text-[#168d6b]">¡Qué bueno verte de nuevo!</p>
                        <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-800 sm:text-4xl">Iniciar sesión</h2>
                        <p class="mt-3 text-sm leading-6 text-slate-500 sm:text-base">Accede a tu cuenta de Presente.</p>
                    </div>

                    <form class="space-y-5 sm:space-y-6">
                        <div>
                            <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                class="app-input"
                                placeholder="tu@email.com"
                            >
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Contraseña</label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="app-input"
                                placeholder="••••••••"
                            >
                        </div>

                        <button
                            type="submit"
                            class="app-button-primary w-full"
                        >
                            Iniciar sesión
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/>
                            </svg>
                        </button>

                        <button
                            type="button"
                            class="app-button-secondary w-full"
                        >
                            Registrarse
                        </button>
                    </form>

                    <p class="mt-7 text-center text-xs leading-5 text-slate-400">
                        Una forma más sencilla de estar al día.
                    </p>
                </div>
            </section>
        </div>
    </div>
@endsection
