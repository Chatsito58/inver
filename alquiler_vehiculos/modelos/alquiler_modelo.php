<?php
/**
 * Modelo para operaciones sobre la tabla `alquiler`.
 *
 * Metodos disponibles:
 * - crear(array $datos): int    Inserta un registro y devuelve el ID generado.
 * - obtenerPorId(int $id): ?array    Obtiene un alquiler por su ID.
 * - actualizar(int $id, array $datos): bool    Actualiza los campos indicados.
 * - eliminar(int $id): bool    Elimina el registro especificado.
 * - obtenerTodos(): array    Devuelve todos los alquileres.
 */

require_once 'modelos/conexion.php';

class AlquilerModelo
{
    /**
     * Inserta un nuevo alquiler.
     *
     * @param array $datos Asociacion columna => valor.
     * @return int ID generado
     */
    public static function crear(array $datos): int
    {
        $pdo = Conexion::getPDO();
        $columnas = array_keys($datos);
        $placeholders = implode(',', array_fill(0, count($columnas), '?'));
        $sql = 'INSERT INTO alquiler (' . implode(',', $columnas) . ') VALUES (' . $placeholders . ')';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array_values($datos));
        return (int) $pdo->lastInsertId();
    }

    /**
     * Obtiene un alquiler por ID.
     */
    public static function obtenerPorId(int $id): ?array
    {
        $pdo = Conexion::getPDO();
        $stmt = $pdo->prepare('SELECT * FROM alquiler WHERE id = ?');
        $stmt->execute([$id]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

    /**
     * Actualiza los campos de un alquiler.
     */
    public static function actualizar(int $id, array $datos): bool
    {
        if (empty($datos)) {
            return false;
        }
        $pdo = Conexion::getPDO();
        $sets = [];
        $params = [];
        foreach ($datos as $col => $val) {
            $sets[] = "$col = ?";
            $params[] = $val;
        }
        $params[] = $id;
        $sql = 'UPDATE alquiler SET ' . implode(',', $sets) . ' WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Elimina un alquiler por ID.
     */
    public static function eliminar(int $id): bool
    {
        $pdo = Conexion::getPDO();
        $stmt = $pdo->prepare('DELETE FROM alquiler WHERE id = ?');
        return $stmt->execute([$id]);
    }

    /**
     * Devuelve todos los alquileres almacenados.
     */
    public static function obtenerTodos(): array
    {
        $pdo = Conexion::getPDO();
        $stmt = $pdo->query('SELECT * FROM alquiler');
        return $stmt->fetchAll();
    }
}

?>
