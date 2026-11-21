<?php
/**
 * Ajustes de la tienda editables desde el panel (Configuración). Se guardan en la tabla `configuracion`.
 *
 *  - Config/Config.php conserva SOLO lo técnico (conexión a la base de datos, clave de cifrado, dirección del sitio...).
 *  - Todo lo demás (nombre, contacto, correo, PayPal, moneda, portada...) vive aquí y se define como constante al iniciar
 *    cada petición (Ajustes::cargar()), de modo que el resto del sistema sigue usando NOMBRE_EMPESA, TELEMPRESA, etc.
 *  - Las contraseñas (SMTP, PayPal) se guardan cifradas con AES-256-GCM usando la clave KEY de Config.php.
 */
class Ajustes
{
    public static $fijosEnArchivo = [];   // ajustes que siguen escritos en Config.php (el panel no los puede cambiar)
    private static $db = null;

    public static function grupos(): array
    {
        return [
            'tienda'   => ['Datos de la tienda', 'fas fa-store', 'Nombre y descripción que ve el cliente.'],
            'contacto' => ['Contacto y redes', 'fas fa-address-book', 'Aparece en el pie de página y en los correos.'],
            'moneda'   => ['Moneda y envío', 'fas fa-coins', 'Cómo se muestran los precios y cuánto cuesta el envío.'],
            'correo'   => ['Correo saliente (SMTP)', 'fas fa-envelope', 'Para enviar correos de bienvenida, pedidos y contacto. Si lo dejas vacío, la tienda funciona pero no envía correos.'],
            'pagos'    => ['Pagos con PayPal', 'fab fa-paypal', 'Sin credenciales, PayPal queda desactivado (siguen disponibles efectivo y transferencia).'],
            'portada'  => ['Portada y listados', 'fas fa-images', 'Qué categorías salen en el banner y en el pie, y cuántos productos por página.'],
        ];
    }

