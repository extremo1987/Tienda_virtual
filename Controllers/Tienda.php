<?php 
	require_once("Models/TCategoria.php");
	require_once("Models/TProducto.php");
	require_once("Models/TCliente.php");
	require_once("Models/LoginModel.php");

class Tienda extends Controllers{
    use TCategoria, TProducto, TCliente;
    public $login;
    public function __construct()
    {
        parent::__construct();
        startSecureSession();
        $this->login = new LoginModel();
    }

    public function tienda()
    {
        $data['page_tag'] = NOMBRE_EMPESA;
        $data['page_title'] = NOMBRE_EMPESA;
        $data['page_name'] = "tienda";
        //$data['productos'] = $this->getProductosT();
        $pagina = 1;
        $cantProductos = $this->cantProductos();
        $total_registro = $cantProductos['total_registro'];
        $desde = ($pagina-1) * PROPORPAGINA;
        $total_paginas = ceil($total_registro / PROPORPAGINA);
        $data['productos'] = $this->getProductosPage($desde,PROPORPAGINA);
        //dep($data['productos']);exit;
        $data['pagina'] = $pagina;
        $data['total_paginas'] = $total_paginas;
        $data['categorias'] = $this->getCategorias();
        $this->views->getView($this,"tienda",$data);
    }

    public function categoria($params){
        if(empty($params)){
            header("Location:".base_url());
        } else {
            $arrParams = explode(",",$params);
            $idcategoria = intval($arrParams[0]);
            $ruta = strClean($arrParams[1] ?? ''); $pagina = 1; if(isset($arrParams[2]) && is_numeric($arrParams[2])){ $pagina = max(1, intval($arrParams[2])); }

            $cantProductos = $this->cantProductos($idcategoria);
            $total_registro = $cantProductos['total_registro'];
            $desde = ($pagina-1) * PROCATEGORIA;
            $total_paginas = ceil($total_registro / PROCATEGORIA);
            $infoCategoria = $this->getProductosCategoriaT($idcategoria,$ruta,$desde,PROCATEGORIA);
            if(empty($infoCategoria) || !isset($infoCategoria['productos'])){ require_once("Controllers/Error.php"); return; } // categoría inexistente o ruta que no coincide
            $categoria = strClean($params);
            $data['page_tag'] = NOMBRE_EMPESA." - ".$infoCategoria['categoria'];
            $data['page_title'] = $infoCategoria['categoria'];
            $data['page_name'] = "categoria";
            $data['productos'] = $infoCategoria['productos'];
            $data['infoCategoria'] = $infoCategoria;
            $data['pagina'] = $pagina;
            $data['total_paginas'] = $total_paginas;
            $data['categorias'] = $this->getCategorias();
            $this->views->getView($this,"categoria",$data);
        }
    }

		

// public function producto($params){
//    if(empty($params)){
     //   header("Location:".base_url());
   //  }else{
    //    $arrParams = explode(",",$params);
      //  $idproducto = intval($arrParams[0]);
     //   $ruta = strClean($arrParams[1] ?? "");
    //    $infoProducto = $this->getProductoT($idproducto,$ruta);
  //      
//        if(empty($infoProducto)){
      //      header("Location:".base_url());
    //     }

      //  $categoriaId = isset($infoProducto['categoriaid']) ? intval($infoProducto['categoriaid']) : 0;
        
    //    $data['page_tag'] = NOMBRE_EMPESA." - ".$infoProducto['nombre'];
      //  $data['page_title'] = $infoProducto['nombre'];
    //     $data['page_name'] = "producto";
      //  $data['producto'] = $infoProducto;
    //
      //  $data['productos'] = $this->getProductosRandom($categoriaId, 8, "r");
        //
    //    $this->views->getView($this,"producto",$data);
  //  }
//}

public function producto($params){
    if(empty($params)){
        header("Location:".base_url());
    } else {
        $arrParams = explode(",", $params);
        $idproducto = intval($arrParams[0]);
        $ruta = strClean($arrParams[1] ?? "");
        $infoProducto = $this->getProductoT($idproducto, $ruta);
        
        if(empty($infoProducto)){
            header("Location:".base_url());
        } else {
            $data['page_tag'] = NOMBRE_EMPESA . " - " . $infoProducto['nombre'];
            $data['page_title'] = $infoProducto['nombre'];
            $data['page_name'] = "producto";
            $data['producto'] = $infoProducto;

            $categoriaId = isset($infoProducto['categoriaid']) ? intval($infoProducto['categoriaid']) : 0;
            $data['productos'] = $this->getProductosRandom($categoriaId, 8, "r");

            $data['variantes'] = $this->getVariantesT((int)$infoProducto['idproducto']);
            $this->views->getView($this, "producto", $data);
        }
    }
}




