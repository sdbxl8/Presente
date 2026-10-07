@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <section class="grid gap-4 xl:grid-cols-[2.2fr_0.8fr]">
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            @include('layouts.calendar')
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Resumen del profesor</h2>

            <div class="mt-4 space-y-3">
                <div class="rounded-xl bg-slate-50 p-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Grupos</p>
                    <p class="mt-1 text-lg font-bold text-slate-900">{{ $groups->count() }}</p>
                </div>

                @forelse ($groups->take(2) as $group)
                    <div class="rounded-xl bg-slate-50 p-3">
                        <p class="font-semibold text-slate-800">{{ $group->name }}</p>
                        <p class="text-sm text-slate-500">{{ $group->students->count() }} alumnos</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Todavía no tienes grupos.</p>
                @endforelse
            </div>

            <div class="mt-5 space-y-3">
                <button type="button" onclick="document.getElementById('create-class-modal').classList.remove('hidden')" class="block w-full rounded-xl bg-sky-600 px-4 py-3 text-center text-sm font-semibold text-white transition hover:bg-sky-700">
                    Crear clase
                </button>
                <a href="{{ route('teacher.classes') }}" class="block rounded-xl border border-slate-200 px-4 py-3 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Ver clases
                </a>
            </div>
        </div>
    </section>

    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-900">Justificantes pendientes</h2>
        <div class="mt-4 space-y-3">
            @forelse ($pendingJustifications as $justification)
                <div class="rounded-xl bg-amber-50 p-3">
                    <p class="font-semibold text-amber-900">{{ $justification->attendance->student->name }}</p>
                    <p class="text-sm text-amber-800">{{ $justification->attendance->classSession->subject->name }}</p>
                </div>
            @empty
                <p class="text-sm text-slate-500">No hay justificantes pendientes.</p>
            @endforelse
        </div>
    </section>
</div>

@include('teacher.create-class-modal', ['groups' => $groups])

@endsection
