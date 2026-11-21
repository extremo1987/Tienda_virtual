<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require 'Libraries/phpmailer/Exception.php';
    require 'Libraries/phpmailer/PHPMailer.php';
    require 'Libraries/phpmailer/SMTP.php';

	//Retorla la url del proyecto
	function base_url()
	{
		return BASE_URL;
	}
    //Retorla la url de Assets
    function media()
    {
        return BASE_URL."/Assets";
    }
    function headerAdmin($data="")
    {
        $view_header = "Views/Template/header_admin.php";
        require_once ($view_header);
    }
    function footerAdmin($data="")
    {
        $view_footer = "Views/Template/footer_admin.php";
        require_once ($view_footer);        
    }
    function headerTienda($data="")
    {
        $view_header = "Views/Template/header_tienda.php";
        require_once ($view_header);
    }
    function footerTienda($data="")
    {
        $view_footer = "Views/Template/footer_tienda.php";
        require_once ($view_footer);        
    }
	//Muestra información formateada
	function dep($data)
    {
        $format  = print_r('<pre>');
        $format .= print_r($data);
        $format .= print_r('</pre>');
        return $format;
    }
    function getModal(string $nameModal, $data)
    {
        $view_modal = "Views/Template/Modals/{$nameModal}.php";
        require_once $view_modal;        
    }
    function getFile(string $url, $data)
    {
        ob_start();
        require_once("Views/{$url}.php");
        $file = ob_get_clean();
        return $file;        
    }
    //Envio de correos (las credenciales SMTP viven en Config/Config.php, nunca aquí)
    function sendEmail($data, $template)
    {
        if (ENVIRONMENT != 1 || SMTP_PASSWORD === '') {
            return false; // Sin SMTP configurado (o en local) no se envían correos
        }
        $emailCopia = !empty($data['emailCopia']) ? $data['emailCopia'] : "";
        ob_start();
        require("Views/Template/Email/" . $template . ".php");
        $mensaje = ob_get_clean();
        return sendWithPHPMailer($data['email'], $data['asunto'], $mensaje, $emailCopia);
    }

    function sendWithPHPMailer($to, $subject, $body, $bcc = "")
    {
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug  = 0;
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USER;
            $mail->Password   = SMTP_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = SMTP_PORT;

            $mail->setFrom(EMAIL_REMITENTE, NOMBRE_REMITENTE);
            $mail->addAddress($to);
            if (!empty($bcc)) {
                $mail->addBCC($bcc);
            }
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = $subject; // PHPMailer ya codifica el asunto en UTF-8
            $mail->Body    = $body;
            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }

    //Inicia sesión con cookies endurecidas (HttpOnly, SameSite y Secure bajo HTTPS)
    function startSecureSession(){
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                'lifetime' => 0,
                'path'     => '/',
                'secure'   => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
            session_start();
        }
    }

    //Límite de intentos fallidos (antifuerza bruta): máx. $max cada $minutos por IP+clave
    function loginThrottleFile(string $clave){
        return sys_get_temp_dir().'/mg_login_'.hash('sha256', ($_SERVER['REMOTE_ADDR'] ?? '').'|'.strtolower($clave)).'.json';
    }
    function loginBloqueado(string $clave, int $max = 5, int $minutos = 15){
        $f = loginThrottleFile($clave);
        $d = is_file($f) ? json_decode(@file_get_contents($f), true) : null;
        if (!$d || (time() - $d['t']) > $minutos * 60) { return false; }
        return $d['n'] >= $max;
    }
    function loginFallo(string $clave, int $minutos = 15){
        $f = loginThrottleFile($clave);
        $d = is_file($f) ? json_decode(@file_get_contents($f), true) : null;
        if (!$d || (time() - $d['t']) > $minutos * 60) { $d = ['n' => 0, 't' => time()]; }
        $d['n']++;
        @file_put_contents($f, json_encode($d), LOCK_EX);
    }
    function loginLimpiar(string $clave){
        @unlink(loginThrottleFile($clave));
    }

    //Genera el hash seguro de una contraseña (bcrypt/argon según PHP)
    function passwordHash(string $password){
        return password_hash($password, PASSWORD_DEFAULT);
    }

    //Valida que un archivo subido sea realmente una imagen (jpg/png/gif/webp) y de tamaño razonable
    function esImagenValida(array $file, int $maxBytes = 5242880){
        if (empty($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK || $file['size'] > $maxBytes) { return false; }
        $info = @getimagesize($file['tmp_name']);
        return $info !== false && in_array($info[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_WEBP], true);
    }

    function getPermisos(int $idmodulo){
        require_once ("Models/PermisosModel.php");
        $objPermisos = new PermisosModel();
        if(!empty($_SESSION['userData'])){
            $idrol = $_SESSION['userData']['idrol'];
            $arrPermisos = $objPermisos->permisosModulo($idrol);
            $permisos = '';
            $permisosMod = '';
            if(count($arrPermisos) > 0 ){
                $permisos = $arrPermisos;
                $permisosMod = isset($arrPermisos[$idmodulo]) ? $arrPermisos[$idmodulo] : "";
            }
            $_SESSION['permisos'] = $permisos;
            $_SESSION['permisosMod'] = $permisosMod;
        }
    }

    function sessionUser(int $idpersona){
        require_once ("Models/LoginModel.php");
        $objLogin = new LoginModel();
        $request = $objLogin->sessionLogin($idpersona);
        return $request;
    }

    function uploadImage(array $data, string $name){
        if(!esImagenValida($data)){ return false; }
        $destino = 'Assets/images/uploads/'.basename($name);
        return move_uploaded_file($data['tmp_name'], $destino);
    }

    function deleteFile(string $name){
        $name = basename($name); // evita rutas como ../../archivo
        $ruta = 'Assets/images/uploads/'.$name;
        if($name !== '' && is_file($ruta)){ @unlink($ruta); }
    }

    //Limpia un texto plano de formulario: espacios, caracteres nulos y etiquetas HTML.
    //(La protección contra SQL injection NO depende de esto: todas las consultas son preparadas.)
    function strClean($strCadena){
        $string = preg_replace(['/\s+/','/^\s|\s$/'],[' ',''], (string)$strCadena);
        $string = str_replace("\0", '', $string);
        $string = stripslashes(trim($string));
        return strip_tags($string);
    }

    //Para campos que SÍ llevan HTML (descripciones, contenido de páginas): deja solo etiquetas seguras
    function htmlSeguro($html){
        $permitidas = '<p><br><b><strong><i><em><u><s><ul><ol><li><h1><h2><h3><h4><h5><h6><a><img><span><div><blockquote><table><thead><tbody><tr><th><td><hr><small>';
        $html = strip_tags(str_replace("\0", '', (string)$html), $permitidas);
        $html = preg_replace('/\son[a-z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html);      // onclick=, onerror=...
        $html = preg_replace('/(href|src)\s*=\s*(["\'])\s*(javascript|data|vbscript):[^"\']*\2/i', '$1=$2#$2', $html);
        return trim($html);
    }

    //Escapa recursivamente todos los textos de un resultado (listas del panel que se pintan como HTML)
    function escaparFilas($datos){
        if(!is_array($datos)){ return $datos; }
        foreach($datos as $k => $v){
            $datos[$k] = is_array($v) ? escaparFilas($v) : (is_string($v) ? escapar($v) : $v);
        }
        return $datos;
    }

    //Código cifrado de un ítem del carrito: producto y (opcional) variante. Ej. "415:73"; sin variante, "415:0"
    function tokenItem(int $idproducto, int $idvariante = 0){
        return openssl_encrypt($idproducto.':'.$idvariante, METHODENCRIPT, KEY);
    }
    //Inverso de tokenItem(). Acepta también el formato antiguo (solo el id del producto). Devuelve [idproducto, idvariante]
    function decodeItem($token){
        $txt = is_string($token) ? openssl_decrypt($token, METHODENCRIPT, KEY) : false;
        if($txt === false || !preg_match('/^(\d+)(?::(\d+))?$/', $txt, $m)){ return [0, 0]; }
        return [(int)$m[1], (int)($m[2] ?? 0)];
    }
    //Variantes activas de varios productos en una sola consulta: [idproducto => ['n' => cantidad]]
    function infoVariantesLote(array $ids){
        $ids = array_values(array_unique(array_filter(array_map('intval', $ids))));
        if(!$ids){ return []; }
        $con = new Mysql();
        $filas = $con->select_all("SELECT productoid, COUNT(*) AS n FROM variante WHERE status = 1 AND stock > 0 AND productoid IN (".implode(',', array_fill(0, count($ids), '?')).") GROUP BY productoid", $ids);
        $out = [];
        foreach($filas as $f){ $out[(int)$f['productoid']] = ['n' => (int)$f['n']]; }
        return $out;
    }

    //Nombre del producto + su variante (si la tiene), ya escapado para HTML. $fila trae 'producto' y opcionalmente 'variante'
    function nombreItem(array $fila){
        $html = escapar($fila['producto'] ?? '');
        if(!empty($fila['variante'])){ $html .= '<br><small style="color:#777">'.escapar($fila['variante']).'</small>'; }
        return $html;
    }

    //---------- Antispam de formularios (contacto, suscripción) ----------
    //Ficha firmada con la hora en que se mostró el formulario. Un bot que envía datos directo, sin abrir la página, no la tiene.
    function formToken(){
        $t = time();
        return $t.'.'.hash_hmac('sha256', (string)$t, KEY);
    }
    //Válida si la firma es correcta y pasaron entre $minSeg segundos y $maxSeg desde que se mostró el formulario
    function formTokenValido($token, int $minSeg = 3, int $maxSeg = 7200){
        if(!is_string($token) || !preg_match('/^(\d{9,11})\.([a-f0-9]{64})$/', $token, $m)){ return false; }
        if(!hash_equals(hash_hmac('sha256', $m[1], KEY), $m[2])){ return false; }
        $edad = time() - (int)$m[1];
        return $edad >= $minSeg && $edad <= $maxSeg;
    }
    //Texto aleatorio típico de bots ("Npvvkmvof", "dYQXzSKKH"): palabras largas con 5+ consonantes seguidas (la y cuenta como consonante) o mayúsculas en medio.
    //Devuelve true si es basura. Con $estricto (nombres) basta una palabra; si no (mensajes) deben ser más de la mitad de las palabras largas.
    function pareceBasura($texto, bool $estricto = true){
        $largas = 0; $basura = 0;
        foreach(preg_split('/\s+/u', trim((string)$texto)) as $p){
            $p = preg_replace('/[^\p{L}]/u', '', $p);
            if(mb_strlen($p) < 8){ continue; }
            $largas++;
            if(preg_match('/[^aeiouáéíóúü]{5,}/iu', $p) || preg_match_all('/\p{Ll}\p{Lu}/u', $p) >= 2){ $basura++; }
        }
        if($basura === 0){ return false; }
        return $estricto ? true : ($basura / $largas) > 0.5;
    }
    //Dominios de correo de spammers conocidos en esta tienda (más cualquiera con "keywords" o "seo" en el nombre)
    function correoBloqueado($email){
        $dom = strtolower(substr(strrchr((string)$email, '@') ?: '', 1));
        $lista = array('jmailservice.com', 'dominatingkeywords.com', 'dominate-keywords.com', 'dominatebanners.com');
        return in_array($dom, $lista, true) || (bool)preg_match('/keywords|dominat|(^|[.-])seo([.-]|$)/', $dom);
    }
    //Frases del spam comercial en inglés (SEO, tráfico, clics...): dos o más coincidencias
    function textoSpam($texto){
        return preg_match_all('/\b(seo|ppc|traffic|backlinks?|keywords?|clicks|search engines?|google rankings?|top position|guaranteed)\b/i', (string)$texto) >= 2;
    }

    //Escapa un valor para imprimirlo en HTML
    function escapar($valor){
        return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
    }

    function clear_cadena(string $cadena){
        //Reemplazamos la A y a
        $cadena = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
        array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
        $cadena
        );
 
        //Reemplazamos la E y e
        $cadena = str_replace(
        array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
        array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
        $cadena );
 
        //Reemplazamos la I y i
        $cadena = str_replace(
        array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
        array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
        $cadena );
 
        //Reemplazamos la O y o
        $cadena = str_replace(
        array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
        array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
        $cadena );
 
        //Reemplazamos la U y u
        $cadena = str_replace(
        array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
        array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
        $cadena );
 
        //Reemplazamos la N, n, C y c
        $cadena = str_replace(
        array('Ñ', 'ñ', 'Ç', 'ç',',','.',';',':'),
        array('N', 'n', 'C', 'c','','','',''),
        $cadena
        );
        return $cadena;
    }
    //Genera una contraseña de 10 caracteres
	function passGenerator($length = 10)
    {
        $pass = "";
        $longitudPass=$length;
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $longitudCadena=strlen($cadena);

        for($i=1; $i<=$longitudPass; $i++)
        {
            $pos = rand(0,$longitudCadena-1);
            $pass .= substr($cadena,$pos,1);
        }
        return $pass;
    }
    //Genera un token
    function token()
    {
        $r1 = bin2hex(random_bytes(10));
        $r2 = bin2hex(random_bytes(10));
        $r3 = bin2hex(random_bytes(10));
        $r4 = bin2hex(random_bytes(10));
        $token = $r1.'-'.$r2.'-'.$r3.'-'.$r4;
        return $token;
    }
    //Formato para valores monetarios
    function formatMoney($cantidad){
        $cantidad = number_format($cantidad,2,SPD,SPM);
        return $cantidad;
    }
    
    function getTokenPaypal(){
        $payLogin = curl_init(URLPAYPAL."/v1/oauth2/token");
        curl_setopt($payLogin, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($payLogin, CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($payLogin, CURLOPT_USERPWD, IDCLIENTE.":".SECRET);
        curl_setopt($payLogin, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        $result = curl_exec($payLogin);
        $err = curl_error($payLogin);
        curl_close($payLogin);
        if($err){
            $request = "CURL Error #:" . $err;
        }else{
            $objData = json_decode($result);
             $request =  $objData->access_token;
        }
        return $request;
    }

    function CurlConnectionGet(string $ruta, ?string $contentType, ?string $token){
        $content_type = $contentType != null ? $contentType : "application/x-www-form-urlencoded";
        if($token != null){
            $arrHeader = array('Content-Type:'.$content_type,
                            'Authorization: Bearer '.$token);
        }else{
            $arrHeader = array('Content-Type:'.$content_type);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if($err){
            $request = "CURL Error #:" . $err;
        }else{
            $request = json_decode($result);
        }
        return $request;
    }

    function CurlConnectionPost(string $ruta, ?string $contentType, ?string $token){
        $content_type = $contentType != null ? $contentType : "application/x-www-form-urlencoded";
        if($token != null){
            $arrHeader = array('Content-Type:'.$content_type,
                            'Authorization: Bearer '.$token);
        }else{
            $arrHeader = array('Content-Type:'.$content_type);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if($err){
            $request = "CURL Error #:" . $err;
        }else{
            $request = json_decode($result);
        }
        return $request;
    }

    function Meses(){
        $meses = array("Enero", 
                      "Febrero", 
                      "Marzo", 
                      "Abril", 
                      "Mayo", 
                      "Junio", 
                      "Julio", 
                      "Agosto", 
                      "Septiembre", 
                      "Octubre", 
                      "Noviembre", 
                      "Diciembre");
        return $meses;
    }

    function getCatFooter(){
        require_once ("Models/CategoriasModel.php");
        $objCategoria = new CategoriasModel();
        $request = $objCategoria->getCategoriasFooter();
        return $request;
    }

    function getInfoPage(int $idpagina){
        require_once("Libraries/Core/Mysql.php");
        $con = new Mysql();
        $sql = "SELECT * FROM post WHERE idpost = $idpagina";
        $request = $con->select($sql);
        return $request;
    }

    function getPageRout(string $ruta){
        require_once("Libraries/Core/Mysql.php");
        $con = new Mysql();
        $sql = "SELECT * FROM post WHERE ruta = ? AND status != 0 "; $request = $con->select($sql, [$ruta]);
        if(!empty($request)){
            $request['portada'] = $request['portada'] != "" ? media()."/images/uploads/".$request['portada'] : "";
        }
        return $request;
    }

    function viewPage(int $idpagina){
        require_once("Libraries/Core/Mysql.php");
        $con = new Mysql();
        $sql = "SELECT * FROM post WHERE idpost = $idpagina ";
        $request = $con->select($sql);
        if( ($request['status'] == 2 AND isset($_SESSION['permisosMod']) AND $_SESSION['permisosMod']['u'] == true) OR $request['status'] == 1){
            return true;        
        }else{
            return false;
        }
    }
    
   
        function cleanUrl(string $cleanUrl) {
            // Reemplaza caracteres especiales y espacios por guiones
            $cleanUrl = preg_replace('~[^\pL\d]+~u', '-', $cleanUrl);
            // Quita tildes y ñ con una tabla propia (iconv//TRANSLIT depende del idioma del servidor y borraba las vocales con tilde)
            $cleanUrl = strtr($cleanUrl, ['á'=>'a','à'=>'a','ä'=>'a','â'=>'a','Á'=>'A','À'=>'A','Ä'=>'A','Â'=>'A',
                'é'=>'e','è'=>'e','ë'=>'e','ê'=>'e','É'=>'E','È'=>'E','Ë'=>'E','Ê'=>'E',
                'í'=>'i','ì'=>'i','ï'=>'i','î'=>'i','Í'=>'I','Ì'=>'I','Ï'=>'I','Î'=>'I',
                'ó'=>'o','ò'=>'o','ö'=>'o','ô'=>'o','Ó'=>'O','Ò'=>'O','Ö'=>'O','Ô'=>'O',
                'ú'=>'u','ù'=>'u','ü'=>'u','û'=>'u','Ú'=>'U','Ù'=>'U','Ü'=>'U','Û'=>'U',
                'ñ'=>'n','Ñ'=>'N','ç'=>'c','Ç'=>'C']);
            $cleanUrl = preg_replace('~[^-\w]+~', '', $cleanUrl);
            $cleanUrl = trim($cleanUrl, '-');
            $cleanUrl = preg_replace('~-+~', '-', $cleanUrl);
            $cleanUrl = strtolower($cleanUrl);
        
            if (empty($cleanUrl)) {
                return 'n-a';
            }
        
            return $cleanUrl;
        }



 ?>