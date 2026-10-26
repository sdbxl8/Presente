
<button
    type="button"
    onclick="window.location.href='{{ route('teacher.groups') }}'"
    class="group flex min-h-14 w-full flex-col items-center justify-center gap-1 rounded-2xl px-2 text-xs font-semibold text-slate-500 transition duration-200 hover:bg-[#effbf6] hover:text-[#127257] focus:outline-none focus-visible:ring-4 focus-visible:ring-[#b5ebd2] lg:min-h-0 lg:flex-row lg:justify-start lg:gap-3 lg:px-4 lg:py-3 lg:text-sm"
>
    <span class="flex h-8 w-8 items-center justify-center rounded-xl text-[#168d6b] transition group-hover:bg-white lg:h-9 lg:w-9">
        <i data-lucide="users" class="h-4 w-4 lg:h-5 lg:w-5"></i>
    </span>
    <span>Grupos</span>
</button>

<button
    type="button"
    onclick="window.location.href='{{ route('teacher.classes') }}'"
    class="group flex min-h-14 w-full flex-col items-center justify-center gap-1 rounded-2xl px-2 text-xs font-semibold text-slate-500 transition duration-200 hover:bg-[#effbf6] hover:text-[#127257] focus:outline-none focus-visible:ring-4 focus-visible:ring-[#b5ebd2] lg:min-h-0 lg:flex-row lg:justify-start lg:gap-3 lg:px-4 lg:py-3 lg:text-sm"
>
    <span class="flex h-8 w-8 items-center justify-center rounded-xl text-[#168d6b] transition group-hover:bg-white lg:h-9 lg:w-9">
        <i data-lucide="calendar-days" class="h-4 w-4 lg:h-5 lg:w-5"></i>
    </span>
    <span>Clases</span>
</button>

<button
    type="button"
    onclick="window.location.href='{{ route('teacher.justifications') }}'"
    class="group flex min-h-14 w-full flex-col items-center justify-center gap-1 rounded-2xl px-2 text-xs font-semibold text-slate-500 transition duration-200 hover:bg-[#effbf6] hover:text-[#127257] focus:outline-none focus-visible:ring-4 focus-visible:ring-[#b5ebd2] lg:min-h-0 lg:flex-row lg:justify-start lg:gap-3 lg:px-4 lg:py-3 lg:text-sm"
>
    <span class="flex h-8 w-8 items-center justify-center rounded-xl text-[#168d6b] transition group-hover:bg-white lg:h-9 lg:w-9">
        <i data-lucide="file-text" class="h-4 w-4 lg:h-5 lg:w-5"></i>
    </span>
    <span>Justificantes</span>
</button>
