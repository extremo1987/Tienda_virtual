/* Variantes de producto (color, talla, medidas...) - panel de administración */
(function () {
    'use strict';
    const URL_GET = base_url + '/Productos/getVariantes/';
    const URL_SET = base_url + '/Productos/setVariantes';
    const MAX_VARIANTES = 150;
    const PRESETS = {
        ropa: [['Color', 'Negro, Blanco, Azul'], ['Talla', 'S, M, L, XL']],
        calzado: [['Talla', '36, 37, 38, 39, 40, 41, 42']],
        medidas: [['Tamaño', 'Pequeño, Mediano, Grande']],
        color: [['Color', 'Negro, Blanco, Rojo']]
    };
    const S = { id: 0, precioBase: 0, nombres: [], filas: [] };
    const $ = (id) => document.getElementById(id);
    const esc = (t) => String(t).replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    const dinero = (n) => 'L ' + Number(n).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    const etiqueta = (fila) => Object.values(fila.atributos).join(' / ');
    const claveFila = (fila) => etiqueta(fila).toLowerCase();

    // ---------- Opciones (atributos) del generador ----------
    function agregarAtributo(nombre, valores) {
        if ($('varAtributos').children.length >= 4) { swal('Atención', 'Máximo 4 opciones por producto.', 'warning'); return; }
        const d = document.createElement('div');
        d.className = 'var-attr';
        d.innerHTML = '<input class="form-control nombre" placeholder="Opción (ej. Color)" maxlength="30">' +
            '<input class="form-control valores" placeholder="Valores separados por coma (ej. Rojo, Azul, Negro)">' +
            '<button type="button" class="btn btn-outline-danger" title="Quitar esta opción"><i class="fas fa-times"></i></button>';
        d.querySelector('.nombre').value = nombre || '';
        d.querySelector('.valores').value = valores || '';
        d.querySelector('button').onclick = () => d.remove();
        $('varAtributos').appendChild(d);
    }
    function cargarAtributosDesdeFilas() {
        $('varAtributos').innerHTML = '';
        if (!S.filas.length) { PRESETS.ropa.forEach((p) => agregarAtributo(p[0], '')); return; }
        S.nombres.forEach((n) => {
            const vistos = [];
            S.filas.forEach((f) => { if (!vistos.includes(f.atributos[n])) vistos.push(f.atributos[n]); });
            agregarAtributo(n, vistos.join(', '));
        });
    }
    function leerAtributos() {
        const lista = [];
        for (const d of $('varAtributos').children) {
            const nombre = d.querySelector('.nombre').value.trim();
            const valores = [...new Set(d.querySelector('.valores').value.split(',').map((v) => v.trim()).filter(Boolean))];
            if (!nombre && !valores.length) continue;
            if (!nombre || !valores.length) return { error: 'Cada opción necesita un nombre y al menos un valor.' };
            lista.push({ nombre, valores });
        }
        if (!lista.length) return { error: 'Agrega al menos una opción (por ejemplo Color o Talla).' };
        const nombres = lista.map((a) => a.nombre.toLowerCase());
        if (new Set(nombres).size !== nombres.length) return { error: 'Los nombres de las opciones no pueden repetirse.' };
        return { lista };
    }
    function combinar(lista) {
        let res = [{}];
        lista.forEach((a) => {
            const nuevo = [];
            res.forEach((base) => a.valores.forEach((v) => nuevo.push({ ...base, [a.nombre]: v })));
            res = nuevo;
        });
        return res;
    }

    function generar() {
        const r = leerAtributos();
        if (r.error) { swal('Atención', r.error, 'warning'); return; }
        const nombres = r.lista.map((a) => a.nombre);
        const total = r.lista.reduce((t, a) => t * a.valores.length, 1);
        if (total > MAX_VARIANTES) { swal('Demasiadas combinaciones', 'Se generarían ' + total + ' y el máximo es ' + MAX_VARIANTES + '. Reduce los valores.', 'warning'); return; }
        const aplicar = () => {
            const stockIni = Math.max(0, parseInt($('varStockInicial').value, 10) || 0);
            const existentes = new Map(S.filas.map((f) => [claveFila(f), f]));
            const nuevas = combinar(r.lista).map((atributos) => {
                const base = { id: 0, atributos, codigo: '', precio: '', stock: stockIni, status: 1 };
                return existentes.get(claveFila(base)) || base; // las que ya existen conservan su stock y precio
            });
            S.nombres = nombres;
            S.filas = nuevas;
            pintar();
        };
        const cambiaron = S.filas.length && JSON.stringify(nombres) !== JSON.stringify(S.nombres);
        if (cambiaron) {
            swal({ title: 'Cambiar las opciones', text: 'Las opciones son distintas a las actuales. Se reemplazará la lista de variantes (podrás cancelar sin guardar).',
                type: 'warning', showCancelButton: true, confirmButtonText: 'Sí, reemplazar', cancelButtonText: 'Cancelar', closeOnConfirm: true },
                (ok) => { if (ok) { S.filas = []; aplicar(); } });
        } else {
            const antes = S.filas.length;
            aplicar();
            const quitadas = antes - S.filas.filter((f) => f.id > 0).length;
            if (quitadas > 0) swal('Aviso', quitadas + ' variante(s) existente(s) ya no están entre las combinaciones y se eliminarán al guardar.', 'info');
        }
    }

    // ---------- Tabla ----------
    function pintar() {
        const tb = $('varFilas');
        tb.innerHTML = '';
        S.filas.forEach((f, i) => {
            const tr = document.createElement('tr');
            if (!f.status) tr.className = 'inactiva';
            tr.innerHTML = '<td class="etiqueta"></td>' +
                '<td><input class="form-control form-control-sm" data-k="codigo" maxlength="50"></td>' +
                '<td><input type="number" min="0" step="0.01" class="form-control form-control-sm" data-k="precio" placeholder="del producto"></td>' +
                '<td><input type="number" min="0" step="1" class="form-control form-control-sm" data-k="stock"></td>' +
                '<td class="text-center"><input type="checkbox" data-k="status" style="width:18px;height:18px"></td>' +
                '<td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger" title="Quitar"><i class="far fa-trash-alt"></i></button></td>';
            tr.querySelector('.etiqueta').textContent = etiqueta(f);
            tr.querySelector('[data-k=codigo]').value = f.codigo || '';
            tr.querySelector('[data-k=precio]').value = f.precio === null ? '' : f.precio;
            tr.querySelector('[data-k=stock]').value = f.stock;
            tr.querySelector('[data-k=status]').checked = !!f.status;
            tr.querySelectorAll('[data-k]').forEach((inp) => {
                inp.addEventListener('input', () => {
                    const k = inp.dataset.k;
                    f[k] = k === 'status' ? (inp.checked ? 1 : 0) : inp.value;
                    tr.classList.toggle('inactiva', !f.status);
                    resumen();
                });
            });
            tr.querySelector('button').onclick = () => { S.filas.splice(i, 1); pintar(); };
            tb.appendChild(tr);
        });
        const hay = S.filas.length > 0;
        $('varTabla').style.display = hay ? '' : 'none';
        $('varMasivo').style.display = hay ? '' : 'none';
        $('varVacio').style.display = hay ? 'none' : '';
        resumen();
    }
    function resumen() {
        const activas = S.filas.filter((f) => f.status);
        const stock = activas.reduce((t, f) => t + (parseInt(f.stock, 10) || 0), 0);
        $('varResumen').textContent = S.filas.length + ' variante(s) · ' + activas.length + ' activa(s) · stock total: ' + stock;
    }

    // ---------- Guardar ----------
    function guardar() {
        for (const f of S.filas) {
            const st = f.stock === '' ? 0 : Number(f.stock);
            if (!Number.isInteger(st) || st < 0) { swal('Atención', 'El stock de «' + etiqueta(f) + '» debe ser un número entero, 0 o más.', 'warning'); return; }
            if (f.precio !== '' && f.precio !== null && (isNaN(Number(f.precio)) || Number(f.precio) < 0)) { swal('Atención', 'El precio de «' + etiqueta(f) + '» no es válido.', 'warning'); return; }
        }
        const datos = S.filas.map((f) => ({ id: f.id, atributos: f.atributos, codigo: f.codigo, precio: f.precio === '' ? null : f.precio, stock: f.stock === '' ? 0 : f.stock, status: f.status }));
        const go = () => {
            const fd = new FormData();
            fd.append('idproducto', S.id);
            fd.append('variantes', JSON.stringify(datos));
            $('varBtnGuardar').disabled = true;
            fetch(URL_SET, { method: 'POST', body: fd }).then((r) => r.json()).then((o) => {
                $('varBtnGuardar').disabled = false;
                if (o.status) {
                    window.jQuery('#modalVariantes').modal('hide');
                    swal('Listo', o.msg, 'success');
                    if (window.tableProductos) tableProductos.api().ajax.reload(null, false);
                } else { swal('Atención', o.msg, 'error'); }
            }).catch(() => { $('varBtnGuardar').disabled = false; swal('Error', 'No se pudo guardar. Intenta de nuevo.', 'error'); });
        };
        if (!datos.length) {
            swal({ title: 'Quitar todas las variantes', text: 'El producto quedará sin variantes y se venderá como un producto simple (con el stock actual).',
                type: 'warning', showCancelButton: true, confirmButtonText: 'Sí, guardar', cancelButtonText: 'Cancelar', closeOnConfirm: true }, (ok) => { if (ok) go(); });
        } else { go(); }
    }

    // ---------- Abrir ----------
    window.fntVariantes = function (idProducto) {
        fetch(URL_GET + idProducto).then((r) => r.json()).then((o) => {
            if (!o.status) { swal('Atención', o.msg || 'No se pudo cargar.', 'error'); return; }
            S.id = o.producto.id;
            S.precioBase = o.producto.precio;
            S.filas = o.variantes.map((v) => ({ id: Number(v.idvariante), atributos: v.atributos, codigo: v.codigo || '', precio: v.precio === null ? '' : v.precio, stock: Number(v.stock), status: Number(v.status) }));
            S.nombres = S.filas.length ? Object.keys(S.filas[0].atributos) : [];
            $('varNombreProducto').textContent = o.producto.nombre;
            $('varPrecioBase').textContent = '(vacío = ' + dinero(S.precioBase) + ')';
            $('varStockInicial').value = 0;
            cargarAtributosDesdeFilas();
            pintar();
            window.jQuery('#modalVariantes').modal('show');
        }).catch(() => swal('Error', 'No se pudo cargar las variantes.', 'error'));
    };

    const iniciar = () => {
        if (!$('modalVariantes')) return;
        $('varBtnAddAtributo').onclick = () => agregarAtributo('', '');
        $('varBtnGenerar').onclick = generar;
        $('varBtnGuardar').onclick = guardar;
        $('varBtnMasStock').onclick = () => { const v = $('varMasStock').value; if (v === '') return; S.filas.forEach((f) => { f.stock = Math.max(0, parseInt(v, 10) || 0); }); pintar(); };
        $('varBtnMasPrecio').onclick = () => { const v = $('varMasPrecio').value; S.filas.forEach((f) => { f.precio = v; }); pintar(); };
        document.querySelectorAll('[data-preset]').forEach((b) => b.addEventListener('click', () => {
            $('varAtributos').innerHTML = '';
            PRESETS[b.dataset.preset].forEach((p) => agregarAtributo(p[0], p[1]));
        }));
    };
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', iniciar); else iniciar();
})();
