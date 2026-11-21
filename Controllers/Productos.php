<?php 
	class Productos extends Controllers{
		public function __construct()
		{
			parent::__construct();
			startSecureSession();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
			getPermisos(MPRODUCTOS);
		}

		public function Productos()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard'); die();
			}
			$data['page_tag'] = "Productos";
			$data['page_title'] = "PRODUCTOS <small>M&G Store</small>";
			$data['page_name'] = "productos";
			$data['page_functions_js'] = "functions_productos.js";
			$this->views->getView($this,"productos",$data);
		}

		public function getProductos()
		{
			if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectProductos();
				for ($i=0; $i < count($arrData); $i++) {
					$btnView = ''; $btnEdit = ''; $btnDelete = ''; $btnVar = '';

					if($arrData[$i]['status'] == 1)
					{
						$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}

					$arrData[$i]['compra'] = SMONEY.' '.formatMoney($arrData[$i]['compra']);
					$arrData[$i]['precio'] = SMONEY.' '.formatMoney($arrData[$i]['precio']);
					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['idproducto'].')" title="Ver producto"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['idproducto'].')" title="Editar producto"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){ $btnVar = '<button class="btn btn-warning btn-sm" onClick="fntVariantes('.$arrData[$i]['idproducto'].')" title="Variantes: color, talla, medidas…"><i class="fas fa-layer-group"></i></button>'; }
					if($_SESSION['permisosMod']['d']){ $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idproducto'].')" title="Eliminar producto"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnVar.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

	public function setProducto(){
			if($_POST){
				if(empty($_POST['txtNombre']) || empty($_POST['txtCodigo']) || empty($_POST['listCategoria']) || empty($_POST['txtCompra']) || empty($_POST['txtPrecio']) || empty($_POST['txtStock']) || empty($_POST['listStatus']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					
					$idProducto = intval($_POST['idProducto']);
					$strNombre = strClean($_POST['txtNombre']);
					$strDescripcion = htmlSeguro($_POST['txtDescripcion']);
					$strCodigo = strClean($_POST['txtCodigo']);
					$intCategoriaId = intval($_POST['listCategoria']);
					$strCompra = strClean($_POST['txtCompra']);
					$strPrecio = strClean($_POST['txtPrecio']);
					$intStock = intval($_POST['txtStock']);
					$intStatus = intval($_POST['listStatus']);
					$request_producto = "";

				    // Limpiar la ruta usando la función cleanUrl que esta helpers.php
                    $ruta = cleanUrl($strNombre);
					
					if($idProducto == 0)
					{
						$option = 1;
						if($_SESSION['permisosMod']['w']){
							$request_producto = $this->model->insertProducto($strNombre, 
																		$strDescripcion, 
																		$strCodigo, 
																		$intCategoriaId,
																		$strCompra, 
																		$strPrecio, 
																		$intStock, 
																		$ruta,
																		$intStatus );
						}
					}else{
						$option = 2;
						if($_SESSION['permisosMod']['u']){
							$request_producto = $this->model->updateProducto($idProducto,
																		$strNombre,
																		$strDescripcion, 
																		$strCodigo, 
																		$intCategoriaId,
																		$strCompra, 
																		$strPrecio, 
																		$intStock, 
																		$ruta,
																		$intStatus);
						}
					}
					if($request_producto > 0 )
					{
						if($option == 1){
							$arrResponse = array('status' => true, 'idproducto' => $request_producto, 'msg' => 'Datos guardados correctamente.');
						}else{
							$arrResponse = array('status' => true, 'idproducto' => $idProducto, 'msg' => 'Datos Actualizados correctamente.');
						}
					}else if($request_producto == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! ya existe un producto con el Código Ingresado.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}


		//---------- Variantes (color, talla, medidas...) ----------
		public function getVariantes($idproducto){
			if(empty($_SESSION['permisosMod']['r'])){ http_response_code(403); die(); }
			$idproducto = intval($idproducto);
			$producto = $idproducto > 0 ? $this->model->selectProducto($idproducto) : [];
			if(empty($producto)){
				echo json_encode(array('status' => false, 'msg' => 'Producto no encontrado.'), JSON_UNESCAPED_UNICODE); die();
			}
			echo json_encode(array('status' => true,
				'producto' => array('id' => (int)$producto['idproducto'], 'nombre' => $producto['nombre'], 'precio' => (float)$producto['precio']),
				'variantes' => $this->model->selectVariantes($idproducto)), JSON_UNESCAPED_UNICODE);
			die();
		}
		public function setVariantes(){
			if(empty($_SESSION['permisosMod']['u'])){ http_response_code(403); die(); }
			$responder = function($status, $msg){ echo json_encode(array('status' => $status, 'msg' => $msg), JSON_UNESCAPED_UNICODE); die(); };
			$idproducto = intval($_POST['idproducto'] ?? 0);
			$lista = json_decode($_POST['variantes'] ?? '', true);
			if($idproducto <= 0 || empty($this->model->selectProducto($idproducto)) || !is_array($lista)){ $responder(false, 'Datos incorrectos.'); }
			if(count($lista) > 150){ $responder(false, 'Máximo 150 variantes por producto.'); }
			$items = []; $vistas = []; $nombresAttr = null;
			foreach($lista as $n => $v){
				$fila = $n + 1;
				$attrs = [];
				foreach(($v['atributos'] ?? []) as $nombre => $valor){
					$nombre = mb_substr(strClean((string)$nombre), 0, 30); $valor = mb_substr(strClean((string)$valor), 0, 40);
					if($nombre === '' || $valor === ''){ $responder(false, "Variante $fila: cada atributo necesita nombre y valor."); }
					$attrs[$nombre] = $valor;
				}
				if(count($attrs) < 1 || count($attrs) > 4){ $responder(false, "Variante $fila: usa entre 1 y 4 atributos (ej. Color, Talla)."); }
				$nombres = array_keys($attrs);
				if($nombresAttr === null){ $nombresAttr = $nombres; }
				elseif($nombres !== $nombresAttr){ $responder(false, "Variante $fila: todas las variantes deben usar los mismos atributos y en el mismo orden."); }
				$etiqueta = implode(' / ', array_values($attrs));
				$clave = mb_strtolower($etiqueta);
				if(isset($vistas[$clave])){ $responder(false, "La combinación «{$etiqueta}» está repetida."); }
				$vistas[$clave] = true;
				$precio = ($v['precio'] ?? '') === '' || $v['precio'] === null ? null : round((float)$v['precio'], 2);
				if($precio !== null && ($precio < 0 || $precio > 9999999)){ $responder(false, "Variante «{$etiqueta}»: precio no válido."); }
				$stock = intval($v['stock'] ?? 0);
				if($stock < 0 || $stock > 1000000){ $responder(false, "Variante «{$etiqueta}»: stock no válido."); }
				$items[] = array('id' => intval($v['id'] ?? 0), 'atributos' => $attrs, 'etiqueta' => $etiqueta,
					'codigo' => mb_substr(strClean((string)($v['codigo'] ?? '')), 0, 50) ?: null,
					'precio' => $precio, 'stock' => $stock, 'status' => empty($v['status']) ? 0 : 1);
			}
			if($this->model->saveVariantes($idproducto, $items)){ $responder(true, 'Variantes guardadas correctamente.'); }
			$responder(false, 'No fue posible guardar las variantes.');
		}
		public function getProducto($idproducto){
			if($_SESSION['permisosMod']['r']){
				$idproducto = intval($idproducto);
				if($idproducto > 0){
					$arrData = $this->model->selectProducto($idproducto);
					if(empty($arrData)){
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						$arrImg = $this->model->selectImages($idproducto);
						if(count($arrImg) > 0){
							for ($i=0; $i < count($arrImg); $i++) { 
								$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
							}
						}
						$arrData['images'] = $arrImg;
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function setImage(){ if($_POST){ if(empty($_SESSION['permisosMod']['u']) && empty($_SESSION['permisosMod']['w'])){ http_response_code(403); die(); } if(empty($_POST['idproducto']) || !isset($_FILES['foto']) || !esImagenValida($_FILES['foto'])){
					$arrResponse = array('status' => false, 'msg' => 'Error de dato.');
				}else{
					$idProducto = intval($_POST['idproducto']);
					$foto      = $_FILES['foto'];
					$imgNombre = 'pro_'.bin2hex(random_bytes(16)).'.jpg';
					$request_image = $this->model->insertImage($idProducto,$imgNombre);
					if($request_image){
						$uploadImage = uploadImage($foto,$imgNombre);
						$arrResponse = array('status' => true, 'imgname' => $imgNombre, 'msg' => 'Archivo cargado.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error de carga.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function delFile(){ if($_POST){ if(empty($_SESSION['permisosMod']['u'])){ http_response_code(403); die(); } if(empty($_POST['idproducto']) || empty($_POST['file'])){
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					//Eliminar de la DB
					$idProducto = intval($_POST['idproducto']);
					$imgNombre = basename(strClean($_POST['file']));
					$request_image = $this->model->deleteImage($idProducto,$imgNombre);

					if($request_image){
						$deleteFile =  deleteFile($imgNombre);
						$arrResponse = array('status' => true, 'msg' => 'Archivo eliminado');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function delProducto(){
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdproducto = intval($_POST['idProducto']);
					$requestDelete = $this->model->deleteProducto($intIdproducto);
					if($requestDelete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el producto');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el producto.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
	}

 ?>