		public function addCarrito(){
			if($_POST){
				$responder = function($status, $msg, $extra = array()){
					echo json_encode(array_merge(array("status" => $status, "msg" => $msg), $extra), JSON_UNESCAPED_UNICODE); die();
				};
				list($idproducto, $idvariante) = decodeItem($_POST['id'] ?? '');
				$cantidad = intval($_POST['cant'] ?? 0);
				if($idproducto <= 0 || $cantidad < 1 || $cantidad > 99){ $responder(false, 'Dato incorrecto.'); }
				$arrInfoProducto = $this->getProductoIDT($idproducto);
				if(empty($arrInfoProducto)){ $responder(false, 'Producto no existente.'); }
				$stockMax = max(1, (int)$arrInfoProducto['stock']);
				$precio = $arrInfoProducto['precio'];
				$etiqueta = '';
				if($this->tieneVariantesT($idproducto) && $idvariante <= 0){
					$responder(false, 'Elige las opciones del producto (color, talla…) antes de agregarlo.');
				}
				if($idvariante > 0){
					$variante = $this->getVarianteT($idvariante, $idproducto);
					if(empty($variante) || (int)$variante['stock'] < 1){ $responder(false, 'Esa opción ya no está disponible.'); }
					$stockMax = (int)$variante['stock'];
					$etiqueta = $variante['etiqueta'];
					if($variante['precio'] !== null){ $precio = $variante['precio']; }
				}
				$cantidad = min($cantidad, $stockMax);
				$arrProducto = array('idproducto' => $idproducto,
									'idvariante' => $idvariante,
									'variante' => $etiqueta,
									'producto' => $arrInfoProducto['nombre'],
									'cantidad' => $cantidad,
									'precio' => $precio,
									'imagen' => $arrInfoProducto['images'][0]['url_image']
								);
				$arrCarrito = isset($_SESSION['arrCarrito']) ? $_SESSION['arrCarrito'] : array();
				$nuevo = true;
				for ($pr=0; $pr < count($arrCarrito); $pr++) {
					if($arrCarrito[$pr]['idproducto'] == $idproducto && (int)($arrCarrito[$pr]['idvariante'] ?? 0) === $idvariante){
						$arrCarrito[$pr]['cantidad'] = min($arrCarrito[$pr]['cantidad'] + $cantidad, $stockMax);
						$nuevo = false;
					}
				}
				if($nuevo){ array_push($arrCarrito, $arrProducto); }
				$_SESSION['arrCarrito'] = $arrCarrito;
				$cantCarrito = 0;
				foreach ($_SESSION['arrCarrito'] as $pro) { $cantCarrito += $pro['cantidad']; }
				$responder(true, '¡Se agrego al carrito!', array("cantCarrito" => $cantCarrito,
					"htmlCarrito" => getFile('Template/Modals/modalCarrito', $_SESSION['arrCarrito'])));
			}
			die();
		}
		public function delCarrito(){
			if($_POST){
				list($idproducto, $idvariante) = decodeItem($_POST['id'] ?? '');
				$option = $_POST['option'] ?? 0;
				if($idproducto > 0 and ($option == 1 or $option == 2) and !empty($_SESSION['arrCarrito'])){
					$arrCarrito = $_SESSION['arrCarrito'];
					for ($pr=0; $pr < count($arrCarrito); $pr++) {
						if($arrCarrito[$pr]['idproducto'] == $idproducto && (int)($arrCarrito[$pr]['idvariante'] ?? 0) === $idvariante){
							unset($arrCarrito[$pr]);
						}
					}
					$arrCarrito = array_values($arrCarrito);
					$_SESSION['arrCarrito'] = $arrCarrito;
					$cantCarrito = 0; $subtotal = 0;
					foreach ($_SESSION['arrCarrito'] as $pro) {
						$cantCarrito += $pro['cantidad'];
						$subtotal += $pro['cantidad'] * $pro['precio'];
					}
					$htmlCarrito = "";
					if($option == 1){
						$htmlCarrito = getFile('Template/Modals/modalCarrito',$_SESSION['arrCarrito']);
					}
					$arrResponse = array("status" => true,
											"msg" => '¡Producto eliminado!',
											"cantCarrito" => $cantCarrito,
											"htmlCarrito" => $htmlCarrito,
											"subTotal" => SMONEY.formatMoney($subtotal),
											"total" => SMONEY.formatMoney($subtotal + COSTOENVIO)
										);
				}else{
					$arrResponse = array("status" => false, "msg" => 'Dato incorrecto.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function updCarrito(){
			if($_POST){
				list($idproducto, $idvariante) = decodeItem($_POST['id'] ?? '');
				$cantidad = intval($_POST['cantidad'] ?? 0);
				if($idproducto > 0 and $cantidad > 0 and $cantidad <= 99 and !empty($_SESSION['arrCarrito'])){
					$arrCarrito = $_SESSION['arrCarrito'];
					$totalProducto = 0;
					for ($p=0; $p < count($arrCarrito); $p++) {
						if($arrCarrito[$p]['idproducto'] == $idproducto && (int)($arrCarrito[$p]['idvariante'] ?? 0) === $idvariante){
							// la cantidad no puede pasar del stock disponible (de la variante si la hay)
							$stock = 0;
							if($idvariante > 0){
								$v = $this->getVarianteT($idvariante, $idproducto);
								$stock = (int)($v['stock'] ?? 0);
							}else{
								$info = $this->getProductoIDT($idproducto);
								$stock = (int)($info['stock'] ?? 0);
							}
							$cantidad = min($cantidad, max(1, $stock));
							$arrCarrito[$p]['cantidad'] = $cantidad;
							$totalProducto = $arrCarrito[$p]['precio'] * $cantidad;
							break;
						}
					}
					$_SESSION['arrCarrito'] = $arrCarrito;
					$subtotal = 0;
					foreach ($_SESSION['arrCarrito'] as $pro) {
						$subtotal += $pro['cantidad'] * $pro['precio'];
					}
					$arrResponse = array("status" => true,
										"msg" => '¡Producto actualizado!',
										"cantidad" => $cantidad,
										"totalProducto" => SMONEY.formatMoney($totalProducto),
										"subTotal" => SMONEY.formatMoney($subtotal),
										"total" => SMONEY.formatMoney($subtotal + COSTOENVIO)
									);
				}else{
					$arrResponse = array("status" => false, "msg" => 'Dato incorrecto.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
	public function registro(){ if($_POST){
		if(empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmailCliente']) || empty($_POST['txtPassword1']) || empty($_POST['txtConfirmPassword']))
		{
			$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
		}else{ 
			$strNombre = ucwords(strClean($_POST['txtNombre']));
			$strApellido = ucwords(strClean($_POST['txtApellido']));
			$intTelefono = intval(strClean($_POST['txtTelefono']));
			$strEmail = strtolower(strClean($_POST['txtEmailCliente']));
			$strPassword = $_POST['txtPassword1'];
			$strConfirmPassword = $_POST['txtConfirmPassword'];
			$intTipoId = RCLIENTES; 
			$request_user = "";

			// Validar que las contraseñas coincidan
			if($strPassword !== $strConfirmPassword) { $arrResponse = array("status" => false, "msg" => 'Las contraseñas no coinciden.'); } else if(strlen($strPassword) < 8) { $arrResponse = array("status" => false, "msg" => 'La contraseña debe tener al menos 8 caracteres.'); } else if(!filter_var($strEmail, FILTER_VALIDATE_EMAIL)) { $arrResponse = array("status" => false, "msg" => 'El correo no es válido.'); } else { $strPasswordEncript = passwordHash($strPassword);
				$request_user = $this->insertCliente($strNombre, 
													$strApellido, 
													$intTelefono, 
													$strEmail,
													$strPasswordEncript,
													$intTipoId );
				if($request_user > 0 )
				{
					$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
					$nombreUsuario = $strNombre.' '.$strApellido;
					$dataUsuario = array('nombreUsuario' => $nombreUsuario,
										 'email' => $strEmail, 'asunto' => 'Bienvenido a tu tienda en linea');
					session_regenerate_id(true); $_SESSION['idUser'] = $request_user; $_SESSION['login'] = true; $this->login->sessionLogin($request_user);
					sendEmail($dataUsuario,'email_bienvenida');

				}else if($request_user == 'exist'){
					$arrResponse = array('status' => false, 'msg' => '¡Atención! el email ya existe, ingrese otro.');		
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
			}
		}
		echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
	}
	die();
}


		public function procesarVenta(){ if($_POST){ if(empty($_SESSION['login']) || empty($_SESSION['idUser'])){ echo json_encode(array("status" => false, "msg" => 'Inicia sesión para completar tu pedido.'), JSON_UNESCAPED_UNICODE); die(); } $idtransaccionpaypal = NULL;
				$datospaypal = NULL;
				$personaid = $_SESSION['idUser'];
				$monto = 0;
				$tipopagoid = intval($_POST['inttipopago']);
				$direccionenvio = strClean($_POST['direccion']).', '.strClean($_POST['ciudad']);
				$status = "Pendiente";
				$subtotal = 0;
				$costo_envio = COSTOENVIO;

				if(!empty($_SESSION['arrCarrito'])){ // Precios y stock se vuelven a leer de la base: lo guardado en sesión no es confiable
					foreach ($_SESSION['arrCarrito'] as $k => $pro) {
						$infoReal = $this->getProductoIDT((int)$pro['idproducto']);
						$precioReal = $infoReal['precio'] ?? 0;
						$stockReal = (int)($infoReal['stock'] ?? 0);
						$idv = (int)($pro['idvariante'] ?? 0);
						if($idv > 0 && !empty($infoReal)){
							$v = $this->getVarianteT($idv, (int)$pro['idproducto']);
							$stockReal = $v ? (int)$v['stock'] : 0;
							if($v && $v['precio'] !== null){ $precioReal = $v['precio']; }
						}
						if(empty($infoReal) || $stockReal < (int)$pro['cantidad'] || (int)$pro['cantidad'] < 1){
							echo json_encode(array("status" => false, "msg" => 'Un producto de tu carrito ya no está disponible en esa cantidad. Revisa tu carrito.'), JSON_UNESCAPED_UNICODE); die();
						}
						$_SESSION['arrCarrito'][$k]['precio'] = $precioReal;
					} foreach ($_SESSION['arrCarrito'] as $pro) { $subtotal += $pro['cantidad'] * $pro['precio']; } $monto = $subtotal + COSTOENVIO;
					//Pago contra entrega
					if(empty($_POST['datapay'])){
						//Crear pedido
						$request_pedido = $this->insertPedido($idtransaccionpaypal, 
															$datospaypal, 
															$personaid,
															$costo_envio,
															$monto, 
															$tipopagoid,
															$direccionenvio, 
															$status);
						if($request_pedido > 0 ){
							//Insertamos detalle
							foreach ($_SESSION['arrCarrito'] as $producto) {
								$productoid = $producto['idproducto'];
								$precio = $producto['precio'];
								$cantidad = $producto['cantidad'];
								$this->insertDetalle($request_pedido,$productoid,$precio,$cantidad, (int)($producto['idvariante'] ?? 0) ?: null, ($producto['variante'] ?? '') !== '' ? $producto['variante'] : null);
							}

							$infoOrden = $this->getPedido($request_pedido);
							$dataEmailOrden = array('asunto' => "Se ha creado la orden No.".$request_pedido,
													'email' => $_SESSION['userData']['email_user'], 
													'emailCopia' => EMAIL_PEDIDOS,
													'pedido' => $infoOrden );
							sendEmail($dataEmailOrden,"email_notificacion_orden");

							$orden = openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
							$transaccion = openssl_encrypt((string)$idtransaccionpaypal, METHODENCRIPT, KEY);
							$arrResponse = array("status" => true, 
											"orden" => $orden, 
											"transaccion" =>$transaccion,
											"msg" => 'Pedido realizado'
										);
							$_SESSION['dataorden'] = $arrResponse;
							unset($_SESSION['arrCarrito']);
							session_regenerate_id(true);
						}
					}else{ //Pago con PayPal
						$objCliente = json_decode($_POST['datapay']); $status = "Aprobado"; // El pago se verifica contra PayPal desde el servidor: lo que envía el navegador no es confiable
						$objPaypal = (is_object($objCliente) && !empty($objCliente->id) && preg_match('/^[A-Za-z0-9]+$/', $objCliente->id) && IDCLIENTE != "") ? CurlConnectionGet(URLPAYPAL."/v2/checkout/orders/".$objCliente->id, "application/json", getTokenPaypal()) : null;
						if(is_object($objPaypal) && !empty($objPaypal->purchase_units[0]->payments->captures[0]->id)){ $jsonPaypal = json_encode($objPaypal); $datospaypal = $jsonPaypal; $idtransaccionpaypal = $objPaypal->purchase_units[0]->payments->captures[0]->id; $montoPagado = (float)($objPaypal->purchase_units[0]->amount->value ?? 0); $monedaPagada = $objPaypal->purchase_units[0]->amount->currency_code ?? ''; if($objPaypal->status == "COMPLETED" && abs($montoPagado - $monto) < 0.01 && $monedaPagada == CURRENCY && !$this->existeTransaccion($idtransaccionpaypal)){ $status = "Completo";
								//Crear pedido
								$request_pedido = $this->insertPedido($idtransaccionpaypal, 
																	$datospaypal, 
																	$personaid,
																	$costo_envio,
																	$monto, 
																	$tipopagoid,
																	$direccionenvio, 
																	$status);
								if($request_pedido > 0 ){
									//Insertamos detalle
									foreach ($_SESSION['arrCarrito'] as $producto) {
										$productoid = $producto['idproducto'];
										$precio = $producto['precio'];
										$cantidad = $producto['cantidad'];
										$this->insertDetalle($request_pedido,$productoid,$precio,$cantidad, (int)($producto['idvariante'] ?? 0) ?: null, ($producto['variante'] ?? '') !== '' ? $producto['variante'] : null);
									}
									$infoOrden = $this->getPedido($request_pedido);
									$dataEmailOrden = array('asunto' => "Se ha creado la orden No.".$request_pedido,
													'email' => $_SESSION['userData']['email_user'], 
													'emailCopia' => EMAIL_PEDIDOS,
													'pedido' => $infoOrden );

									sendEmail($dataEmailOrden,"email_notificacion_orden");

									$orden = openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
									$transaccion = openssl_encrypt((string)$idtransaccionpaypal, METHODENCRIPT, KEY);
									$arrResponse = array("status" => true, 
													"orden" => $orden, 
													"transaccion" =>$transaccion,
													"msg" => 'Pedido realizado'
												);
									$_SESSION['dataorden'] = $arrResponse;
									unset($_SESSION['arrCarrito']);
									session_regenerate_id(true);
								}else{
									$arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
								}
							}else{
								$arrResponse = array("status" => false, "msg" => 'No es posible completar el pago con PayPal.');
							}
						}else{
							$arrResponse = array("status" => false, "msg" => 'Hubo un error en la transacción.');
						}
					}
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
				}
			}else{
				$arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
			}

			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function confirmarpedido(){
			if(empty($_SESSION['dataorden'])){
				header("Location: ".base_url());
			}else{
				$dataorden = $_SESSION['dataorden'];
				$idpedido = openssl_decrypt($dataorden['orden'], METHODENCRIPT, KEY);
				$transaccion = openssl_decrypt($dataorden['transaccion'], METHODENCRIPT, KEY);
				$data['page_tag'] = "Confirmar Pedido";
				$data['page_title'] = "Confirmar Pedido";
				$data['page_name'] = "confirmarpedido";
				$data['orden'] = $idpedido;
				$data['transaccion'] = $transaccion;
				$this->views->getView($this,"confirmarpedido",$data);
			}
			unset($_SESSION['dataorden']);
		}

		public function page($pagina = null){

			$pagina = max(1, (int)$pagina);
			$cantProductos = $this->cantProductos();
			$total_registro = $cantProductos['total_registro'];
			$desde = ($pagina-1) * PROPORPAGINA;
			$total_paginas = ceil($total_registro / PROPORPAGINA);
			$data['productos'] = $this->getProductosPage($desde,PROPORPAGINA);
			//dep($data['productos']);exit;
			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = NOMBRE_EMPESA;
			$data['page_name'] = "tienda";
			$data['pagina'] = $pagina;
			$data['total_paginas'] = $total_paginas;
			$data['categorias'] = $this->getCategorias();
			$this->views->getView($this,"tienda",$data);
		}

            public function search() {
            if (empty($_REQUEST['s'])) {
                header("Location: " . base_url());
                exit; // Detiene la ejecución después de la redirección
            } else {
                $busqueda = strClean($_REQUEST['s']);
            }
        
            $pagina = empty($_REQUEST['p']) ? 1 : max(1, intval($_REQUEST['p']));
            $cantProductos = $this->cantProdSearch($busqueda);
            $total_registro = $cantProductos['total_registro'] ?? 0;
            $desde = ($pagina - 1) * PROBUSCAR;
            $total_paginas = ceil($total_registro / PROBUSCAR);
        
            $data['productos'] = $this->getProdSearch($busqueda, $desde, PROBUSCAR);
            $data['page_tag'] = NOMBRE_EMPESA;
            $data['page_title'] = "Resultado de: " . htmlspecialchars($busqueda);
            $data['page_name'] = "tienda";
            $data['pagina'] = $pagina;
            $data['total_paginas'] = $total_paginas;
            $data['busqueda'] = $busqueda;
            $data['categorias'] = $this->getCategorias();
        
            $this->views->getView($this, "search", $data);
        }



		public function suscripcion(){
			if($_POST){
				$nombre = ucwords(strtolower(strClean($_POST['nombreSuscripcion'])));
				$email = strtolower(strClean($_POST['emailSuscripcion'])); if(!empty($_POST['sitio_web']) || !formTokenValido($_POST['ft'] ?? '') || pareceBasura(strClean($_POST['nombreSuscripcion'] ?? '')) || correoBloqueado($email)){
					echo json_encode(array('status' => false, 'msg' => 'No pudimos registrar tu suscripción. Recarga la página e inténtalo de nuevo.'), JSON_UNESCAPED_UNICODE); die();
				}
				if(!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($nombre) > 100){ echo json_encode(array('status' => false, 'msg' => 'Escribe un correo válido.'), JSON_UNESCAPED_UNICODE); die(); } $suscripcion = $this->setSuscripcion($nombre,$email); if($suscripcion > 0){
					$arrResponse = array('status' => true, 'msg' => "Gracias por tu suscripción.");
					//Enviar correo
					$dataUsuario = array('asunto' => "Nueva suscripción",
										'email' => EMAIL_SUSCRIPCION,
										'nombreSuscriptor' => $nombre,
										'emailSuscriptor' => $email );
					sendEmail($dataUsuario,"email_suscripcion");
				}else{
					$arrResponse = array('status' => false, 'msg' => "El email ya fue registrado.");
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

			}
			die();
		}

		public function contacto(){
			if($_POST){
				//dep($_POST);
				$nombre = ucwords(strtolower(strClean($_POST['nombreContacto'])));
				$email  = strtolower(strClean($_POST['emailContacto']));
				$mensaje = strClean($_POST['mensaje']); if(!empty($_POST['sitio_web']) || !formTokenValido($_POST['ft'] ?? '') || pareceBasura(strClean($_POST['nombreContacto'] ?? '')) || pareceBasura($mensaje, false) || correoBloqueado($email) || textoSpam($mensaje)){
					echo json_encode(array('status' => false, 'msg' => 'No pudimos enviar tu mensaje. Recarga la página e inténtalo de nuevo.'), JSON_UNESCAPED_UNICODE); die();
				}
				if(!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($mensaje) < 10 || mb_strlen($mensaje) > 2000 || mb_strlen($nombre) > 100 || preg_match_all('~https?://~i', $mensaje) > 1 || loginBloqueado('contacto', 3, 60)){ echo json_encode(array('status' => false, 'msg' => 'No pudimos enviar tu mensaje. Revisa los datos e inténtalo más tarde.'), JSON_UNESCAPED_UNICODE); die(); } loginFallo('contacto', 60); $useragent = $_SERVER['HTTP_USER_AGENT'] ?? '';
				$ip = $_SERVER['REMOTE_ADDR'] ?? '';
				$dispositivo= "PC";

				if(preg_match("/mobile/i",$useragent)){
					$dispositivo = "Movil";
				}else if(preg_match("/tablet/i",$useragent)){
					$dispositivo = "Tablet";
				}else if(preg_match("/iPhone/i",$useragent)){
					$dispositivo = "iPhone";
				}else if(preg_match("/iPad/i",$useragent)){
					$dispositivo = "iPad";
				}

				$userContact = $this->setContacto($nombre,$email,$mensaje,$ip,$dispositivo,$useragent);
				if($userContact > 0){
					$arrResponse = array('status' => true, 'msg' => "Su mensaje fue enviado correctamente.");
					//Enviar correo
					$dataUsuario = array('asunto' => "Nueva Usuario en contacto",
										'email' => EMAIL_CONTACTO,
										'nombreContacto' => $nombre,
										'emailContacto' => $email,
										'mensaje' => $mensaje );
					sendEmail($dataUsuario,"email_contacto");
				}else{
					$arrResponse = array('status' => false, 'msg' => "No es posible enviar el mensaje.");
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

			}
			die();
		}

	}
