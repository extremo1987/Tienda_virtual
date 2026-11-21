<?php

/**
 * Acceso a datos. Todas las consultas se ejecutan como preparadas:
 * los valores del usuario van SIEMPRE en $arrValues con marcadores "?",
 * nunca pegados dentro del texto SQL.
 */
class Mysql extends Conexion
{
    private $conexion;

    function __construct()
    {
        $this->conexion = (new Conexion())->conect();
    }

    //Errores de datos del usuario (texto demasiado largo, valor fuera de rango, clave duplicada): se registran y se devuelve fallo
    private function datoRechazado(PDOException $e)
    {
        $c = $e->errorInfo[0] ?? ''; $n = (int)($e->errorInfo[1] ?? 0);
        // 1366 valor incorrecto, 1265/1264 dato truncado o fuera de rango, 1406 texto muy largo, 1292 fecha inválida, 1062 duplicado, 1451/1452 relación
        if (in_array($c, ['22001', '22003', '22007', '22P02', '23000'], true) || in_array($n, [1366, 1265, 1264, 1406, 1292, 1062, 1451, 1452], true)) {
            error_log('Dato rechazado por la BD: ' . $e->getMessage()); return true;
        }
        return false;
    }
    //Insertar un registro (devuelve el id insertado o 0)
    public function insert(string $query, array $arrValues = [])
    {
        try {
            $insert = $this->conexion->prepare($query);
            return $insert->execute($arrValues) ? $this->conexion->lastInsertId() : 0;
        } catch (PDOException $e) { if ($this->datoRechazado($e)) { return 0; } throw $e; }
    }
    //Busca un registro
    public function select(string $query, array $arrValues = [])
    {
        $result = $this->conexion->prepare($query);
        $result->execute($arrValues);
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    //Devuelve todos los registros
    public function select_all(string $query, array $arrValues = [])
    {
        $result = $this->conexion->prepare($query);
        $result->execute($arrValues);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    //Actualiza registros
    public function update(string $query, array $arrValues = [])
    {
        try {
            $update = $this->conexion->prepare($query);
            return $update->execute($arrValues);
        } catch (PDOException $e) { if ($this->datoRechazado($e)) { return false; } throw $e; }
    }
    //Transacciones (varias escrituras que deben guardarse todas o ninguna)
    public function beginTransaction() { return $this->conexion->beginTransaction(); }
    public function commit() { return $this->conexion->commit(); }
    public function rollBack() { return $this->conexion->inTransaction() ? $this->conexion->rollBack() : false; }
    //Elimina registros
    public function delete(string $query, array $arrValues = [])
    {
        $result = $this->conexion->prepare($query);
        return $result->execute($arrValues);
    }
}
