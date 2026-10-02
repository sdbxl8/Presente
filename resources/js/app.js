import QRCode from 'qrcode';

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
