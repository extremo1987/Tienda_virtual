<?php 
	class PedidosModel extends Mysql
	{
		private $objCategoria;
		public function __construct()
		{
			parent::__construct();
		}

public function selectPedidos($idpersona = null){
    $where = "";
    if($idpersona != null){
        $where = " WHERE p.personaid = ".(int)$idpersona;
    }
    $sql = "SELECT p.idpedido,
                    p.referenciacobro,
                    CONCAT(pe.nombres, ' ', pe.apellidos) as cliente,  -- Concatenamos nombres y apellidos
                    p.direccion_envio as direccion,
                    p.idtransaccionpaypal,
                    DATE_FORMAT(p.fecha, '%d/%m/%Y') as fecha,
                    p.monto,
                    tp.tipopago,
                    tp.idtipopago,
                    p.status 
            FROM pedido p 
            INNER JOIN tipopago tp ON p.tipopagoid = tp.idtipopago
            INNER JOIN persona pe ON p.personaid = pe.idpersona $where ";
    $request = $this->select_all($sql);
    return escaparFilas($request);
}
	

		public function selectPedido(int $idpedido, $idpersona = NULL){
			$busqueda = "";
			if($idpersona != NULL){
				$busqueda = " AND p.personaid =".(int)$idpersona;
			}
			$request = array();
			$sql = "SELECT p.idpedido,
							p.referenciacobro,
							p.idtransaccionpaypal,
							p.personaid,
							DATE_FORMAT(p.fecha, '%d/%m/%Y') as fecha,
							p.costo_envio,
							p.monto,
							p.tipopagoid,
							t.tipopago,
							p.direccion_envio,
							p.status
					FROM pedido as p
					INNER JOIN tipopago t
					ON p.tipopagoid = t.idtipopago
					WHERE p.idpedido =  $idpedido ".$busqueda;
			$requestPedido = $this->select($sql);
			if(!empty($requestPedido)){
				$idpersona = $requestPedido['personaid'];
				$sql_cliente = "SELECT idpersona,
										nombres,
										apellidos,
										telefono,
										email_user,
										nit,
										nombrefiscal,
										direccionfiscal 
								FROM persona WHERE idpersona = $idpersona ";
				$requestcliente = $this->select($sql_cliente);
				$sql_detalle = "SELECT p.idproducto,
											p.nombre as producto,
											d.precio, d.variante, d.cantidad
									FROM detalle_pedido d
									INNER JOIN producto p
									ON d.productoid = p.idproducto
									WHERE d.pedidoid = $idpedido";
				$requestProductos = $this->select_all($sql_detalle);
				$request = array('cliente' => $requestcliente,
								'orden' => $requestPedido,
								'detalle' => $requestProductos
								 );
			}
			return $request;
		}

		public function selectTransPaypal(string $idtransaccion, $idpersona = NULL){
			$busqueda = "";
			if($idpersona != NULL){
				$busqueda = " AND personaid =".(int)$idpersona;
			}
			$objTransaccion = array();
			$sql = "SELECT datospaypal FROM pedido WHERE idtransaccionpaypal = ? ".$busqueda; $requestData = $this->select($sql, [$idtransaccion]);
			if(!empty($requestData)){
				$objData = json_decode($requestData['datospaypal']);
				//$urlOrden = $objData->purchase_units[0]->payments->captures[0]->links[2]->href;
				$urlOrden = $objData->links[0]->href;
				$objTransaccion = CurlConnectionGet($urlOrden,"application/json",getTokenPaypal());
			}
			return $objTransaccion;
		}

		public function reembolsoPaypal(string $idtransaccion, string $observacion){
			$response = false;
			$sql = "SELECT idpedido,datospaypal FROM pedido WHERE idtransaccionpaypal = ? "; $requestData = $this->select($sql, [$idtransaccion]);
			if(!empty($requestData)){
				$objData = json_decode($requestData['datospaypal']);
				$urlReembolso = $objData->purchase_units[0]->payments->captures[0]->links[1]->href;
				$objTransaccion = CurlConnectionPost($urlReembolso,"application/json",getTokenPaypal());
				if(isset($objTransaccion->status) and  $objTransaccion->status == "COMPLETED"){
					$idpedido = $requestData['idpedido'];
					$idtrasaccion = $objTransaccion->id;
					$status = $objTransaccion->status;
					$jsonData = json_encode($objTransaccion);
					$observacion = $observacion;
					$query_insert  = "INSERT INTO reembolso(pedidoid,
														idtransaccion,
														datosreembolso,
														observacion,
														status) 
								  	VALUES(?,?,?,?,?)";
					$arrData = array($idpedido,
	        						$idtrasaccion,
	        						$jsonData,
	        						$observacion,
	        						$status
	        					);
					$request_insert = $this->insert($query_insert,$arrData);
					if($request_insert > 0){
	        			$updatePedido  = "UPDATE pedido SET status = ? WHERE idpedido = $idpedido";
			        	$arrPedido = array("Reembolsado");
			        	$request = $this->update($updatePedido,$arrPedido);
			        	$response = true;
	        		}
				}
				return $response;
			}
		}

		public function updatePedido(int $idpedido, $transaccion, $idtipopago, string $estado){
			if($transaccion == NULL){
				$query_insert  = "UPDATE pedido SET status = ?  WHERE idpedido = $idpedido ";
	        	$arrData = array($estado);
			}else{
				$query_insert  = "UPDATE pedido SET referenciacobro = ?, tipopagoid = ?,status = ? WHERE idpedido = $idpedido";
	        	$arrData = array($transaccion,
	        					$idtipopago,
	    						$estado
	    					);
			}
			$request_insert = $this->update($query_insert,$arrData);
        	return $request_insert;
		}
	}
 ?>