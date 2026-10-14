@extends('layout.app')

@section('content')
    <div class="min-h-screen bg-slate-100 px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto flex min-h-[calc(100vh-3rem)] max-w-md items-center justify-center">
            <div class="w-full rounded-2xl border border-slate-200 bg-white p-5 shadow-lg sm:p-7 lg:p-8">
                <div class="mb-6 text-center sm:mb-8">
                    <h2 class="text-2xl font-bold tracking-tight text-slate-800 sm:text-3xl">Iniciar sesión</h2>
                    <p class="mt-2 text-sm text-slate-500 sm:text-base">Accede a tu cuenta de Presente</p>
                </div>

                <form class="space-y-4 sm:space-y-5">
                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white sm:text-base"
                            placeholder="tu@email.com"
                        >
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Contraseña</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white sm:text-base"
                            placeholder="••••••••"
                        >
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:text-base"
                    >
                        Iniciar sesión
                    </button>

                    <button
                        type="button"
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 sm:text-base"
                    >
                        Registrarse
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
