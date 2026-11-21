<?php
/**
 * Migración 002: módulo "Configuración" del panel.
 *
 *   php database/migraciones/002_configuracion.php               -> hace todo lo siguiente
 *   php database/migraciones/002_configuracion.php --sin-limpiar -> no reescribe Config/Config.php
 *
 *  1) Crea la tabla `configuracion` (clave/valor).
 *  2) Registra el módulo 10 "Configuración" y le da todos los permisos al rol Administrador.
 *  3) Pasa a la base de datos los ajustes que hoy están escritos en Config/Config.php (las contraseñas, cifradas).
 *  4) Quita esos ajustes de Config/Config.php (deja copia de respaldo) para que se editen desde el panel.
 * Es seguro ejecutarla varias veces.
 */
if (PHP_SAPI !== 'cli') { http_response_code(403); exit('Solo se ejecuta por línea de comandos.'); }
chdir(dirname(__DIR__, 2));
require_once 'Config/Config.php';          // OJO: aquí NO se carga Ajustes::cargar(); se leen los valores tal como están en el archivo
require_once 'Libraries/Core/Ajustes.php';

try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) { fwrite(STDERR, "No se pudo conectar a la base de datos: " . $e->getMessage() . "\n"); exit(1); }

// 1) tabla
$pdo->exec("CREATE TABLE IF NOT EXISTS configuracion (
    clave   VARCHAR(60) NOT NULL,
    valor   TEXT DEFAULT NULL,
    updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (clave)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
echo "tabla configuracion: ok\n";

// 2) módulo y permisos
$existe = $pdo->query("SELECT COUNT(*) FROM modulo WHERE idmodulo = 10")->fetchColumn();
if (!$existe) { $pdo->exec("INSERT INTO modulo(idmodulo, titulo, descripcion, status) VALUES(10, 'Configuración', 'Ajustes de la tienda', 1)"); echo "módulo 10 Configuración: creado\n"; }
else { echo "módulo 10 Configuración: ya existía\n"; }
$tiene = $pdo->query("SELECT COUNT(*) FROM permisos WHERE rolid = " . (int)RADMINISTRADOR . " AND moduloid = 10")->fetchColumn();
if (!$tiene) { $pdo->exec("INSERT INTO permisos(rolid, moduloid, r, w, u, d) VALUES(" . (int)RADMINISTRADOR . ", 10, 1, 1, 1, 1)"); echo "permisos del administrador sobre Configuración: creados\n"; }

// 3) valores que hoy están en Config.php -> base de datos (sin pisar lo que ya esté guardado)
$hay = array_column($pdo->query('SELECT clave FROM configuracion')->fetchAll(PDO::FETCH_ASSOC), 'clave');
$ins = $pdo->prepare('INSERT INTO configuracion(clave, valor) VALUES(?, ?)');
$importados = [];
$mapa = [];   // clave del panel => valor tomado del archivo
foreach (Ajustes::campos() as $k => [$g, $et, $tipo]) { if (defined($k)) { $mapa[$k] = constant($k); } }
if (defined('SPD')) { $mapa['FORMATO_NUMERO'] = (SPD === ',') ? '1.234,56' : '1,234.56'; }
if (defined('URLPAYPAL')) { $mapa['PAYPAL_MODO'] = (strpos(URLPAYPAL, 'sandbox') === false) ? 'produccion' : 'sandbox'; }
foreach ($mapa as $k => $v) {
    if (in_array($k, $hay, true)) { continue; }
    $tipo = Ajustes::campos()[$k][2] ?? 'texto';
    $ins->execute([$k, $tipo === 'secreto' ? Ajustes::cifrar((string)$v) : (string)$v]);
    $importados[] = $k;
}
echo $importados ? "ajustes pasados de Config.php a la base: " . count($importados) . " (" . implode(', ', $importados) . ")\n" : "ajustes en Config.php por importar: ninguno\n";

// 4) limpiar Config.php
if (in_array('--sin-limpiar', $argv, true)) { echo "Config.php: no se tocó (--sin-limpiar)\n"; exit(0); }
$archivo = 'Config/Config.php';
$txt = file_get_contents($archivo);
$crlf = strpos($txt, "\r\n") !== false;
$claves = array_merge(array_keys(Ajustes::campos()), ['SPD', 'SPM', 'URLPAYPAL', 'NOMBRE_REMITENTE', 'WEB_EMPRESA']);
$cambiado = false;
$lineas = preg_split('/\r?\n/', $txt);
$salida = [];
foreach ($lineas as $l) {
    if (preg_match('/^\s*(\/\/\s*)?const\s+(' . implode('|', $claves) . ')\s*=/', $l)) { $cambiado = true; continue; }
    if (preg_match('/^\s*\/\/\s*(SANDBOX PAYPAL|LIVE PAYPAL|Api PayPal|Deliminadores decimal|Simbolo de moneda|Datos envio de correo|Servidor SMTP|Datos Empresa|Para envío de correo|Envío|Productos por página|REDES SOCIALES)/i', $l)) { $cambiado = true; continue; }
    $salida[] = $l;
}
$nuevo = implode($crlf ? "\r\n" : "\n", $salida);
$nuevo = preg_replace('/(\r?\n){3,}/', $crlf ? "\r\n\r\n" : "\n\n", $nuevo);
if (strpos($nuevo, 'MCONFIGURACION') === false) { $nuevo = preg_replace('/(const MDPAGINAS = 9;)/', '$1' . ($crlf ? "\r\n" : "\n") . "\tconst MCONFIGURACION = 10;", $nuevo, 1, $n); $cambiado = $cambiado || $n; }
if (strpos($nuevo, 'se editan en el panel') === false) {
    $nuevo = preg_replace('/<\?php\s*/', '<?php' . ($crlf ? "\r\n" : "\n") . "\t// Aquí queda solo lo técnico. Nombre, contacto, correo, PayPal, moneda y portada se editan en el panel: Configuración." . ($crlf ? "\r\n" : "\n"), $nuevo, 1);
    $cambiado = true;
}
if ($cambiado) {
    copy($archivo, $archivo . '.bak-' . date('Ymd-His'));
    file_put_contents($archivo, $nuevo);
    exec('php -l ' . escapeshellarg($archivo) . ' 2>&1', $o, $rc);
    if ($rc !== 0) { copy($archivo . '.bak-' . date('Ymd-His'), $archivo); fwrite(STDERR, "Config.php quedó con error de sintaxis; se restauró la copia.\n"); exit(1); }
    echo "Config.php: ajustes retirados (copia de respaldo creada); ahora se editan en el panel\n";
} else { echo "Config.php: ya estaba limpio\n"; }
echo "Migración 002 terminada.\n";
