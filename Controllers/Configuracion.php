<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailException;

class Configuracion extends Controllers{
	public function __construct()
	{
		parent::__construct();
		startSecureSession();
		if(empty($_SESSION['login']))
		{
			header('Location: '.base_url().'/login');
			die();
		}
		getPermisos(MCONFIGURACION);
	}

	private function categoriasActivas(){
		return (new Mysql())->select_all("SELECT idcategoria, nombre FROM categoria WHERE status = 1 ORDER BY nombre");
	}

	public function configuracion()
	{
		if(empty($_SESSION['permisosMod']['r'])){
			header("Location:".base_url().'/dashboard'); die();
		}
		$data['page_tag'] = "Configuración";
		$data['page_title'] = "CONFIGURACIÓN <small>".escapar(NOMBRE_EMPESA)."</small>";
		$data['page_name'] = "configuracion";
		$data['page_functions_js'] = "functions_configuracion.js";
		$data['grupos'] = Ajustes::grupos();
		$data['campos'] = Ajustes::campos();
		$data['valores'] = Ajustes::valoresParaFormulario();
		$data['categorias'] = $this->categoriasActivas();
		$data['fijosEnArchivo'] = array_values(array_unique(Ajustes::$fijosEnArchivo));
		$data['puedeEditar'] = !empty($_SESSION['permisosMod']['u']);
		$this->views->getView($this,"configuracion",$data);
	}

	public function guardar()
	{
		if(empty($_SESSION['permisosMod']['u'])){ http_response_code(403); die(); }
		header('Content-Type: application/json; charset=utf-8');
		if(!$_POST || !isset($_POST['ajustes']) || !is_array($_POST['ajustes'])){
			echo json_encode(array('status' => false, 'msg' => 'Datos incorrectos.'), JSON_UNESCAPED_UNICODE); die();
		}
		$ids = array_map('intval', array_column($this->categoriasActivas(), 'idcategoria'));
		list($ok, $errores) = Ajustes::guardar($_POST['ajustes'], $ids);
		if($ok){
			echo json_encode(array('status' => true, 'msg' => 'Configuración guardada. Los cambios ya están activos en la tienda.'), JSON_UNESCAPED_UNICODE);
		}else{
			echo json_encode(array('status' => false, 'msg' => 'Revisa los datos marcados en rojo.', 'errores' => $errores), JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	/** Envía un correo de prueba con la configuración SMTP ya guardada, para comprobar que funciona. */
	public function probarCorreo()
	{
		if(empty($_SESSION['permisosMod']['u'])){ http_response_code(403); die(); }
		header('Content-Type: application/json; charset=utf-8');
		$responder = function($ok, $msg){ echo json_encode(array('status' => $ok, 'msg' => $msg), JSON_UNESCAPED_UNICODE); die(); };
		$destino = trim((string)($_POST['destino'] ?? ''));
		if(!filter_var($destino, FILTER_VALIDATE_EMAIL)){ $responder(false, 'Escribe un correo válido para recibir la prueba.'); }
		if(SMTP_HOST === '' || SMTP_USER === '' || SMTP_PASSWORD === ''){ $responder(false, 'Primero guarda el servidor, el usuario y la contraseña del correo.'); }
		if(loginBloqueado('smtp-prueba', 5, 10)){ $responder(false, 'Demasiadas pruebas seguidas. Espera unos minutos.'); }
		loginFallo('smtp-prueba', 10);
		$mail = new PHPMailer(true);
		try{
			$mail->isSMTP();
			$mail->Host = SMTP_HOST; $mail->SMTPAuth = true; $mail->Username = SMTP_USER; $mail->Password = SMTP_PASSWORD;
			$mail->SMTPSecure = (SMTP_PORT == 587) ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS;
			$mail->Port = SMTP_PORT; $mail->Timeout = 12; $mail->CharSet = 'UTF-8';
			$mail->setFrom(EMAIL_REMITENTE !== '' ? EMAIL_REMITENTE : SMTP_USER, NOMBRE_EMPESA);
			$mail->addAddress($destino);
			$mail->Subject = 'Prueba de correo - '.NOMBRE_EMPESA;
			$mail->Body = 'Si recibes este mensaje, el correo de tu tienda está bien configurado.';
			$mail->send();
			$responder(true, 'Listo: se envió el correo de prueba a '.$destino.'. Revisa tu bandeja (y la carpeta de spam).');
		}catch(MailException $e){
			error_log('Prueba SMTP: '.$mail->ErrorInfo);
			$responder(false, 'No se pudo enviar: '.strip_tags($mail->ErrorInfo));
		}
	}
}
