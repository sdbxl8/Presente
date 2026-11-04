{{-- Inicio --}}
<a
    href="{{ route('student.home') }}"
    class="group flex min-h-14 w-full flex-col items-center justify-center gap-1 rounded-2xl bg-[#effbf6] px-1.5 text-[11px] font-bold text-[#127257] ring-1 ring-inset ring-[#d8f5e7] transition duration-200 hover:bg-[#e4f8ed] focus:outline-none focus-visible:ring-4 focus-visible:ring-[#b5ebd2] lg:min-h-0 lg:flex-row lg:justify-start lg:gap-3 lg:px-4 lg:py-3 lg:text-sm"
>
    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white text-[#168d6b] shadow-sm transition group-hover:bg-[#f7fbf8] lg:h-9 lg:w-9">
        <i data-lucide="House" class="h-5 w-5"></i>
    </span>

    <span class="whitespace-nowrap">Inicio</span>
</a>

{{-- Escanear QR --}}
<button
    type="button"
    onclick="window.location.href='{{ route('student.scan') }}'"
    class="group flex min-h-14 w-full flex-col items-center justify-center gap-1 rounded-2xl px-1.5 text-[11px] font-semibold text-[#789287] transition duration-200 hover:bg-[#effbf6] hover:text-[#127257] focus:outline-none focus-visible:ring-4 focus-visible:ring-[#b5ebd2] lg:min-h-0 lg:flex-row lg:justify-start lg:gap-3 lg:px-4 lg:py-3 lg:text-sm"
>
    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl text-[#168d6b] transition group-hover:bg-white lg:h-9 lg:w-9">
        <i data-lucide="ScanQrCode" class="h-5 w-5"></i>
    </span>

    <span class="whitespace-nowrap">Escanear</span>
</button>

{{-- Mis clases --}}
<button
    type="button"
    onclick="window.location.href='{{ route('student.classes') }}'"
    class="group flex min-h-14 w-full flex-col items-center justify-center gap-1 rounded-2xl px-1.5 text-[11px] font-semibold text-[#789287] transition duration-200 hover:bg-[#effbf6] hover:text-[#127257] focus:outline-none focus-visible:ring-4 focus-visible:ring-[#b5ebd2] lg:min-h-0 lg:flex-row lg:justify-start lg:gap-3 lg:px-4 lg:py-3 lg:text-sm"
>
    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl text-[#168d6b] transition group-hover:bg-white lg:h-9 lg:w-9">
        <i data-lucide="calendar-days" class="h-5 w-5"></i>
    </span>

    <span class="whitespace-nowrap">Mis clases</span>
</button>

{{-- Justificaciones --}}
<button
    type="button"
    onclick="window.location.href='{{ route('student.justifications') }}'"
    class="group flex min-h-14 w-full flex-col items-center justify-center gap-1 rounded-2xl px-1 text-[10px] font-semibold text-[#789287] transition duration-200 hover:bg-[#effbf6] hover:text-[#127257] focus:outline-none focus-visible:ring-4 focus-visible:ring-[#b5ebd2] sm:text-[11px] lg:min-h-0 lg:flex-row lg:justify-start lg:gap-3 lg:px-4 lg:py-3 lg:text-sm"
>
    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl text-[#b96d48] transition group-hover:bg-white lg:h-9 lg:w-9">
        <i data-lucide="file-text" class="h-5 w-5"></i>
    </span>

    <span class="whitespace-nowrap">Justificaciones</span>
</button>
