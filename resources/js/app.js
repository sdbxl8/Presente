import QRCode from 'qrcode';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import { Html5Qrcode, Html5QrcodeSupportedFormats } from 'html5-qrcode';

// Generación de QR
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

// escaner qrhtml5
document.addEventListener('DOMContentLoaded', () => {
    const scannerPage = document.querySelector('[data-student-qr-scanner]');

    if (!scannerPage) {
        return;
    }

    const startButton = document.getElementById('student-scan-start');
    const stopButton = document.getElementById('student-scan-stop');
    const statusElement = document.getElementById('student-scan-status');
    const attendanceForm = document.getElementById('student-attendance-submit');
    const scanner = new Html5Qrcode('student-qr-reader', {
        formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE],
        verbose: false,
    });
    let scanHandled = false;

    const stopScanner = async () => {
        if (scanner.isScanning) {
            await scanner.stop();
        }

        startButton.hidden = false;
        stopButton.hidden = true;
    };

    startButton.addEventListener('click', async () => {
        startButton.disabled = true;
        statusElement.textContent = 'Solicitando acceso a la cámara…';

        try {
            await scanner.start(
                { facingMode: 'environment' },
                {
                    fps: 10,
                    qrbox: (viewfinderWidth, viewfinderHeight) => {
                        const size = Math.floor(Math.min(viewfinderWidth, viewfinderHeight) * 0.72);
                        return { width: size, height: size };
                    },
                },
                async (decodedText) => {
                    if (scanHandled) {
                        return;
                    }

                    let attendanceUrl;

                    try {
                        attendanceUrl = new URL(decodedText, window.location.origin);
                    } catch {
                        statusElement.textContent = 'El código leído no contiene una URL válida.';
                        return;
                    }

                    const isAttendanceUrl = attendanceUrl.origin === window.location.origin
                        && /^\/attendance\/\d+$/.test(attendanceUrl.pathname)
                        && attendanceUrl.searchParams.has('signature')
                        && attendanceUrl.searchParams.has('expires');

                    if (!isAttendanceUrl) {
                        statusElement.textContent = 'Este código no es un enlace válido de asistencia.';
                        return;
                    }

                    scanHandled = true;
                    statusElement.textContent = 'Código válido. Registrando asistencia…';

                    try {
                        await stopScanner();
                    } catch (error) {
                        console.warn('No se pudo detener la cámara antes de enviar', error);
                    }

                    attendanceForm.action = attendanceUrl.href;
                    attendanceForm.submit();
                },
                () => {}
            );

            startButton.hidden = true;
            startButton.disabled = false;
            stopButton.hidden = false;
            statusElement.textContent = 'Cámara activa. Centra el código QR dentro del marco.';
        } catch (error) {
            startButton.disabled = false;
            statusElement.textContent = 'No se pudo iniciar la cámara. Comprueba los permisos del navegador y vuelve a intentarlo.';
            console.error('Error al iniciar el lector QR', error);
        }
    });

    stopButton.addEventListener('click', async () => {
        try {
            await stopScanner();
            statusElement.textContent = 'Escaneo detenido.';
        } catch (error) {
            statusElement.textContent = 'No se pudo detener la cámara.';
            console.error('Error al detener el lector QR', error);
        }
    });
});

// calendario

document.addEventListener('DOMContentLoaded', () => {
    const calendarEl = document.getElementById('teacher-calendar');
    const modal = document.getElementById('calendar-modal');
    const openButton = document.getElementById('open-calendar');
    const dateElement = document.getElementById('current-date');
    const timeElement = document.getElementById('current-time');

    const updateDateTime = () => {
        const now = new Date();

        if (dateElement) {
            dateElement.textContent = now.toLocaleDateString('es-ES', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }

        if (timeElement) {
            timeElement.textContent = now.toLocaleTimeString('es-ES', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });
        }


    };

    updateDateTime();
    setInterval(updateDateTime, 1000);

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


