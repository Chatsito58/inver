<?php
/**
 * Modelo para la tabla `pago`.
 *
 * Métodos disponibles:
 * - crear(array $datos): int
 * - obtenerPorId(int $id): ?array
 * - actualizar(int $id, array $datos): bool
 * - eliminar(int $id): bool
 * - obtenerTodos(): array
 */


require_once __DIR__ . '/conexion.php';

class PagoModelo
{
    public static function crear(array $datos): int
    {
        $pdo = Conexion::getPDO();
        $cols = array_keys($datos);
        $placeholders = implode(',', array_fill(0, count($cols), '?'));
        $sql = 'INSERT INTO pago (' . implode(',', $cols) . ') VALUES (' . $placeholders . ')';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array_values($datos));
        return (int) $pdo->lastInsertId();
    }

    public static function obtenerPorId(int $id): ?array
    {
        $pdo = Conexion::getPDO();
        $stmt = $pdo->prepare('SELECT * FROM pago WHERE id = ?');
        $stmt->execute([$id]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

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
        $sql = 'UPDATE pago SET ' . implode(',', $sets) . ' WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public static function eliminar(int $id): bool
    {
        $pdo = Conexion::getPDO();
        $stmt = $pdo->prepare('DELETE FROM pago WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public static function obtenerTodos(): array
    {
        $pdo = Conexion::getPDO();
        $stmt = $pdo->query('SELECT * FROM pago');
        return $stmt->fetchAll();
    }
}

?>
