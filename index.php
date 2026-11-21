<?php
	// Los errores se registran en el log, nunca se muestran al visitante
	ini_set('display_errors', '0');
	ini_set('log_errors', '1');
	error_reporting(E_ALL);

	// Cualquier error no controlado: se registra en el log y el visitante recibe un mensaje genérico (sin rutas, SQL ni trazas)
	set_exception_handler(function (Throwable $e) {
		error_log('Excepción no controlada: ' . get_class($e) . ': ' . $e->getMessage() . ' en ' . $e->getFile() . ':' . $e->getLine());
		if (!headers_sent()) { http_response_code(500); }
		$ajax = ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' || stripos($_SERVER['HTTP_ACCEPT'] ?? '', 'json') !== false;
		if ($ajax) {
			if (!headers_sent()) { header('Content-Type: application/json; charset=utf-8'); }
			echo json_encode(array('status' => false, 'msg' => 'No fue posible procesar la solicitud. Intenta de nuevo.'), JSON_UNESCAPED_UNICODE);
		} else {
			echo 'Ocurrió un error. Intenta de nuevo en unos minutos.';
		}
	});

	require_once("Config/Config.php");
	require_once("Helpers/Helpers.php");
	require_once("Libraries/Core/Ajustes.php");
	Ajustes::cargar(); // nombre, contacto, correo, PayPal, moneda... (se editan en el panel: Configuración)

	// Cabeceras de seguridad
	header('X-Content-Type-Options: nosniff');
	header('X-Frame-Options: SAMEORIGIN');
	header('Referrer-Policy: strict-origin-when-cross-origin');
	header('Permissions-Policy: geolocation=(), microphone=(), camera=(), payment=()');
	if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
		header('Strict-Transport-Security: max-age=15552000');
	}

	// Anti-CSRF: un POST solo se acepta si viene de este mismo sitio
	if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
		$origen = $_SERVER['HTTP_ORIGIN'] ?? ($_SERVER['HTTP_REFERER'] ?? '');
		$hostPeticion = explode(':', $_SERVER['HTTP_HOST'] ?? '')[0];
		if ($origen !== '' && parse_url($origen, PHP_URL_HOST) !== $hostPeticion) {
			http_response_code(403);
			exit('Solicitud no permitida.');
		}
	}

	$url = (!empty($_GET['url']) && is_string($_GET['url'])) ? $_GET['url'] : 'home/home';
	$arrUrl = explode("/", $url);
	$controller = $arrUrl[0];
	$method = $arrUrl[0];
	$params = "";

	if(!empty($arrUrl[1]))
	{
		$method = $arrUrl[1];
	}

	if(!empty($arrUrl[2]))
	{
		$params = trim(implode(',', array_slice($arrUrl, 2)), ',');
	}
	require_once("Libraries/Core/Autoload.php");
	require_once("Libraries/Core/Load.php");
