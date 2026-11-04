<div
    id="create-class-modal"
    class="fixed inset-0 z-50 hidden overflow-y-auto px-4 py-6 sm:px-6 sm:py-8"
    role="dialog"
    aria-modal="true"
    aria-labelledby="create-class-title"
>
    {{-- Fondo oscuro --}}
    <div
        class="fixed inset-0 bg-[#173d31]/50 backdrop-blur-sm"
        onclick="document.getElementById('create-class-modal').classList.add('hidden')"
    ></div>

    {{-- Contenedor del modal --}}
    <div class="relative mx-auto flex min-h-full max-w-lg items-center justify-center">

        <section class="w-full overflow-hidden rounded-[1.75rem] border border-[#e3eee8] bg-white shadow-[0_28px_80px_rgba(23,61,49,0.18)]">

            {{-- Cabecera --}}
            <div class="border-b border-[#edf3ef] bg-gradient-to-br from-[#effbf6] via-white to-[#f1edff] px-5 py-6 sm:px-7 sm:py-7">
                <div class="flex items-start justify-between gap-4">

                    <div>
                        <span class="inline-flex items-center gap-2 rounded-full border border-[#c9ead8] bg-white/80 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.14em] text-[#127257]">
                            <span class="h-2 w-2 rounded-full bg-[#36b887]"></span>
                            Planificación
                        </span>

                        <h2
                            id="create-class-title"
                            class="mt-4 text-2xl font-extrabold tracking-tight text-[#173d31]"
                        >
                            Nueva clase
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-[#789287]">
                            Completa los datos para programar una nueva sesión.
                        </p>
                    </div>

                    <button
                        type="button"
                        onclick="document.getElementById('create-class-modal').classList.add('hidden')"
                        class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-[#e3eee8] bg-white text-xl text-[#789287] transition hover:border-[#b5ebd2] hover:bg-[#effbf6] hover:text-[#127257] focus:outline-none focus:ring-4 focus:ring-[#d8f5e7]"
                        aria-label="Cerrar ventana"
                    >
                        &times;
                    </button>

                </div>
            </div>

            {{-- Formulario original --}}
            <form
                class="space-y-6 p-5 sm:p-7"
                action="{{ route('teacher.classes.store') }}"
                method="POST"
            >
                @csrf

                <div class="grid gap-x-4 gap-y-5 sm:grid-cols-2">

                    {{-- Grupo --}}
                    <div class="sm:col-span-2">
                        <label
                            for="group_id"
                            class="mb-2 block text-sm font-semibold text-[#466157]"
                        >
                            Grupo
                        </label>

                        <select
                            id="group_id"
                            name="group_id"
                            required
                            onchange="filterSubjects()"
                            class="w-full rounded-2xl border border-[#dce8e2] bg-[#f8fbf9] px-4 py-3.5 text-sm text-[#29483b] outline-none transition focus:border-[#5dc9a0] focus:bg-white focus:ring-4 focus:ring-[#5dc9a0]/15"
                        >
                            <option value="">Selecciona un grupo</option>

                            @foreach (($groups ?? collect()) as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>

                        <p class="mt-2 text-xs leading-5 text-[#8ba197]">
                            Selecciona el grupo al que pertenecerá la sesión.
                        </p>
                    </div>

                    {{-- Asignatura --}}
                    <div class="sm:col-span-2">
                        <label
                            for="subject_id"
                            class="mb-2 block text-sm font-semibold text-[#466157]"
                        >
                            Asignatura
                        </label>

                        <select
                            id="subject_id"
                            name="subject_id"
                            required
                            disabled
                            class="w-full rounded-2xl border border-[#dce8e2] bg-[#f8fbf9] px-4 py-3.5 text-sm text-[#29483b] outline-none transition focus:border-[#5dc9a0] focus:bg-white focus:ring-4 focus:ring-[#5dc9a0]/15 disabled:cursor-not-allowed disabled:bg-[#f1f5f2] disabled:text-[#9aaea4]"
                        >
                            <option value="">Primero selecciona un grupo</option>

                            @foreach (($groups ?? collect()) as $group)
                                @foreach ($group->subjects as $subject)
                                    <option
                                        value="{{ $subject->id }}"
                                        data-group-id="{{ $group->id }}"
                                    >
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>

                        <p class="mt-2 text-xs leading-5 text-[#8ba197]">
                            Las asignaturas disponibles dependerán del grupo elegido.
                        </p>
                    </div>

                    {{-- Fecha --}}
                    <div>
                        <label
                            for="date"
                            class="mb-2 block text-sm font-semibold text-[#466157]"
                        >
                            Fecha
                        </label>

                        <input
                            id="date"
                            name="date"
                            type="date"
                            required
                            class="w-full min-w-0 rounded-2xl border border-[#dce8e2] bg-[#f8fbf9] px-3 py-3.5 text-sm text-[#29483b] outline-none transition focus:border-[#5dc9a0] focus:bg-white focus:ring-4 focus:ring-[#5dc9a0]/15"
                        >
                    </div>

                    {{-- Se conserva el espacio de la estructura original --}}
                    <div></div>

                    {{-- Hora de inicio --}}
                    <div>
                        <label
                            for="start_time"
                            class="mb-2 block text-sm font-semibold text-[#466157]"
                        >
                            Hora de comienzo
                        </label>

                        <input
                            id="start_time"
                            name="start_time"
                            type="time"
                            required
                            class="w-full min-w-0 rounded-2xl border border-[#dce8e2] bg-[#f8fbf9] px-3 py-3.5 text-sm text-[#29483b] outline-none transition focus:border-[#5dc9a0] focus:bg-white focus:ring-4 focus:ring-[#5dc9a0]/15"
                        >
                    </div>

                    {{-- Hora de fin --}}
                    <div>
                        <label
                            for="end_time"
                            class="mb-2 block text-sm font-semibold text-[#466157]"
                        >
                            Hora de finalización
                        </label>

                        <input
                            id="end_time"
                            name="end_time"
                            type="time"
                            required
                            class="w-full min-w-0 rounded-2xl border border-[#dce8e2] bg-[#f8fbf9] px-3 py-3.5 text-sm text-[#29483b] outline-none transition focus:border-[#5dc9a0] focus:bg-white focus:ring-4 focus:ring-[#5dc9a0]/15"
                        >
                    </div>

                </div>

                {{-- Botón original de guardado --}}
                <div class="border-t border-[#edf3ef] pt-5">
                    <button
                        type="submit"
                        class="flex min-h-12 w-full items-center justify-center gap-2 rounded-2xl bg-[#168d6b] px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-emerald-900/10 transition hover:bg-[#127257] hover:shadow-md focus:outline-none focus:ring-4 focus:ring-[#b5ebd2]"
                    >
                        <svg
                            viewBox="0 0 24 24"
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            aria-hidden="true"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>
                        </svg>

                        Guardar clase
                    </button>

                    <p class="mt-3 text-center text-xs text-[#8ba197]">
                        Comprueba la fecha y el horario antes de guardar.
                    </p>
                </div>

            </form>
        </section>
    </div>
</div>

<script>
    function filterSubjects() {
        const groupSelect = document.getElementById('group_id');
        const subjectSelect = document.getElementById('subject_id');
        const groupId = groupSelect.value;
        let visibleSubjects = 0;

        subjectSelect.value = '';

        Array.from(subjectSelect.options).forEach((option) => {
            const belongsToGroup = option.dataset.groupId === groupId;

            option.hidden = option.value !== '' && !belongsToGroup;
            option.disabled = option.value !== '' && !belongsToGroup;

            if (belongsToGroup) {
                visibleSubjects++;
            }
        });

        subjectSelect.disabled = !groupId || visibleSubjects === 0;

        subjectSelect.options[0].textContent = groupId && visibleSubjects === 0
            ? 'No hay asignaturas en este grupo'
            : 'Selecciona una asignatura';
    }
</script>
