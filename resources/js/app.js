import QRCode from 'qrcode';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';

document.querySelectorAll('canvas[data-qr-url]').forEach(async (canvas) => {
    const url = canvas.dataset.qrUrl;

    if (!url) {
        return;
    }

    try {
        await QRCode.toCanvas(canvas, url, {
            width: 240,
            margin: 2,
        });
    } catch (error) {
        console.error('No se pudo generar el QR', error);
    }
});


document.addEventListener('DOMContentLoaded', () => {
    const calendarEl = document.getElementById('teacher-calendar');
    const modal = document.getElementById('calendar-modal');
    const openButton = document.getElementById('open-calendar');

    if (!calendarEl) {
        return;
    }

    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin],
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev',
            center: 'title',
            right: 'next'
        },
        locale: 'es',
        height: 'auto',
        contentHeight: 360,
        fixedWeekCount: false,
        events: '/api/classes',
        eventClick(info) {
            console.log(info.event.extendedProps);
        }
    });

    openButton?.addEventListener('click', () => {
        modal?.classList.remove('hidden');
        requestAnimationFrame(() => calendar.updateSize());
    });

    calendar.render();
});
