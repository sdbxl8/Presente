<a href="{{ route('student.home') }}" class="flex min-h-14 w-full flex-col items-center justify-center gap-1 rounded-xl bg-sky-50 px-2 text-xs font-semibold text-sky-700 lg:min-h-0 lg:flex-row lg:justify-start lg:gap-3 lg:px-4 lg:py-3 lg:text-sm">
    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-sky-600 text-xs text-white lg:h-8 lg:w-8">I</span>
    <span>Inicio</span>
</a>

<button type="button" onclick="window.location.href='{{ route('student.scan') }}'" class="flex min-h-14 w-full flex-col items-center justify-center gap-1 rounded-xl px-2 text-xs font-medium text-slate-500 transition hover:bg-slate-50 hover:text-sky-700 lg:min-h-0 lg:flex-row lg:justify-start lg:gap-3 lg:px-4 lg:py-3 lg:text-sm">
	<span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-xs text-slate-500 lg:h-8 lg:w-8">G</span>
	<span>Escanear</span>
</button>

<button type="button" onclick="window.location.href='{{ route('student.classes') }}'" class="flex min-h-14 w-full flex-col items-center justify-center gap-1 rounded-xl px-2 text-xs font-medium text-slate-500 transition hover:bg-slate-50 hover:text-sky-700 lg:min-h-0 lg:flex-row lg:justify-start lg:gap-3 lg:px-4 lg:py-3 lg:text-sm">
    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-xs text-slate-500 lg:h-8 lg:w-8">C</span>
    <span>Mis clases</span>
</button>

<button type="button" disabled title="Disponible próximamente" class="flex min-h-14 w-full cursor-not-allowed flex-col items-center justify-center gap-1 rounded-xl px-2 text-xs font-medium text-slate-400 lg:min-h-0 lg:flex-row lg:justify-start lg:gap-3 lg:px-4 lg:py-3 lg:text-sm">
    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-xs text-slate-500 lg:h-8 lg:w-8">J</span>
    <span>Justificaciones</span>
</button>
