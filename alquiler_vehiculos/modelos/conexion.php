<?php
/**
 * Manejador de conexión a la base de datos.
 *
 * Este archivo expone una clase sencilla con un método estático para obtener
 * una instancia de PDO. Otros scripts pueden incluir este archivo y llamar a
 * `Conexion::getPDO()` para ejecutar consultas de manera segura.
 */

class Conexion
{
    /** @var string Datos de conexión */
    private static string $host = 'localhost';
    private static string $db   = 'alquiler_vehiculos';
    private static string $user = 'clienteweb';
    private static string $pass = '1234';
    private static string $charset = 'utf8mb4';

    /** @var PDO|null Instancia de PDO reutilizable */
    private static ?PDO $pdo = null;

    /**
     * Devuelve una instancia de PDO inicializada.
     *
     * @throws PDOException Si la conexión falla.
     */
    public static function getPDO(): PDO
    {
        if (self::$pdo === null) {
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                self::$host,
                self::$db,
                self::$charset
            );

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];

            try {
                self::$pdo = new PDO($dsn, self::$user, self::$pass, $options);
            } catch (PDOException $e) {
                // Se relanza la excepción para que el script llamador pueda
                // gestionarla según corresponda.
                throw new PDOException('Error de conexión: ' . $e->getMessage(), (int) $e->getCode());
            }
        }

        return self::$pdo;
    }
}

?>
