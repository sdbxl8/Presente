<div id="create-class-modal" class="fixed inset-0 z-50 hidden overflow-y-auto px-4 py-8 sm:px-6" role="dialog" aria-modal="true" aria-labelledby="create-class-title">
    <div class="fixed inset-0 bg-slate-950/40" onclick="document.getElementById('create-class-modal').classList.add('hidden')"></div>

    <div class="relative mx-auto flex min-h-full max-w-lg items-center justify-center">
        <section class="w-full rounded-2xl bg-white p-5 shadow-2xl ring-1 ring-slate-200 sm:p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-sky-700">Planificación</p>
                    <h2 id="create-class-title" class="mt-2 text-xl font-bold text-slate-900">Nueva clase</h2>
                    <p class="mt-1 text-sm text-slate-500">Completa los datos de la sesión.</p>
                </div>
                <button type="button" onclick="document.getElementById('create-class-modal').classList.add('hidden')" class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-100 text-lg text-slate-500 transition hover:bg-slate-200 hover:text-slate-800" aria-label="Cerrar ventana">
                    &times;
                </button>
            </div>

            <form class="mt-6 space-y-5" action="{{ route('teacher.classes.store') }}" method="POST">
                @csrf
                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="group_id" class="mb-2 block text-sm font-medium text-slate-700">Grupo</label>
                        <select id="group_id" name="group_id" required onchange="filterSubjects()" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100">
                            <option value="">Selecciona un grupo</option>
                            @foreach (($groups ?? collect()) as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="subject_id" class="mb-2 block text-sm font-medium text-slate-700">Asignatura</label>
                        <select id="subject_id" name="subject_id" required disabled class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100">
                            <option value="">Primero selecciona un grupo</option>
                            @foreach (($groups ?? collect()) as $group)
                                @foreach ($group->subjects as $subject)
                                    <option value="{{ $subject->id }}" data-group-id="{{ $group->id }}">{{ $subject->name }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="date" class="mb-2 block text-sm font-medium text-slate-700">Fecha</label>
                        <input id="date" name="date" type="date" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100">
                    </div>
                    <div></div>
                    <div>
                        <label for="start_time" class="mb-2 block text-sm font-medium text-slate-700">Hora de comienzo</label>
                        <input id="start_time" name="start_time" type="time" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100">
                    </div>
                    <div>
                        <label for="end_time" class="mb-2 block text-sm font-medium text-slate-700">Hora de finalización</label>
                        <input id="end_time" name="end_time" type="time" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100">
                    </div>
                </div>

                <button type="submit" class="w-full min-h-11 rounded-xl bg-sky-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-200">
                    Guardar clase
                </button>
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
