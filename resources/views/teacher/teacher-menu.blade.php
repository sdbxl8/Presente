
{{-- <a href="{{ route('home') }}" class="flex min-h-14 flex-col items-center justify-center gap-1 rounded-xl bg-sky-50 text-xs font-semibold text-sky-700">
        <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-sky-600 text-xs text-white">I</span>
        Inicio
</a> --}}

<button type="button" onclick="window.location.href='{{ route('teacher.groups') }}'" class="flex min-h-14 w-full flex-col items-center justify-center gap-1 rounded-xl px-2 text-xs font-medium text-slate-500 transition hover:bg-slate-50 hover:text-sky-700 lg:min-h-0 lg:flex-row lg:justify-start lg:gap-3 lg:px-4 lg:py-3 lg:text-sm">
	<i data-lucide="users" class="h-3 w-3 lg:h-5 lg:w-5"></i>
	<span>Grupos</span>
</button>

<button type="button" onclick="window.location.href='{{ route('teacher.classes') }}'" class="flex min-h-14 w-full flex-col items-center justify-center gap-1 rounded-xl px-2 text-xs font-medium text-slate-500 transition hover:bg-slate-50 hover:text-sky-700 lg:min-h-0 lg:flex-row lg:justify-start lg:gap-3 lg:px-4 lg:py-3 lg:text-sm">
	<i data-lucide="book-open" class="h-3 w-3 lg:h-5 lg:w-5"></i>
	<span>Clases</span>
</button>

<button type="button" onclick="window.location.href='{{ route('teacher.justifications') }}'" class="flex min-h-14 w-full flex-col items-center justify-center gap-1 rounded-xl px-2 text-xs font-medium text-slate-500 transition hover:bg-slate-50 hover:text-sky-700 lg:min-h-0 lg:flex-row lg:justify-start lg:gap-3 lg:px-4 lg:py-3 lg:text-sm">
	<i data-lucide="file-text" class="h-3 w-3 lg:h-5 lg:w-5"></i>
	<span>Justificantes</span>
</button>
