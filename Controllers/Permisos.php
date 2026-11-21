<?php 

	class Permisos extends Controllers{
		public function __construct() { parent::__construct(); startSecureSession(); if(empty($_SESSION['login'])){ http_response_code(403); die(); } getPermisos(MUSUARIOS); }

		public function getPermisosRol(int $idrol) { if(empty($_SESSION['permisosMod']['r'])){ http_response_code(403); die(); }
			$rolid = intval($idrol);
			if($rolid > 0)
			{
				$arrModulos = $this->model->selectModulos();
				$arrPermisosRol = $this->model->selectPermisosRol($rolid);
				$arrRol = $this->model->getRol($rolid);
				$arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
				$arrPermisoRol = array('idrol' => $rolid, 'rol' => $arrRol['nombrerol']);

				if(empty($arrPermisosRol))
				{
					for ($i=0; $i < count($arrModulos) ; $i++) { 

						$arrModulos[$i]['permisos'] = $arrPermisos;
					}
				}else{
					for ($i=0; $i < count($arrModulos); $i++) {
						$arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
						if(isset($arrPermisosRol[$i])){
							$arrPermisos = array('r' => $arrPermisosRol[$i]['r'], 
												 'w' => $arrPermisosRol[$i]['w'], 
												 'u' => $arrPermisosRol[$i]['u'], 
												 'd' => $arrPermisosRol[$i]['d'] 
												);
						}
						$arrModulos[$i]['permisos'] = $arrPermisos;
					}
				}
				$arrPermisoRol['modulos'] = $arrModulos;
				$html = getModal("modalPermisos",$arrPermisoRol);
			}
			die();
		}

		public function setPermisos() { if(empty($_SESSION['permisosMod']['u'])){ http_response_code(403); die(); }
			if($_POST)
			{
				$responder = function($ok, $msg){ echo json_encode(array('status' => $ok, 'msg' => $msg), JSON_UNESCAPED_UNICODE); die(); };
				$intIdrol = intval($_POST['idrol'] ?? 0);
				$modulos = $_POST['modulos'] ?? null;
				// Se valida TODO antes de modificar nada: un envío mal formado ya no deja al rol sin permisos
				if($intIdrol <= 0 || empty($this->model->getRol($intIdrol)) || !is_array($modulos) || !$modulos){ $responder(false, 'Datos incorrectos.'); }
				$filas = array();
				foreach ($modulos as $modulo) {
					if(!is_array($modulo) || !isset($modulo['idmodulo']) || !ctype_digit((string)$modulo['idmodulo'])){ $responder(false, 'Datos incorrectos.'); }
					$filas[] = array((int)$modulo['idmodulo'], empty($modulo['r']) ? 0 : 1, empty($modulo['w']) ? 0 : 1, empty($modulo['u']) ? 0 : 1, empty($modulo['d']) ? 0 : 1);
				}
				if($this->model->guardarPermisos($intIdrol, $filas)){ $responder(true, 'Permisos asignados correctamente.'); }
				$responder(false, 'No es posible asignar los permisos.');
			}
			die();
		}

	}
 ?>