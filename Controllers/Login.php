<?php 

	class Login extends Controllers{
		public function __construct()
		{
			startSecureSession(); if(isset($_SESSION['login']))
			{
				header('Location: '.base_url().'/dashboard');
				die();
			}
			parent::__construct();
		}

		public function login()
		{
			$data['page_tag'] = "Login - M&G Store";
			$data['page_title'] = "M&G Store";
			$data['page_name'] = "login";
			$data['page_functions_js'] = "functions_login.js";
			$this->views->getView($this,"login",$data);
		}

		public function loginUser(){
			//dep($_POST);
			if($_POST){
				if(empty($_POST['txtEmail']) || empty($_POST['txtPassword'])){
					$arrResponse = array('status' => false, 'msg' => 'Error de datos' );
				}else{
					$strUsuario = strtolower(strClean($_POST['txtEmail'])); if(loginBloqueado($strUsuario)){ echo json_encode(array('status' => false, 'msg' => 'Demasiados intentos. Espera 15 minutos e inténtalo de nuevo.'), JSON_UNESCAPED_UNICODE); die(); } $requestUser = $this->model->loginUser($strUsuario, (string)$_POST['txtPassword']); if(empty($requestUser)){ loginFallo($strUsuario); $arrResponse = array('status' => false, 'msg' => 'El usuario o la contraseña es incorrecto.' ); }else{ loginLimpiar($strUsuario);
						$arrData = $requestUser;
						if($arrData['status'] == 1){ session_regenerate_id(true); $_SESSION['idUser'] = $arrData['idpersona'];
							$_SESSION['login'] = true;

							$arrData = $this->model->sessionLogin($_SESSION['idUser']);
							sessionUser($_SESSION['idUser']);							
							$arrResponse = array('status' => true, 'msg' => 'ok');
						}else{
							$arrResponse = array('status' => false, 'msg' => 'Usuario inactivo.');
						}
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function resetPass(){
			if($_POST){ if(empty($_POST['txtEmailReset'])){
					$arrResponse = array('status' => false, 'msg' => 'Error de datos' );
				}else{
					$token = token();
					$strEmail  =  strtolower(strClean($_POST['txtEmailReset']));
					$arrData = $this->model->getUserEmail($strEmail);

					if(empty($arrData)){ // Misma respuesta que si existiera: no revela qué correos están registrados
						$arrResponse = array('status' => true, 'msg' => 'Si el correo está registrado, te enviamos las instrucciones para cambiar tu contraseña.' ); }else{
						$idpersona = $arrData['idpersona'];
						$nombreUsuario = $arrData['nombres'].' '.$arrData['apellidos'];

						$url_recovery = base_url().'/login/confirmUser/'.$strEmail.'/'.$token;
						$requestUpdate = $this->model->setTokenUser($idpersona,$token);

						$dataUsuario = array('nombreUsuario' => $nombreUsuario,
											 'email' => $strEmail,
											 'asunto' => 'Recuperar cuenta - '.NOMBRE_REMITENTE,
											 'url_recovery' => $url_recovery);
						if($requestUpdate){
							$sendEmail = sendEmail($dataUsuario,'email_cambioPassword');

							if($sendEmail){
								$arrResponse = array('status' => true, 
												 'msg' => 'Se ha enviado un email a tu cuenta de correo para cambiar tu contraseña.');
							}else{
								$arrResponse = array('status' => false, 
												 'msg' => 'No es posible realizar el proceso, intenta más tarde.' );
							}
						}else{
							$arrResponse = array('status' => false, 
												 'msg' => 'No es posible realizar el proceso, intenta más tarde.' );
						}
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function confirmUser(string $params){

			if(empty($params)){
				header('Location: '.base_url());
			}else{
				$arrParams = explode(',',$params);
				$strEmail = strClean($arrParams[0]);
				$strToken = strClean($arrParams[1]);
				$arrResponse = $this->model->getUsuario($strEmail,$strToken);
				if(empty($arrResponse)){
					header("Location: ".base_url());
				}else{
					$data['page_tag'] = "Cambiar contraseña";
					$data['page_name'] = "cambiar_contrasenia";
					$data['page_title'] = "Cambiar Contraseña";
					$data['email'] = $strEmail;
					$data['token'] = $strToken;
					$data['idpersona'] = $arrResponse['idpersona'];
					$data['page_functions_js'] = "functions_login.js";
					$this->views->getView($this,"cambiar_password",$data);
				}
			}
			die();
		}

		public function setPassword(){

			if(empty($_POST['idUsuario']) || empty($_POST['txtEmail']) || empty($_POST['txtToken']) || empty($_POST['txtPassword']) || empty($_POST['txtPasswordConfirm'])){

					$arrResponse = array('status' => false, 
										 'msg' => 'Error de datos' );
				}else{
					$strPassword = $_POST['txtPassword'];
					$strPasswordConfirm = $_POST['txtPasswordConfirm'];
					$strEmail = strClean($_POST['txtEmail']);
					$strToken = strClean($_POST['txtToken']);

					if($strPassword != $strPasswordConfirm){ $arrResponse = array('status' => false, 'msg' => 'Las contraseñas no son iguales.' ); }elseif(strlen($strPassword) < 8){ $arrResponse = array('status' => false, 'msg' => 'La contraseña debe tener al menos 8 caracteres.' ); }else{
						$arrResponseUser = $this->model->getUsuario($strEmail,$strToken);
						if(empty($arrResponseUser)){
							$arrResponse = array('status' => false, 
											 'msg' => 'Erro de datos.' );
						}else{
							// El id sale del token validado, nunca del formulario
							$requestPass = $this->model->insertPassword((int)$arrResponseUser['idpersona'], passwordHash($strPassword));

							if($requestPass){
								$arrResponse = array('status' => true, 
													 'msg' => 'Contraseña actualizada con éxito.');
							}else{
								$arrResponse = array('status' => false, 
													 'msg' => 'No es posible realizar el proceso, intente más tarde.');
							}
						}
					}
				}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

	}
 ?>