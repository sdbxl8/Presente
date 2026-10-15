@extends('layouts.login-register')

@section('content')
    <div class="min-h-screen bg-slate-100 px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto flex min-h-[calc(100vh-4rem)] max-w-5xl items-center justify-center">
            <div class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-slate-200">
                <div class="bg-gradient-to-r from-sky-600 to-indigo-600 px-6 py-8 text-center text-white sm:px-8">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-sky-100">Presente</p>
                    <h1 class="mt-3 text-2xl font-bold sm:text-3xl">Crear cuenta</h1>
                </div>

                <div class="px-5 py-6 sm:px-8 sm:py-8">
                    <form class="space-y-5" method="POST" action="{{ route('register.store') }}">
                        @csrf

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Nombre</label>
                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    autocomplete="given-name"
                                    placeholder="Nombre"
                                    class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100"
                                >
                            </div>

                            <div>
                                <label for="surname" class="mb-2 block text-sm font-medium text-slate-700">Apellido</label>
                                <input
                                    id="surname"
                                    name="surname"
                                    type="text"
                                    autocomplete="family-name"
                                    placeholder="Apellido"
                                    class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100"
                                >
                            </div>
                        </div>

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
                                autocomplete="new-password"
                                placeholder="••••••••"
                                class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100"
                            >
                        </div>

                        <div>
                            <label for="role" class="mb-2 block text-sm font-medium text-slate-700">Rol</label>
                            <select
                                id="role"
                                name="role"
                                class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100"
                                required...
                            >
                                <option value="">Selecciona un rol</option>
                                <option value="teacher" @selected(old('role') === 'teacher')>Profesor</option>
                                <option value="student" @selected(old('role') === 'student')>Alumno</option>
                            </select>
                        </div>

                        <div id="teacher-subject-field" class="{{ old('role') === 'teacher' ? '' : 'hidden' }}">
                            <label for="subject_name" class="mb-2 block text-sm font-medium text-slate-700">
                                Asignatura del profesor
                            </label>
                            <input
                                id="subject_name"
                                name="subject_name"
                                type="text"
                                maxlength="100"
                                value="{{ old('subject_name') }}"
                                placeholder="Ejemplo: Programación"
                                class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100"
                            >
                            @error('subject_name')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            class="w-full rounded-xl bg-sky-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-200"
                        >
                            Registrarse
                        </button>
                    </form>

                    <div class="mt-6 text-center text-sm text-slate-600">
                        <a href="{{ route('login') }}" class="font-medium text-sky-700 transition hover:text-sky-800">
                            Ya tengo cuenta
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

<script>
document.addEventListener('DOMContentLoaded', () => {
    const roleField = document.getElementById('role');
    const subjectField = document.getElementById('subject_name');
    const subjectContainer = document.getElementById('teacher-subject-field');

    const updateSubjectField = () => {
        const isTeacher = roleField.value === 'teacher';

        subjectContainer.classList.toggle('hidden', !isTeacher);
        subjectField.required = isTeacher;

        if (!isTeacher) {
            subjectField.value = '';
        }
    };

    roleField.addEventListener('change', updateSubjectField);
    updateSubjectField();
});
</script>
