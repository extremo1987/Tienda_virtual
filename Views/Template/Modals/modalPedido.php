<!-- Modal -->
<div class="modal fade" id="modalFormPedido" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header headerUpdate">
        <h5 class="modal-title" id="titleModal">Actualizar Pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formUpdatePedido" name="formUpdatePedido" class="form-horizontal">
              <input type="hidden" id="idpedido" name="idpedido" value="<?= escapar($data['orden']['idpedido']) ?>" required="">
              <table class="table table-bordered">
                  <tbody>
                      <tr>
                          <td width="210">No. Pedido</td>
                          <td><?= escapar($data['orden']['idpedido']) ?></td>
                      </tr>
                      <tr>
                          <td>Cliente:</td>
                          <td><?= escapar($data['cliente']['nombres'].' '.$data['cliente']['apellidos']) ?></td>
                      </tr>
                      <tr>
                          <td>Importe total:</td>
                          <td><?= escapar(SMONEY).' '.$data['orden']['monto'] ?></td>
                      </tr>
                      <tr>
                          <td>Transacción:</td>
                          <td>
                            <?php 
                                if($data['orden']['tipopagoid'] == 1){
                                    echo $data['orden']['idtransaccionpaypal'];
                                }else{
                            ?>
                            <input type="text" name="txtTransaccion" id="txtTransaccion" class="form-control" value="<?= escapar($data['orden']['referenciacobro']) ?>" required="">
                                <?php } ?>
                          </td>
                      </tr>
                      <tr>
                          <td>Tipo pago:</td>
                          <td>
                            <?php 
                                if($data['orden']['tipopagoid'] == 1){
                                    echo $data['orden']['tipopago'];
                                }else{
                            ?>
                              <select name="listTipopago" id="listTipopago" class="form-control selectpicker" data-live-search="true" required="">
                                  <?php 
                                    for ($i=0; $i < count($data['tipospago']) ; $i++) {
                                        $selected = "";
                                        if( $data['tipospago'][$i]['idtipopago'] == $data['orden']['tipopagoid']){
                                            $selected = " selected ";
                                        }
                                   ?>
                                    <option value="<?= escapar($data['tipospago'][$i]['idtipopago']) ?>" <?= $selected ?> ><?= escapar($data['tipospago'][$i]['tipopago']) ?></option>
                                <?php } ?>
                              </select>
                          <?php } ?>
                          </td>
                      </tr>
                      <tr>
                          <td>Estado:</td>
                          <td>
                              <select name="listEstado" id="listEstado" class="form-control selectpicker" data-live-search="true" required="">
                                  <?php 
                                    for ($i=0; $i < count(STATUS) ; $i++) {
                                        $selected = "";
                                        if( STATUS[$i] == $data['orden']['status']){
                                            $selected = " selected ";
                                        }
                                   ?>
                                   <option value="<?= escapar(STATUS[$i]) ?>" <?= $selected ?> ><?= escapar(STATUS[$i]) ?></option>
                               <?php } ?>
                              </select>
                          </td>
                      </tr>
                  </tbody>
              </table>
              <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-info" type="submit" ><i class="fa fa-fw fa-lg fa-check-circle"></i><span>Actualizar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
            </div>
              
            </form>
      </div>
    </div>
  </div>
</div>