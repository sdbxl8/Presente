<div id="start-class-modal-{{ $classSession->id }}" class="{{ session('open_class_id') == $classSession->id ? '' : 'hidden' }} fixed inset-0 z-50 overflow-y-auto bg-[#173d31]/10 px-4 py-6 backdrop-blur-sm sm:px-6 sm:py-8">

    {{-- Fondo del modal --}}
    <div
        class="fixed inset-0 bg-[#173d31]/50 backdrop-blur-sm"
        onclick="document.getElementById('start-class-modal-{{ $classSession->id }}').classList.add('hidden')"
    ></div>

    {{-- Contenedor principal --}}
    <div class="relative mx-auto flex min-h-full max-w-6xl items-center justify-center">

        <section class="w-full overflow-hidden rounded-[1.75rem] border border-[#e3eee8] bg-white shadow-[0_28px_80px_rgba(23,61,49,0.18)]">

            {{-- Cabecera --}}
            <div class="relative overflow-hidden border-b border-[#e3eee8] bg-gradient-to-br from-[#eaf8f0] via-white to-[#f1edff] px-5 py-6 sm:px-7 sm:py-7">
                <div class="pointer-events-none absolute -right-12 -top-16 h-48 w-48 rounded-full border border-[#c9ead8]"></div>

                <div class="relative flex items-start justify-between gap-4">
                    <div>
                        <span class="inline-flex items-center gap-2 rounded-full border border-[#c9ead8] bg-white/80 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.14em] text-[#127257]">
                            <span class="h-2 w-2 rounded-full bg-[#36b887]"></span>
                            Control de asistencia
                        </span>

                        <h2 id="start-class-title-{{ $classSession->id }}" class="mt-4 text-2xl font-extrabold tracking-tight text-[#173d31] sm:text-3xl">
                            Iniciar clase
                        </h2>

                        <p class="mt-2 max-w-xl text-sm leading-6 text-[#789287]">
                            Revisa los datos de la sesión y prepara el código QR para registrar la asistencia de tus alumnos.
                        </p>
                    </div>

                    <button
                        type="button"
                        onclick="document.getElementById('start-class-modal-{{ $classSession->id }}').classList.add('hidden')"
                        class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-[#e3eee8] bg-white text-xl text-[#789287] transition hover:border-[#b5ebd2] hover:bg-[#effbf6] hover:text-[#127257] focus:outline-none focus:ring-4 focus:ring-[#d8f5e7]"
                        aria-label="Cerrar ventana"
                    >
                        &times;
                    </button>
                </div>
            </div>

            {{-- Contenido de la sesión --}}
            <div class="grid gap-5 p-4 sm:gap-6 sm:p-6 lg:grid-cols-[minmax(0,1fr)_minmax(17rem,21rem)] lg:p-7">

                {{-- Columna del QR --}}
                <div class="min-w-0 space-y-5">

                    {{-- Información de la clase --}}
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="rounded-2xl border border-[#e3eee8] bg-[#f7fbf8] p-4">
                            <div class="flex items-center gap-3">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#168d6b] shadow-sm">
                                    <i data-lucide="book-open" class="h-5 w-5"></i>
                                </span>

                                <div class="min-w-0">
                                    <p class="text-xs font-bold uppercase tracking-[0.12em] text-[#789287]">
                                        Asignatura
                                    </p>

                                    <p class="mt-1 break-words text-sm font-bold text-[#173d31]">
                                        {{ $classSession->subject->name }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-[#e3eee8] bg-[#f7fbf8] p-4">
                            <div class="flex items-center gap-3">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#7967b5] shadow-sm">
                                    <i data-lucide="users" class="h-5 w-5"></i>
                                </span>

                                <div class="min-w-0">
                                    <p class="text-xs font-bold uppercase tracking-[0.12em] text-[#789287]">
                                        Grupo
                                    </p>

                                    <p class="mt-1 break-words text-sm font-bold text-[#173d31]">
                                        {{ $classSession->subject->group->name }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Horarios --}}
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="rounded-2xl border border-[#e3eee8] bg-white p-4">
                            <p class="text-xs font-bold uppercase tracking-[0.12em] text-[#789287]">
                                Hora de inicio
                            </p>

                            <p class="mt-2 text-2xl font-extrabold tabular-nums tracking-tight text-[#173d31]">
                                {{ substr($classSession->start_time, 0, 5) }}
                            </p>
                        </div>

                        <div class="rounded-2xl border border-[#e3eee8] bg-white p-4">
                            <p class="text-xs font-bold uppercase tracking-[0.12em] text-[#789287]">
                                Hora de cierre
                            </p>

                            <p class="mt-2 text-2xl font-extrabold tabular-nums tracking-tight text-[#173d31]">
                                {{ substr($classSession->end_time, 0, 5) }}
                            </p>
                        </div>
                    </div>

                    {{-- Área del QR: se mantienen el identificador, el canvas y sus datos --}}
                    <div id="qr-panel-{{ $classSession->id }}" class="flex min-h-72 items-center justify-center overflow-hidden rounded-[1.5rem] border border-[#b5ebd2] bg-gradient-to-br from-[#effbf6] via-white to-[#f1edff] p-5 text-center sm:min-h-80 sm:p-8">
                        <div class="flex w-full flex-col items-center">

                            <span class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl border border-[#dcefe4] bg-white text-[#168d6b] shadow-sm">
                                <i data-lucide="scan-qr-code" class="h-6 w-6"></i>
                            </span>

                            <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#168d6b]">
                                Registro presencial
                            </p>

                            <canvas
                                data-qr-url="{{ $attendanceUrl }}"
                                aria-label="Código QR para registrar asistencia"
                                class="mx-auto mt-5 max-w-full rounded-xl bg-white p-2 shadow-sm"
                            ></canvas>

                            <p id="qr-status-{{ $classSession->id }}" class="mt-5 text-sm font-semibold text-[#466157]">
                                Control todavía sin iniciar
                            </p>

                            <p id="countdown-{{ $classSession->id }}" class="mt-2 text-3xl font-extrabold tabular-nums tracking-tight text-[#168d6b]">
                                10:00
                            </p>

                            <p class="mt-2 max-w-sm text-xs leading-5 text-[#789287]">
                                Los alumnos podrán escanear el código cuando comience el control de asistencia.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Panel lateral de asistencia --}}
                <aside class="min-w-0 rounded-[1.5rem] border border-[#e3eee8] bg-[#f7fbf8] p-4 sm:p-5">

                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#168d6b]">
                                En directo
                            </p>

                            <h3 class="mt-2 text-xl font-extrabold tracking-tight text-[#173d31]">
                                Resumen de asistencia
                            </h3>

                            <p class="mt-1 text-sm text-[#789287]">
                                Estado del grupo
                            </p>
                        </div>

                        <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full border border-[#dcefe4] bg-white px-3 py-1.5 text-xs font-bold text-[#466157]">
                            <i data-lucide="users" class="h-3.5 w-3.5 text-[#168d6b]"></i>
                            {{ $classSession->subject->group->students->count() }}
                        </span>
                    </div>

                    {{-- Contadores con los mismos identificadores --}}
                    <div class="mt-5 space-y-3">

                        <div class="flex items-center justify-between gap-3 rounded-2xl border border-[#d8f0e2] bg-white p-3.5">
                            <div class="flex items-center gap-3">
                                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#eaf8f0] text-[#168d6b]">
                                    <i data-lucide="check-circle-2" class="h-5 w-5"></i>
                                </span>

                                <span class="text-sm font-semibold text-[#466157]">
                                    Presentes
                                </span>
                            </div>

                            <span id="present-count-{{ $classSession->id }}" class="text-xl font-extrabold tabular-nums text-[#168d6b]">
                                0
                            </span>
                        </div>

                        <div class="flex items-center justify-between gap-3 rounded-2xl border border-[#f5d8c8] bg-white p-3.5">
                            <div class="flex items-center gap-3">
                                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#fff0e7] text-[#b96d48]">
                                    <i data-lucide="clock-3" class="h-5 w-5"></i>
                                </span>

                                <span class="text-sm font-semibold text-[#466157]">
                                    Han llegado tarde
                                </span>
                            </div>

                            <span id="late-count-{{ $classSession->id }}" class="text-xl font-extrabold tabular-nums text-[#b96d48]">
                                0
                            </span>
                        </div>

                        <div class="flex items-center justify-between gap-3 rounded-2xl border border-[#f3cdca] bg-white p-3.5">
                            <div class="flex items-center gap-3">
                                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#fff0ef] text-rose-600">
                                    <i data-lucide="user-round-x" class="h-5 w-5"></i>
                                </span>

                                <span class="text-sm font-semibold text-[#466157]">
                                    Ausentes
                                </span>
                            </div>

                            <span id="absent-count-{{ $classSession->id }}" class="text-xl font-extrabold tabular-nums text-rose-600">
                                {{ $classSession->subject->group->students->count() }}
                            </span>
                        </div>
                    </div>

                    {{-- Listado de alumnos; se conserva student-status para JavaScript --}}
                    <div class="mt-5 overflow-hidden rounded-2xl border border-[#e3eee8] bg-white">
                        <div class="flex items-center justify-between border-b border-[#edf3ef] px-4 py-3">
                            <p class="text-xs font-bold uppercase tracking-[0.13em] text-[#789287]">
                                Alumnos del grupo
                            </p>

                            <i data-lucide="users" class="h-4 w-4 text-[#168d6b]"></i>
                        </div>

                        <div class="max-h-56 space-y-1 overflow-y-auto p-3">
                            @forelse ($classSession->subject->group->students as $student)
                                <div class="flex items-center justify-between gap-3 rounded-xl px-2 py-2.5 transition hover:bg-[#f7fbf8]">
                                    <span class="min-w-0 truncate text-sm font-medium text-[#466157]">
                                        {{ $student->name }} {{ $student->surname }}
                                    </span>

                                    <span class="student-status shrink-0 rounded-full border border-[#f3cdca] bg-[#fff0ef] px-2.5 py-1 text-xs font-bold text-rose-700">
                                        Ausente
                                    </span>
                                </div>
                            @empty
                                <p class="px-2 py-4 text-sm leading-6 text-[#789287]">
                                    Este grupo no tiene alumnos.
                                </p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Acciones originales --}}
                    <div class="mt-5 space-y-3">

                        <form action="{{ route('teacher.classes.open', $classSession) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                id="start-control-{{ $classSession->id }}"
                                class="inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-2xl bg-[#168d6b] px-4 py-3.5 text-sm font-bold text-white shadow-lg shadow-emerald-900/10 transition hover:bg-[#127257] hover:shadow-md focus:outline-none focus:ring-4 focus:ring-[#b5ebd2]"
                            >
                                <i data-lucide="scan-line" class="h-4 w-4"></i>
                                Comenzar control
                            </button>
                        </form>

                        <form action="{{ route('teacher.classes.close', $classSession) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-2xl border border-[#f0ceca] bg-white px-4 py-3.5 text-sm font-bold text-rose-700 transition hover:bg-rose-50 focus:outline-none focus:ring-4 focus:ring-rose-100"
                            >
                                <i data-lucide="circle-stop" class="h-4 w-4"></i>
                                Cerrar clase
                            </button>
                        </form>

                    </div>
                </aside>
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
    function startAttendanceControl(classId) {
        const status = document.getElementById(`qr-status-${classId}`);
        const countdown = document.getElementById(`countdown-${classId}`);
        const closeButton = document.querySelector(`#start-class-modal-${classId} button[type="submit"]`);

        let remainingSeconds = 600;

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
                countdown.textContent = '00:00';
            }
        }, 1000);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const modals = document.querySelectorAll('[id^="start-class-modal-"]');
        modals.forEach((modal) => {
            if (!modal.classList.contains('hidden')) {
                const classId = modal.id.replace('start-class-modal-', '');
                startAttendanceControl(classId);
            }
        });
    });
</script>
