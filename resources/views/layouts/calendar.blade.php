<button type="button" id="open-calendar" class="flex w-full items-center justify-between gap-4 rounded-2xl border border-slate-200 bg-white px-4 py-4 text-left shadow-sm transition hover:border-sky-200 hover:bg-sky-50/40 focus:outline-none focus:ring-4 focus:ring-sky-100 sm:px-5">
	<span class="flex min-w-0 items-center gap-3">
		<span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sm font-bold text-sky-700">C</span>
		<span class="min-w-0">
			<span class="block text-xs font-semibold uppercase tracking-[0.16em] text-sky-700">Agenda</span>
			<span class="mt-1 block truncate text-base font-semibold text-slate-900">Calendario de clases</span>
		</span>
	</span>
	<span class="shrink-0 text-xl text-slate-400" aria-hidden="true">&rsaquo;</span>
</button>

<div id="calendar-modal" class="fixed inset-0 z-50 hidden overflow-y-auto px-4 py-8 sm:px-6" role="dialog" aria-modal="true" aria-labelledby="calendar-title">
	<div class="fixed inset-0 bg-slate-950/40" onclick="document.getElementById('calendar-modal').classList.add('hidden')"></div>

	<div class="relative mx-auto flex min-h-full max-w-5xl items-center justify-center">
		<section class="w-full overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-slate-200">
			<div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
				<div>
					<p class="text-xs font-semibold uppercase tracking-[0.16em] text-sky-700">Agenda</p>
					<h2 id="calendar-title" class="mt-1 text-xl font-bold text-slate-900">Calendario de clases</h2>
				</div>

				<button type="button" onclick="document.getElementById('calendar-modal').classList.add('hidden')" class="absolute right-4 top-4 inline-flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 text-lg text-slate-500 transition hover:bg-slate-200 hover:text-slate-800 sm:right-6" aria-label="Cerrar calendario">
					&times;
				</button>
			</div>

			<div class="p-3 sm:p-6">
				<div id="teacher-calendar" class="min-h-125 w-full min-w-0 md:min-h-140"></div>
			</div>
		</section>
	</div>
</div>