    /** clave => [grupo, etiqueta, tipo, valor por defecto, ayuda, opciones/límites] */
    public static function campos(): array
    {
        return [
            'NOMBRE_EMPESA'     => ['tienda',   'Nombre de la tienda', 'texto', 'M&G Store', 'Sale en el encabezado, los correos y las facturas.', ['max' => 80, 'req' => true]],
            'DESCRIPCION'       => ['tienda',   'Descripción corta', 'texto_largo', 'La mejor tienda en línea con artículos de moda.', 'Se usa al compartir la tienda en redes y en buscadores.', ['max' => 300]],
            'SHAREDHASH'        => ['tienda',   'Etiqueta para compartir (#)', 'texto', 'Mi Tienda', 'Texto del hashtag al compartir un producto en Twitter.', ['max' => 40]],
            'DIRECCION'         => ['contacto', 'Dirección', 'texto', 'Ciudad, País', '', ['max' => 150]],
            'TELEMPRESA'        => ['contacto', 'Teléfono', 'telefono', '+(000)00000000', '', ['max' => 30]],
            'WHATSAPP'          => ['contacto', 'WhatsApp (con código de país, solo números)', 'telefono', '+00000000000', 'Ej. +50499999999. El botón verde de la tienda usa este número.', ['max' => 30]],
            'EMAIL_EMPRESA'     => ['contacto', 'Correo de la tienda', 'email', 'tienda@ejemplo.com', 'Se muestra al público.', []],
            'EMAIL_CONTACTO'    => ['contacto', 'Correo que recibe los mensajes del formulario de contacto', 'email', 'tienda@ejemplo.com', '', []],
            'EMAIL_SUSCRIPCION' => ['contacto', 'Correo que recibe los avisos de nuevos suscriptores', 'email', 'tienda@ejemplo.com', '', []],
            'EMAIL_PEDIDOS'     => ['contacto', 'Correo que recibe copia de cada pedido', 'email', 'pedidos@ejemplo.com', '', []],
            'FACEBOOK'          => ['contacto', 'Facebook (enlace)', 'url', 'https://www.facebook.com/tu-pagina', 'Déjalo vacío si no tienes.', ['max' => 200]],
            'INSTAGRAM'         => ['contacto', 'Instagram (enlace)', 'url', 'https://www.instagram.com/tu-cuenta/', 'Déjalo vacío si no tienes.', ['max' => 200]],
            'SMONEY'            => ['moneda',   'Símbolo de la moneda', 'texto', 'L', 'Ej. L, $, €', ['max' => 5, 'req' => true]],
            'CURRENCY'          => ['moneda',   'Código de la moneda (3 letras)', 'moneda', 'LPS', 'Ej. LPS, USD. PayPal lo usa para cobrar.', ['req' => true]],
            'FORMATO_NUMERO'    => ['moneda',   'Formato de los precios', 'select', '1,234.56', '', ['opciones' => ['1,234.56' => '1,234.56  (coma para miles, punto para decimales)', '1.234,56' => '1.234,56  (punto para miles, coma para decimales)']]],
            'COSTOENVIO'        => ['moneda',   'Costo de envío', 'decimal', 0, '0 = envío sin costo.', ['min' => 0, 'max' => 100000]],
            'SMTP_HOST'         => ['correo',   'Servidor SMTP', 'host', 'mail.ejemplo.com', 'Te lo da tu proveedor de correo o de hosting.', []],
            'SMTP_PORT'         => ['correo',   'Puerto', 'entero', 465, '465 (SSL) es lo más común.', ['min' => 1, 'max' => 65535]],
            'SMTP_USER'         => ['correo',   'Usuario (normalmente el correo completo)', 'texto', 'tienda@ejemplo.com', '', ['max' => 120]],
            'SMTP_PASSWORD'     => ['correo',   'Contraseña del correo', 'secreto', '', 'Se guarda cifrada. Déjala vacía para no cambiarla.', []],
            'EMAIL_REMITENTE'   => ['correo',   'Correo que aparece como remitente', 'email', 'tienda@ejemplo.com', 'Normalmente el mismo del usuario SMTP.', []],
            'PAYPAL_MODO'       => ['pagos',    'Modo de PayPal', 'select', 'sandbox', 'Usa "Pruebas" hasta que todo funcione; luego cambia a "Real".', ['opciones' => ['sandbox' => 'Pruebas (sandbox: no se cobra dinero real)', 'produccion' => 'Real (se cobra dinero real)']]],
            'IDCLIENTE'         => ['pagos',    'PayPal Client ID', 'texto', '', 'Lo encuentras en developer.paypal.com → Apps & Credentials.', ['max' => 200]],
            'SECRET'            => ['pagos',    'PayPal Secret', 'secreto', '', 'Se guarda cifrado. Déjalo vacío para no cambiarlo.', []],
            'CAT_SLIDER'        => ['portada',  'Categorías del banner principal (carrusel)', 'categorias', '1,3,4,5,6,7,8,9', 'Cada categoría marcada es una imagen del carrusel.', []],
            'CAT_BANNER'        => ['portada',  'Categorías destacadas en tarjetas (recomendado 3)', 'categorias', '6,7,8', '', []],
            'CAT_FOOTER'        => ['portada',  'Categorías en el pie de página', 'categorias', '1,3,4,5,6,7,8,9', '', []],
            'CANTPORDHOME'      => ['portada',  'Productos en la portada', 'entero', 12, '', ['min' => 4, 'max' => 48]],
            'PROPORPAGINA'      => ['portada',  'Productos por página en la tienda', 'entero', 12, '', ['min' => 4, 'max' => 48]],
            'PROCATEGORIA'      => ['portada',  'Productos por página en una categoría', 'entero', 12, '', ['min' => 4, 'max' => 48]],
            'PROBUSCAR'         => ['portada',  'Productos por página en la búsqueda', 'entero', 12, '', ['min' => 4, 'max' => 48]],
        ];
    }

    // ------------------------------------------------------------------ cifrado de contraseñas
    private static function llave(): string { return hash('sha256', KEY . '|ajustes', true); }

    public static function cifrar(string $texto): string
    {
        if ($texto === '') { return ''; }
        $iv = random_bytes(12);
        $c = openssl_encrypt($texto, 'aes-256-gcm', self::llave(), OPENSSL_RAW_DATA, $iv, $tag);
        return 'v1:' . base64_encode($iv . $tag . $c);
    }

