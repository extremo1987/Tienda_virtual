/* Toque fiable dentro de los carruseles (slick) en el celular.
   El carrusel se queda con el toque para decidir si el dedo "desliza" o "toca"; por eso a veces el enlace de la foto
   (ampliar en la ficha, abrir un producto en "Relacionados") no reaccionaba. Aquí un toque corto, sin desplazamiento,
   se convierte en un clic directo sobre el enlace; un deslizamiento sigue cambiando de foto como siempre. */
(function () {
    'use strict';
    var MAX_MOVIMIENTO = 10;   // px que puede moverse el dedo y seguir contando como "toque"
    var MAX_DURACION = 600;    // ms
    var inicio = null;

    function enlaceDe(el) {
        var a = el.closest ? el.closest('a[href]') : null;
        if (!a || !a.closest('.slick-slide')) return null;
        return a;
    }
    document.addEventListener('touchstart', function (e) {
        if (e.touches.length !== 1 || !enlaceDe(e.target)) { inicio = null; return; }
        var t = e.touches[0];
        inicio = { x: t.clientX, y: t.clientY, t: Date.now(), a: enlaceDe(e.target) };
    }, { passive: true });
    document.addEventListener('touchend', function (e) {
        if (!inicio) return;
        var t = e.changedTouches[0], a = inicio.a, ini = inicio;
        inicio = null;
        var corto = Math.abs(t.clientX - ini.x) < MAX_MOVIMIENTO && Math.abs(t.clientY - ini.y) < MAX_MOVIMIENTO && (Date.now() - ini.t) < MAX_DURACION;
        if (!corto || a.getAttribute('href') === '#' && !a.classList.contains('js-addcart-detail')) return;
        e.preventDefault();       // evita que el navegador genere además su propio clic (se abriría dos veces)
        a.click();
    }, { passive: false });
})();
