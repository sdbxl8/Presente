
<div id="start-class-modal-{{ $classSession->id }}" class="{{ session('open_class_id') == $classSession->id ? '' : 'hidden' }} fixed inset-0 z-50 overflow-y-auto px-4 py-8 sm:px-6">
    <div class="fixed inset-0 bg-slate-950/40" onclick="document.getElementById('start-class-modal-{{ $classSession->id }}').classList.add('hidden')"></div>

    <div class="relative mx-auto flex min-h-full max-w-3xl items-center justify-center">
        <section class="w-full rounded-2xl bg-white p-5 shadow-2xl ring-1 ring-slate-200 sm:p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">Asistencia</p>
                    <h2 id="start-class-title-{{ $classSession->id }}" class="mt-2 text-xl font-bold text-slate-900">Iniciar clase</h2>
                    <p class="mt-1 text-sm text-slate-500">Revisa los datos de la sesión antes de comenzar.</p>
                </div>
                <button type="button" onclick="document.getElementById('start-class-modal-{{ $classSession->id }}').classList.add('hidden')" class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-100 text-lg text-slate-500 transition hover:bg-slate-200 hover:text-slate-800" aria-label="Cerrar ventana">
                    &times;
                </button>
            </div>

            <div class="mt-6 grid gap-6 lg:grid-cols-[minmax(0,1fr)_minmax(16rem,20rem)]">
                <div class="space-y-5">
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="rounded-xl bg-slate-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Asignatura</p>
                            <p class="mt-1 font-semibold text-slate-900">{{ $classSession->subject->name }}</p>
                        </div>
                        <div class="rounded-xl bg-slate-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Grupo</p>
                            <p class="mt-1 font-semibold text-slate-900">{{ $classSession->subject->group->name }}</p>
                        </div>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="rounded-xl border border-slate-200 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Hora de inicio</p>
                            <p class="mt-1 text-lg font-bold text-slate-900">{{ substr($classSession->start_time, 0, 5) }}</p>
                        </div>
                        <div class="rounded-xl border border-slate-200 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Hora de cierre</p>
                            <p class="mt-1 text-lg font-bold text-slate-900">{{ substr($classSession->end_time, 0, 5) }}</p>
                        </div>
                    </div>

					<div id="qr-panel-{{ $classSession->id }}" class="flex min-h-64 items-center justify-center rounded-2xl border-2 border-dashed border-sky-200 bg-sky-50/60 p-6 text-center sm:min-h-72">
                        <div>
                            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-xl bg-white text-sm font-bold tracking-wider text-sky-600 shadow-sm ring-1 ring-sky-100">QR</div>
							<p id="qr-status-{{ $classSession->id }}" class="mt-4 text-sm font-semibold text-slate-700">Control todavía sin iniciar</p>
							<p id="countdown-{{ $classSession->id }}" class="mt-1 text-2xl font-bold tabular-nums text-sky-700">10:00</p>
							<p class="mt-1 text-xs text-slate-500">Los alumnos podrán escanearlo cuando comience el control.</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 sm:p-5">
					<div class="flex items-center justify-between gap-3">
						<div>
							<p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Asistencia</p>
							<h3 class="mt-1 text-base font-semibold text-slate-900">Resumen del grupo</h3>
						</div>
						<span class="rounded-full bg-slate-200 px-2.5 py-1 text-xs font-semibold text-slate-600">{{ $classSession->subject->group->students->count() }} alumnos</span>
					</div>
                    <div class="mt-5 space-y-3">
						<div class="flex items-center justify-between rounded-xl bg-white px-3 py-3 shadow-sm"><span class="text-sm text-slate-600">Dentro</span><span id="present-count-{{ $classSession->id }}" class="text-lg font-bold text-emerald-600">0</span></div>
						<div class="flex items-center justify-between rounded-xl bg-white px-3 py-3 shadow-sm"><span class="text-sm text-slate-600">Han llegado tarde</span><span id="late-count-{{ $classSession->id }}" class="text-lg font-bold text-amber-600">0</span></div>
						<div class="flex items-center justify-between rounded-xl bg-white px-3 py-3 shadow-sm"><span class="text-sm text-slate-600">Ausentes</span><span id="absent-count-{{ $classSession->id }}" class="text-lg font-bold text-rose-600">{{ $classSession->subject->group->students->count() }}</span></div>
                    </div>
					<div class="mt-5 max-h-40 space-y-2 overflow-y-auto rounded-xl border border-slate-200 bg-white p-3">
						<p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-500">Alumnos</p>
						@forelse ($classSession->subject->group->students as $student)
							<div class="flex items-center justify-between gap-3 text-sm">
								<span class="truncate text-slate-700">{{ $student->name }} {{ $student->surname }}</span>
								<span class="student-status shrink-0 rounded-full bg-rose-50 px-2 py-1 text-xs font-semibold text-rose-700">Ausente</span>
							</div>
						@empty
							<p class="text-sm text-slate-500">Este grupo no tiene alumnos.</p>
						@endforelse
					</div>
					<form action="{{ route('teacher.classes.open', $classSession) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="mt-5 inline-flex min-h-11 w-full items-center justify-center rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-200">Comenzar control</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
	function startAttendanceControl(classId) {
		const button = document.getElementById(`start-control-${classId}`);
		const status = document.getElementById(`qr-status-${classId}`);
		const countdown = document.getElementById(`countdown-${classId}`);
		let remainingSeconds = 600;

		button.disabled = true;
		button.textContent = 'Control iniciado';
		button.classList.add('cursor-not-allowed', 'opacity-60');
		status.textContent = 'Control activo';
		status.classList.add('text-emerald-700');

		const timer = window.setInterval(() => {
			remainingSeconds -= 1;
			const minutes = Math.floor(remainingSeconds / 60).toString().padStart(2, '0');
			const seconds = (remainingSeconds % 60).toString().padStart(2, '0');
			countdown.textContent = `${minutes}:${seconds}`;

			if (remainingSeconds <= 0) {
				window.clearInterval(timer);
				status.textContent = 'Control finalizado';
				button.textContent = 'Control finalizado';
			}
		}, 1000);
	}
</script>
