<?php
/**
 * Migración 001: variantes de producto (color, talla, medidas...).
 *
 * Uso (desde la raíz del proyecto):   php database/migraciones/001_variantes.php
 * Es seguro ejecutarla varias veces: solo crea lo que falta.
 *
 *  - tabla `variante`: cada "item" de un producto, con sus atributos, stock y precio opcional.
 *  - detalle_pedido.varianteid / variante: qué variante se compró (la etiqueta queda guardada como texto).
 *  - triggers ActualizarStock / DevolverStock: además del producto, descuentan/devuelven el stock de la variante.
 */
if (PHP_SAPI !== 'cli') { http_response_code(403); exit('Solo se ejecuta por línea de comandos.'); }
chdir(dirname(__DIR__, 2));
require_once 'Config/Config.php';

try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (PDOException $e) {
    fwrite(STDERR, "No se pudo conectar a la base de datos: " . $e->getMessage() . "\n");
    exit(1);
}

function existeColumna(PDO $pdo, string $tabla, string $columna): bool {
    $q = $pdo->prepare('SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = ? AND column_name = ?');
    $q->execute([$tabla, $columna]);
    return (int)$q->fetchColumn() > 0;
}

// 1) Tabla de variantes
$pdo->exec("CREATE TABLE IF NOT EXISTS variante (
    idvariante   BIGINT(20) NOT NULL AUTO_INCREMENT,
    productoid   BIGINT(20) NOT NULL,
    atributos    TEXT NOT NULL COMMENT 'JSON, ej. {\"Color\":\"Rojo\",\"Talla\":\"M\"}',
    etiqueta     VARCHAR(255) NOT NULL COMMENT 'Texto para mostrar, ej. Rojo / M',
    codigo       VARCHAR(50) DEFAULT NULL,
    precio       DECIMAL(11,2) DEFAULT NULL COMMENT 'NULL = usa el precio del producto',
    stock        INT(11) NOT NULL DEFAULT 0,
    status       INT(11) NOT NULL DEFAULT 1,
    datecreated  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idvariante),
    KEY productoid (productoid),
    CONSTRAINT variante_ibfk_1 FOREIGN KEY (productoid) REFERENCES producto (idproducto) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
echo "tabla variante: ok\n";

// 2) Qué variante se compró en cada pedido
foreach (['detalle_pedido', 'detalle_temp'] as $tabla) {
    if (!existeColumna($pdo, $tabla, 'varianteid')) {
        $pdo->exec("ALTER TABLE $tabla ADD COLUMN varianteid BIGINT(20) DEFAULT NULL, ADD COLUMN variante VARCHAR(255) DEFAULT NULL");
        echo "$tabla: columnas agregadas\n";
    } else {
        echo "$tabla: ya tenía las columnas\n";
    }
}

// 3) Triggers de stock (producto + variante)
$pdo->exec('DROP TRIGGER IF EXISTS ActualizarStock');
$pdo->exec("CREATE TRIGGER ActualizarStock AFTER UPDATE ON pedido FOR EACH ROW BEGIN
    IF NEW.status = 'completo' AND OLD.status <> 'completo' THEN
        UPDATE producto p
        JOIN (SELECT productoid, SUM(cantidad) AS total_cantidad
              FROM detalle_pedido WHERE pedidoid = NEW.idpedido GROUP BY productoid) AS dp
          ON p.idproducto = dp.productoid
        SET p.stock = p.stock - dp.total_cantidad;
        UPDATE variante v
        JOIN (SELECT varianteid, SUM(cantidad) AS total_cantidad
              FROM detalle_pedido WHERE pedidoid = NEW.idpedido AND varianteid IS NOT NULL GROUP BY varianteid) AS dv
          ON v.idvariante = dv.varianteid
        SET v.stock = v.stock - dv.total_cantidad;
    END IF;
END");
$pdo->exec('DROP TRIGGER IF EXISTS DevolverStock');
$pdo->exec("CREATE TRIGGER DevolverStock AFTER UPDATE ON pedido FOR EACH ROW BEGIN
    IF NEW.status = 'Reembolsado' AND OLD.status <> 'Reembolsado' THEN
        UPDATE producto p
        JOIN (SELECT productoid, SUM(cantidad) AS total_cantidad
              FROM detalle_pedido WHERE pedidoid = NEW.idpedido GROUP BY productoid) AS dp
          ON p.idproducto = dp.productoid
        SET p.stock = p.stock + dp.total_cantidad;
        UPDATE variante v
        JOIN (SELECT varianteid, SUM(cantidad) AS total_cantidad
              FROM detalle_pedido WHERE pedidoid = NEW.idpedido AND varianteid IS NOT NULL GROUP BY varianteid) AS dv
          ON v.idvariante = dv.varianteid
        SET v.stock = v.stock + dv.total_cantidad;
    END IF;
END");
echo "triggers de stock: ok\n";
echo "Migración 001 terminada.\n";
