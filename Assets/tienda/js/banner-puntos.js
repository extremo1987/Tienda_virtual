/* Puntos de navegación del banner principal (slick). Se construyen solos: uno por imagen. */
(function () {
    'use strict';
    function iniciar() {
        if (!window.jQuery) return;
        var $ = window.jQuery;
        $('.wrap-slick1').each(function () {
            var $wrap = $(this), $s = $wrap.find('.slick1');
            if (!$s.length || !$s.hasClass('slick-initialized') || $wrap.find('.mg-banner-puntos').length) return;
            var total = $s.slick('getSlick').slideCount;
            if (total < 2) return;
            var $puntos = $('<div class="mg-banner-puntos" role="tablist" aria-label="Imágenes del banner"></div>');
            for (var i = 0; i < total; i++) {
                $('<button type="button" role="tab" aria-label="Imagen ' + (i + 1) + ' de ' + total + '"></button>').data('i', i).appendTo($puntos);
            }
            function marcar(n) { $puntos.children().removeClass('activo').eq(n).addClass('activo'); }
            $puntos.on('click', 'button', function () { $s.slick('slickGoTo', $(this).data('i')); });
            $s.on('beforeChange', function (e, slick, actual, siguiente) { marcar(siguiente); });
            $wrap.append($puntos);
            marcar($s.slick('slickCurrentSlide'));
        });
    }
    if (document.readyState === 'complete') setTimeout(iniciar, 50); else window.addEventListener('load', function () { setTimeout(iniciar, 50); });
})();
