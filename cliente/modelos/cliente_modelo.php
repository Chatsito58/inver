<?php
require_once __DIR__ . '/../../config/conexion.php';

class ClienteModelo
{
    /**
     * Verifica las credenciales de un usuario segun su correo.
     * Devuelve el arreglo con los datos del usuario y el origen
     * de la base de datos si la contraseña coincide.
     */
    public static function verificarCredenciales(string $correo, string $clave): ?array
    {
        $resultado = buscarUsuarioPorEmail($correo);
        if (!$resultado) {
            return null;
        }

        $hash = $resultado['usuario']['hashed_password'] ?? null;
        if ($hash && password_verify($clave, $hash)) {
            return $resultado;
        }

        return null;
    }
}