    public static function descifrar(string $guardado): string
    {
        if (strncmp($guardado, 'v1:', 3) !== 0) { return ''; }
        $b = base64_decode(substr($guardado, 3), true);
        if ($b === false || strlen($b) < 29) { return ''; }
        $r = openssl_decrypt(substr($b, 28), 'aes-256-gcm', self::llave(), OPENSSL_RAW_DATA, substr($b, 0, 12), substr($b, 12, 16));
        return $r === false ? '' : $r;   // si cambió la clave KEY, no se puede leer: se trata como vacío
    }

    // ------------------------------------------------------------------ lectura / carga
    private static function pdo()
    {
        try {
            return new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        } catch (Throwable $e) { return null; }
    }

    /** clave => valor tal como está guardado (los secretos siguen cifrados) */
    public static function leerDB(bool $recargar = false): array
    {
        if (self::$db !== null && !$recargar) { return self::$db; }
        self::$db = [];
        $pdo = self::pdo();
        if ($pdo) {
            try { foreach ($pdo->query('SELECT clave, valor FROM configuracion') as $f) { self::$db[$f['clave']] = (string)$f['valor']; } }
            catch (Throwable $e) { /* la tabla aún no existe (falta la migración): se usan los valores por defecto */ }
        }
        return self::$db;
    }

    private static function convertir(string $tipo, $v)
    {
        if ($tipo === 'entero') { return (int)$v; }
        if ($tipo === 'decimal') { return (float)$v; }
        if ($tipo === 'categorias') { $ids = array_filter(array_map('intval', explode(',', (string)$v))); return $ids ? implode(',', $ids) : '0'; }
        return (string)$v;
    }

    /** Define cada ajuste como constante (valor guardado, o el predeterminado si no hay). Se llama una vez al iniciar. */
    public static function cargar(): void
    {
        $db = self::leerDB();
        foreach (self::campos() as $k => [$g, $et, $tipo, $defecto]) {
            if (defined($k)) { self::$fijosEnArchivo[] = $k; continue; }   // sigue fijo en Config.php: gana el archivo
            $v = array_key_exists($k, $db) ? ($tipo === 'secreto' ? self::descifrar($db[$k]) : $db[$k]) : $defecto;
            define($k, self::convertir($tipo, $v));
        }
        if (!defined('MCONFIGURACION')) { define('MCONFIGURACION', 10); }   // número del módulo en la tabla `modulo`
        if (!defined('SPD')) { define('SPD', FORMATO_NUMERO === '1.234,56' ? ',' : '.'); }
        if (!defined('SPM')) { define('SPM', FORMATO_NUMERO === '1.234,56' ? '.' : ','); }
        if (!defined('NOMBRE_REMITENTE')) { define('NOMBRE_REMITENTE', NOMBRE_EMPESA); }
        if (!defined('WEB_EMPRESA')) { define('WEB_EMPRESA', BASE_URL); }
        if (!defined('URLPAYPAL')) { define('URLPAYPAL', PAYPAL_MODO === 'produccion' ? 'https://api-m.paypal.com' : 'https://api-m.sandbox.paypal.com'); }
    }

    /** Valores para mostrar en el formulario. Los secretos NUNCA se devuelven: solo si hay uno guardado. */
    public static function valoresParaFormulario(): array
    {
        $out = [];
        foreach (self::campos() as $k => [$g, $et, $tipo]) {
            if ($tipo === 'secreto') { $out[$k] = ['tiene' => constant($k) !== '']; continue; }
            $out[$k] = constant($k);
        }
        return $out;
    }

