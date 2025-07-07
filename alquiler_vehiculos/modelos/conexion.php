<?php
class Conexion
{
    private static string $host = 'localhost';
    private static string $db   = 'alquiler_vehiculos';
    private static string $user = 'root';
    private static string $pass = '';
    private static string $charset = 'utf8mb4';
    private static string $port = '3307'; // Puerto corregido
    private static ?PDO $pdo = null;

    public static function getPDO(): PDO
    {
        if (self::$pdo === null) {
            $dsn = "mysql:host=" . self::$host . ";port=" . self::$port . ";dbname=" . self::$db . ";charset=" . self::$charset;

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];

            try {
                self::$pdo = new PDO($dsn, self::$user, self::$pass, $options);
            } catch (PDOException $e) {
                throw new PDOException('Error de conexión: ' . $e->getMessage(), (int) $e->getCode());
            }
        }

        return self::$pdo;
    }
}