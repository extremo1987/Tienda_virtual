/* Selector de variantes en la ficha del producto: elegir opciones -> precio, stock y código del carrito */
(function () {
    'use strict';
    var cont = document.getElementById('mgVariantes');
    var dataEl = document.getElementById('mgVariantesData');
    if (!cont || !dataEl) return;

    var data = JSON.parse(dataEl.textContent);
    var variantes = data.variantes;
    var nombres = data.nombres;
    var sel = {};
    var btnAdd = document.querySelector('.js-addcart-detail');
    var precioEl = document.getElementById('mgPrecio');
    var infoEl = document.getElementById('mgVarInfo');
    var cant = document.getElementById('cant-product');
    var tokenBase = btnAdd ? btnAdd.id : '';

    var COLORES = {
        negro: '#111111', blanco: '#ffffff', rojo: '#d32f2f', azul: '#1976d2', verde: '#388e3c', amarillo: '#fbc02d',
        naranja: '#f57c00', morado: '#7b1fa2', rosa: '#f48fb1', rosado: '#f48fb1', gris: '#9e9e9e', cafe: '#6d4c41',
        marron: '#6d4c41', beige: '#d7c4a3', celeste: '#4fc3f7', dorado: '#d4af37', plateado: '#bdbdbd',
        turquesa: '#26c6da', vino: '#7b1e3a', crema: '#f5f0dc', lila: '#b39ddb', fucsia: '#e91e63', caqui: '#c3b091',
        'azul marino': '#22336b', 'azul claro': '#86b7e6', 'azul oscuro': '#27486e', 'verde oscuro': '#2f5d3a', 'verde claro': '#9ad29a', 'verde menta': '#9be3c2', menta: '#9be3c2', durazno: '#f8b99a', melocoton: '#f8b99a', salmon: '#f6a08f', coral: '#ff7f6e', mostaza: '#d9a521', vino: '#7b1e3a'
    };
    // "Azul marino" -> color exacto; si no está, se usa la primera palabra ("azul")
    function colorDe(valor) { var k = sinTildes(valor); return COLORES[k] || COLORES[k.split(' ')[0]] || null; }
    function sinTildes(t) { return t.normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase().trim(); }
    function fmt(n) { return data.moneda + Number(n).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
    function precioDe(v) { return v.precio === null ? data.precioBase : v.precio; }

    // ----- ¿qué variantes cumplen la selección actual (sin contar el atributo "excluir")?
    function compatibles(excluir) {
        return variantes.filter(function (v) {
            return nombres.every(function (n) { return n === excluir || !sel[n] || v.atributos[n] === sel[n]; });
        });
    }
    function variante() {
        if (!nombres.every(function (n) { return sel[n]; })) return null;
        return variantes.filter(function (v) { return nombres.every(function (n) { return v.atributos[n] === sel[n]; }); })[0] || null;
    }

    // ----- pintar
    function pintar() {
        cont.querySelectorAll('.mg-var__grupo').forEach(function (g) {
            var n = g.dataset.attr;
            var disp = compatibles(n).filter(function (v) { return v.stock > 0; }).map(function (v) { return v.atributos[n]; });
            g.querySelector('.mg-var__sel').textContent = sel[n] || 'elige una opción';
            g.querySelectorAll('.mg-var__op').forEach(function (b) {
                var activo = sel[n] === b.dataset.valor;
                b.classList.toggle('is-sel', activo);
                b.classList.toggle('is-no', disp.indexOf(b.dataset.valor) === -1);
                b.setAttribute('aria-pressed', activo ? 'true' : 'false');
            });
            g.classList.remove('mg-var__grupo--falta');
        });
        var v = variante();
        if (btnAdd) btnAdd.id = v ? v.token : tokenBase; // sin variante elegida, el servidor pedirá elegir opciones
        if (btnAdd) { btnAdd.disabled = !!(v && v.stock <= 0); }
        if (v && v.stock <= 0) {
            if (precioEl) precioEl.textContent = fmt(precioDe(v));
            infoEl.className = 'mg-var__info es-agotado';
            infoEl.textContent = 'Esta combinación está agotada. Prueba con otro color o talla.';
            if (cant) cant.removeAttribute('max');
        } else if (v) {
            if (precioEl) precioEl.textContent = fmt(precioDe(v));
            var poco = v.stock <= 5;
            infoEl.className = 'mg-var__info ' + (poco ? 'es-poco' : 'es-ok');
            infoEl.textContent = poco ? '¡Solo ' + (v.stock === 1 ? 'queda 1 unidad' : 'quedan ' + v.stock + ' unidades') + '!' : 'Disponible: ' + v.stock + ' unidades';
            if (cant) { cant.max = v.stock; if (Number(cant.value) > v.stock) cant.value = v.stock; }
        } else {
            var precios = variantes.filter(function (x) { return x.stock > 0; }).map(precioDe);
            if (!precios.length) precios = variantes.map(precioDe);
            var min = Math.min.apply(null, precios), max = Math.max.apply(null, precios);
            if (precioEl) precioEl.textContent = (min !== max ? 'Desde ' : '') + fmt(min);
            infoEl.className = 'mg-var__info';
            infoEl.textContent = 'Elige tus opciones para ver la disponibilidad.';
            if (cant) cant.removeAttribute('max');
        }
    }

    // ----- elegir una opción
    function elegir(n, valor) {
        sel[n] = sel[n] === valor ? undefined : valor; // pulsar otra vez la quita
        if (!sel[n]) delete sel[n];
        // si la nueva elección deja sin combinación a otra opción ya elegida, esa se limpia
        nombres.forEach(function (otro) {
            if (otro !== n && sel[otro] && !variantes.some(function (v) { return v.atributos[n] === sel[n] && v.atributos[otro] === sel[otro]; })) {
                if (sel[n]) delete sel[otro];
            }
        });
        pintar();
    }
    cont.addEventListener('click', function (e) {
        var b = e.target.closest('.mg-var__op');
        if (b) elegir(b.closest('.mg-var__grupo').dataset.attr, b.dataset.valor);
    });

    // ----- construir los botones (color con puntito)
    cont.querySelectorAll('.mg-var__grupo').forEach(function (g) {
        var esColor = /colou?r/i.test(g.dataset.attr);
        g.querySelectorAll('.mg-var__op').forEach(function (b) {
            var texto = b.textContent;
            b.textContent = '';
            if (esColor && colorDe(b.dataset.valor)) {
                var dot = document.createElement('span');
                dot.className = 'mg-var__dot';
                dot.style.background = colorDe(b.dataset.valor);
                b.appendChild(dot);
            }
            b.appendChild(document.createTextNode(texto));
        });
    });

    // ----- si falta elegir algo, resaltar y llevar la vista hasta las opciones
    if (btnAdd) {
        btnAdd.addEventListener('click', function () {
            if (variante()) return;
            var falta = null;
            cont.querySelectorAll('.mg-var__grupo').forEach(function (g) {
                if (!sel[g.dataset.attr]) { g.classList.remove('mg-var__grupo--falta'); void g.offsetWidth; g.classList.add('mg-var__grupo--falta'); falta = falta || g; }
            });
            if (falta && falta.scrollIntoView) falta.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    }

    // ----- selección automática cuando no hay nada que decidir
    nombres.forEach(function (n) {
        var unicos = variantes.map(function (v) { return v.atributos[n]; }).filter(function (x, i, a) { return a.indexOf(x) === i; });
        if (unicos.length === 1) sel[n] = unicos[0];
    });
    pintar();
})();