    // ------------------------------------------------------------------ guardado con validación
    /** Devuelve [true, []] si todo se guardó, o [false, [clave => mensaje]] sin guardar nada. */
    public static function guardar(array $entrada, array $idsCategoriasValidos): array
    {
        $limpios = []; $errores = [];
        foreach (self::campos() as $k => [$g, $etiqueta, $tipo, $defecto, $ayuda, $op]) {
            if (!array_key_exists($k, $entrada)) { continue; }          // solo se actualiza lo que llegó
            $v = $entrada[$k];
            if ($tipo === 'categorias') {
                $ids = array_values(array_unique(array_map('intval', is_array($v) ? $v : [])));
                $ids = array_values(array_filter($ids, fn($i) => in_array($i, $idsCategoriasValidos, true)));
                $limpios[$k] = implode(',', $ids); continue;
            }
            if (is_array($v)) { $errores[$k] = 'Valor no válido.'; continue; }
            $v = trim((string)$v);
            if ($tipo !== 'secreto') { $v = trim(strip_tags($v)); }
            if (!empty($op['req']) && $v === '') { $errores[$k] = 'Este dato es obligatorio.'; continue; }
            if ($v === '' && $tipo === 'secreto') { continue; }              // contraseña vacía = no cambiarla (nunca se borra por accidente)
            if ($v === '' && $tipo !== 'select') { $limpios[$k] = ($tipo === 'entero' || $tipo === 'decimal') ? (string)$defecto : ''; continue; }
            if (isset($op['max']) && ($tipo === 'texto' || $tipo === 'texto_largo' || $tipo === 'telefono' || $tipo === 'url') && mb_strlen($v) > $op['max']) { $errores[$k] = 'Máximo ' . $op['max'] . ' caracteres.'; continue; }
            switch ($tipo) {
                case 'email':    if (!filter_var($v, FILTER_VALIDATE_EMAIL) || strlen($v) > 120) { $errores[$k] = 'Escribe un correo válido.'; continue 2; } break;
                case 'telefono': if (!preg_match('/^[0-9+()\- .]{0,30}$/', $v)) { $errores[$k] = 'Solo números, espacios y + ( ) -'; continue 2; } break;
                case 'url':      if (!preg_match('~^https?://[^\s<>"\']{3,}$~i', $v)) { $errores[$k] = 'Escribe un enlace que empiece por http:// o https://'; continue 2; } break;
                case 'moneda':   $v = strtoupper($v); if (!preg_match('/^[A-Z]{3}$/', $v)) { $errores[$k] = 'Son 3 letras, por ejemplo LPS o USD.'; continue 2; } break;
                case 'host':     if (!preg_match('/^[A-Za-z0-9.\-]{0,120}$/', $v)) { $errores[$k] = 'Nombre de servidor no válido.'; continue 2; } break;
                case 'select':   if (!isset($op['opciones'][$v])) { $errores[$k] = 'Opción no válida.'; continue 2; } break;
                case 'entero':   if (!preg_match('/^\d{1,6}$/', $v) || (int)$v < $op['min'] || (int)$v > $op['max']) { $errores[$k] = 'Número entre ' . $op['min'] . ' y ' . $op['max'] . '.'; continue 2; } break;
                case 'decimal':  if (!is_numeric($v) || (float)$v < $op['min'] || (float)$v > $op['max']) { $errores[$k] = 'Número entre ' . $op['min'] . ' y ' . $op['max'] . '.'; continue 2; } $v = (string)round((float)$v, 2); break;
                case 'secreto':  if ($v === '') { continue 2; }                       // vacío = no cambiar
                                 if (mb_strlen($v) > 200) { $errores[$k] = 'Demasiado largo.'; continue 2; }
                                 $v = self::cifrar($v); break;
            }
            $limpios[$k] = $v;
        }
        if ($errores) { return [false, $errores]; }
        $pdo = self::pdo();
        if (!$pdo) { return [false, ['_' => 'No hay conexión con la base de datos.']]; }
        try {
            $pdo->beginTransaction();
            $q = $pdo->prepare('INSERT INTO configuracion(clave, valor) VALUES(?, ?) ON DUPLICATE KEY UPDATE valor = VALUES(valor)');
            foreach ($limpios as $k => $v) { $q->execute([$k, $v]); }
            $pdo->commit();
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) { $pdo->rollBack(); }
            error_log('Ajustes::guardar: ' . $e->getMessage());
            return [false, ['_' => 'No fue posible guardar. ¿Se ejecutó la migración 002?']];
        }
        self::$db = null;
        return [true, []];
    }
}
