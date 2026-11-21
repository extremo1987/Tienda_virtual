/* Módulo Configuración del panel */
(function () {
    'use strict';
    var form = document.getElementById('formConfig');
    if (!form) return;
    var estado = document.getElementById('cfgEstado');
    var btn = document.getElementById('btnGuardarConfig');

    function limpiarErrores() {
        form.querySelectorAll('.cfg-error').forEach(function (e) { e.textContent = ''; e.classList.remove('visible'); });
        form.querySelectorAll('.is-invalid').forEach(function (e) { e.classList.remove('is-invalid'); });
    }
    function marcarErrores(errores) {
        var primero = null;
        Object.keys(errores).forEach(function (k) {
            var caja = form.querySelector('[data-error-de="' + k + '"]');
            var campo = document.getElementById('aj_' + k);
            if (campo && campo.classList) campo.classList.add('is-invalid');
            if (caja) { caja.textContent = errores[k]; caja.classList.add('visible'); }
            if (!primero && (campo || caja)) primero = campo || caja;
        });
        if (primero && primero.scrollIntoView) primero.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        limpiarErrores();
        btn.disabled = true; estado.textContent = 'Guardando…';
        fetch(base_url + '/Configuracion/guardar', { method: 'POST', body: new FormData(form) })
            .then(function (r) { return r.json(); })
            .then(function (o) {
                btn.disabled = false; estado.textContent = '';
                if (o.status) {
                    swal('Listo', o.msg, 'success');
                    form.querySelectorAll('input[type=password]').forEach(function (i) { if (i.value) { i.value = ''; i.placeholder = '•••••••• (déjalo vacío para no cambiarlo)'; } });
                } else {
                    if (o.errores) marcarErrores(o.errores);
                    swal('Atención', (o.errores && o.errores._) || o.msg, 'error');
                }
            })
            .catch(function () { btn.disabled = false; estado.textContent = ''; swal('Error', 'No se pudo guardar. Intenta de nuevo.', 'error'); });
    });

    var probar = document.getElementById('btnProbarCorreo');
    if (probar) probar.addEventListener('click', function () {
        var destino = document.getElementById('destinoPrueba').value.trim();
        if (!destino) { swal('Atención', 'Escribe el correo donde quieres recibir la prueba.', 'warning'); return; }
        probar.disabled = true; probar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando…';
        var fd = new FormData(); fd.append('destino', destino);
        fetch(base_url + '/Configuracion/probarCorreo', { method: 'POST', body: fd })
            .then(function (r) { return r.json(); })
            .then(function (o) { swal(o.status ? 'Listo' : 'No se pudo', o.msg, o.status ? 'success' : 'error'); })
            .catch(function () { swal('Error', 'No se pudo hacer la prueba. Intenta de nuevo.', 'error'); })
            .then(function () { probar.disabled = false; probar.innerHTML = '<i class="fas fa-paper-plane"></i> Enviar prueba'; });
    });
})();
