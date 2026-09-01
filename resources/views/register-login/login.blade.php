@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-slate-100 px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto flex min-h-[calc(100vh-4rem)] max-w-5xl items-center justify-center">
            <div class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-slate-200">
                <div class="bg-gradient-to-r from-sky-600 to-indigo-600 px-6 py-8 text-center text-white sm:px-8">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-sky-100">Presente</p>
                    <h1 class="mt-3 text-2xl font-bold sm:text-3xl">Iniciar sesión</h1>
                </div>

                <div class="px-5 py-6 sm:px-8 sm:py-8">
                    <form class="space-y-5" method="POST" action="#">
                        @csrf

                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                autocomplete="email"
                                placeholder="tu@email.com"
                                class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100"
                            >
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Contraseña</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                placeholder="••••••••"
                                class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100"
                            >
                        </div>

                        <button
                            type="submit"
                            class="w-full rounded-xl bg-sky-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-200"
                        >
                            Iniciar sesión
                        </button>
                    </form>

                    <div class="mt-6 text-center text-sm text-slate-600">
                        <a href="{{ route('register') }}" class="font-medium text-sky-700 transition hover:text-sky-800">
                            ¿No tienes cuenta? Regístrate
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection