<?php
class Conexion {
    private $conect;

    public function __construct() {
        $connectionString = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
        try {
            $this->conect = new PDO($connectionString, DB_USER, DB_PASSWORD, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false, // consultas preparadas reales
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch(PDOException $e) {
            // El detalle (usuario, host) va al log, nunca a la pantalla del visitante
            error_log("Error de conexión a la base de datos: " . $e->getMessage());
            http_response_code(503);
            exit("El sitio no está disponible por el momento. Intenta de nuevo en unos minutos.");
        }
    }

    public function conect() {
        return $this->conect;
    }
}
