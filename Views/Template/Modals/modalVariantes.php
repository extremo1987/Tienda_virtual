<!-- Modal: variantes de un producto (color, talla, medidas...) -->
<div class="modal fade" id="modalVariantes" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header headerUpdate">
        <h5 class="modal-title"><i class="fas fa-layer-group"></i> Variantes de: <span id="varNombreProducto"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <p class="text-muted mb-3">
          Una variante es una versión del producto: <b>color, talla, medidas</b>… Cada una tiene su propio <b>stock</b> y, si quieres, su propio <b>precio</b>.
          El cliente elegirá sus opciones en la ficha del producto.
        </p>

        <div class="var-box">
          <h6 class="var-step"><span>1</span> Define las opciones y genera las combinaciones</h6>
          <div class="mb-2">
            <small class="text-muted mr-1">Ejemplos rápidos:</small>
            <button type="button" class="btn btn-sm btn-outline-secondary" data-preset="ropa">Ropa (Color + Talla)</button>
            <button type="button" class="btn btn-sm btn-outline-secondary" data-preset="calzado">Calzado (Talla)</button>
            <button type="button" class="btn btn-sm btn-outline-secondary" data-preset="medidas">Medidas (Tamaño)</button>
            <button type="button" class="btn btn-sm btn-outline-secondary" data-preset="color">Solo color</button>
          </div>
          <div id="varAtributos"></div>
          <div class="form-row align-items-end mt-2">
            <div class="col-auto">
              <button type="button" class="btn btn-sm btn-light border" id="varBtnAddAtributo"><i class="fas fa-plus"></i> Agregar otra opción</button>
            </div>
            <div class="col-auto ml-auto">
              <label class="mb-0 small text-muted">Stock inicial de cada nueva</label>
              <input type="number" min="0" class="form-control form-control-sm" id="varStockInicial" value="0" style="width:110px">
            </div>
            <div class="col-auto">
              <button type="button" class="btn btn-primary" id="varBtnGenerar"><i class="fas fa-magic"></i> Generar combinaciones</button>
            </div>
          </div>
        </div>

        <div class="var-box mt-3">
          <h6 class="var-step"><span>2</span> Ajusta el stock y el precio de cada una</h6>
          <div class="form-row align-items-end mb-2" id="varMasivo">
            <div class="col-auto">
              <label class="mb-0 small text-muted">Stock para todas</label>
              <input type="number" min="0" class="form-control form-control-sm" id="varMasStock" style="width:100px">
            </div>
            <div class="col-auto">
              <button type="button" class="btn btn-sm btn-light border" id="varBtnMasStock">Aplicar</button>
            </div>
            <div class="col-auto ml-3">
              <label class="mb-0 small text-muted">Precio para todas (vacío = el del producto)</label>
              <input type="number" min="0" step="0.01" class="form-control form-control-sm" id="varMasPrecio" style="width:130px">
            </div>
            <div class="col-auto">
              <button type="button" class="btn btn-sm btn-light border" id="varBtnMasPrecio">Aplicar</button>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-sm table-hover mb-0" id="varTabla">
              <thead>
                <tr><th>Variante</th><th style="width:150px">Código (opcional)</th><th style="width:150px">Precio <span class="text-muted font-weight-normal" id="varPrecioBase"></span></th><th style="width:110px">Stock</th><th style="width:80px" class="text-center">Activa</th><th style="width:50px"></th></tr>
              </thead>
              <tbody id="varFilas"></tbody>
            </table>
          </div>
          <div id="varVacio" class="text-center text-muted py-4">
            Este producto todavía no tiene variantes. Define las opciones arriba y pulsa <b>Generar combinaciones</b>.
          </div>
          <div class="d-flex justify-content-between mt-2 small text-muted">
            <span id="varResumen"></span>
            <span>Si el producto tiene variantes, su stock es la suma de las variantes activas.</span>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="varBtnGuardar"><i class="fas fa-save"></i> Guardar variantes</button>
      </div>
    </div>
  </div>
</div>
<style>
  .var-box{border:1px solid #e3e6ea;border-radius:8px;padding:14px 16px;background:#fafbfc}
  .var-step{font-weight:600;margin-bottom:12px}
  .var-step span{display:inline-block;width:22px;height:22px;line-height:22px;text-align:center;border-radius:50%;background:#007bff;color:#fff;font-size:12px;margin-right:6px}
  .var-attr{display:flex;gap:8px;margin-bottom:8px}
  .var-attr .nombre{width:200px;flex:none}
  .var-attr .valores{flex:1}
  #varFilas td{vertical-align:middle}
  #varFilas .etiqueta{font-weight:600}
  #varFilas tr.inactiva{opacity:.55}
</style>
