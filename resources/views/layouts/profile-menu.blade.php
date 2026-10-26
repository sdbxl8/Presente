@php
    $triggerClass = $triggerClass ?? '';
    $avatarSizeClass = $avatarSizeClass ?? 'h-9 w-9';
    $showLabel = $showLabel ?? false;
    $menuPosition = $menuPosition ?? 'right-0 top-full mt-2 w-52';
    $profileUser = auth()->user();
@endphp

<details class="group relative">
    <summary
        class="{{ $triggerClass }} list-none cursor-pointer rounded-xl transition duration-200 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-[#d9f2e8] [&::-webkit-details-marker]:hidden"
        aria-label="Abrir menú de perfil"
    >
        <span
            class="{{ $avatarSizeClass }} flex shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#e4f5ed] text-xs font-bold text-[#127257] ring-2 ring-white transition duration-200 group-hover:ring-[#ccebdd]"
        >
            @if ($profileUser->photo)
                <img
                    src="{{ asset('storage/' . ltrim($profileUser->photo, '/')) }}"
                    alt="Foto de perfil de {{ $profileUser->name }}"
                    class="h-full w-full object-cover"
                >
            @else
                P
            @endif
        </span>

        @if ($showLabel)
            <span class="text-sm font-semibold text-[#29483d] transition-colors group-hover:text-[#127257]">
                Perfil
            </span>
        @endif
    </summary>

    <div
        class="absolute {{ $menuPosition }} z-50 overflow-hidden rounded-2xl border border-[#e3eee8] bg-white p-2 shadow-[0_18px_45px_rgba(25,75,58,0.14)] ring-1 ring-black/5"
    >
        <a
            href="{{ route('profile.edit') }}"
            class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-[#355448] transition-colors duration-150 hover:bg-[#edf8f2] hover:text-[#127257] focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-[#d9f2e8]"
        >
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#e8f6ee] text-[#168d6b]">
                <i data-lucide="user-round" class="h-4 w-4"></i>
            </span>

            <span>Mi perfil</span>
        </a>

        <div class="my-1.5 border-t border-[#edf2ee]"></div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button
                type="submit"
                class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left text-sm font-semibold text-[#b84b4b] transition-colors duration-150 hover:bg-[#fff1ef] hover:text-[#9f3737] focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-[#ffe0dc]"
            >
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#fff1ef] text-[#c75c54]">
                    <i data-lucide="log-out" class="h-4 w-4"></i>
                </span>

                <span>Cerrar sesión</span>
            </button>
        </form>
    </div>
</details>
