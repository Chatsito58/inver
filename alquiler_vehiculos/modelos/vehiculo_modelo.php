<?php
class VehiculoModelo {
    private static function getPDO() {
        require_once 'conexion.php';
        return Conexion::getPDO();
    }

    public static function crear(array $datos): bool {
        $pdo = self::getPDO();
        $sql = "INSERT INTO vehiculo (placa, marca, modelo, kilometraje, fecha_adquisicion, proveedor_id, reserva_id, tipo_vehiculo_id, id_sede) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $datos['placa'],
            $datos['marca'],
            $datos['modelo'],
            $datos['kilometraje'],
            $datos['fecha_adquisicion'],
            $datos['proveedor_id'],
            $datos['reserva_id'],
            $datos['tipo_vehiculo_id'],
            $datos['id_sede']
        ]);
    }

    public static function obtenerPorPlaca(string $placa): ?array {
        $pdo = self::getPDO();
        $sql = "SELECT * FROM vehiculo WHERE placa = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$placa]);
        $vehiculo = $stmt->fetch(PDO::FETCH_ASSOC);
        return $vehiculo ?: null;
    }

    public static function actualizar(string $placa, array $datos): bool {
        $pdo = self::getPDO();
        $sql = "UPDATE vehiculo SET marca=?, modelo=?, kilometraje=?, fecha_adquisicion=?, proveedor_id=?, reserva_id=?, tipo_vehiculo_id=?, id_sede=? WHERE placa=?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $datos['marca'],
            $datos['modelo'],
            $datos['kilometraje'],
            $datos['fecha_adquisicion'],
            $datos['proveedor_id'],
            $datos['reserva_id'],
            $datos['tipo_vehiculo_id'],
            $datos['id_sede'],
            $placa
        ]);
    }

    public static function eliminar(string $placa): bool {
        $pdo = self::getPDO();
        $sql = "DELETE FROM vehiculo WHERE placa = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$placa]);
    }

    public static function obtenerTodos(): array {
        $pdo = self::getPDO();
        $sql = "SELECT * FROM vehiculo";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 