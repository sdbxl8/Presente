@php
    $triggerClass = $triggerClass ?? '';
    $avatarSizeClass = $avatarSizeClass ?? 'h-9 w-9';
    $showLabel = $showLabel ?? false;
    $menuPosition = $menuPosition ?? 'right-0 top-full mt-2 w-52';
    $profileUser = auth()->user();
@endphp

<details class="group relative">
    <summary class="{{ $triggerClass }} list-none [&::-webkit-details-marker]:hidden" aria-label="Abrir menú de perfil">
        <span class="{{ $avatarSizeClass }} flex shrink-0 items-center justify-center overflow-hidden rounded-full bg-slate-200 text-xs font-bold text-slate-600">
            @if ($profileUser->photo)
                <img src="{{ asset('storage/' . ltrim($profileUser->photo, '/')) }}" alt="Foto de perfil de {{ $profileUser->name }}" class="h-full w-full object-cover">
            @else
                P
            @endif
        </span>
        @if ($showLabel)
            <span>Perfil</span>
        @endif
    </summary>

    <div class="absolute {{ $menuPosition }} z-50 overflow-hidden rounded-xl border border-slate-200 bg-white p-1.5 shadow-lg">
        <a href="{{ route('profile.edit') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 hover:text-sky-700">
            Mi perfil
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full rounded-lg px-3 py-2.5 text-left text-sm font-semibold text-rose-700 transition hover:bg-rose-50 focus:outline-none focus:ring-4 focus:ring-rose-100">
                Cerrar sesión
            </button>
        </form>
    </div>
</details>
