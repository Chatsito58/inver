<?php
session_start();
require_once '../modelos/conexion.php';

// Validar campos
if (empty($_POST['correo']) || empty($_POST['contrasena'])) {
    header("Location: ../login.php?error=Completa todos los campos");
    exit();
}

$correo = $_POST['correo'];
$contrasena = hash('sha256', $_POST['contrasena']);

// Buscar usuario y obtener rol real
$sql = "SELECT u.id_usuario, u.contrasena, u.id_cliente, r.nombre AS rol
        FROM Usuario u
        INNER JOIN Rol r ON u.id_rol = r.id_rol
        WHERE u.usuario = ? AND u.contrasena = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$correo, $contrasena]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario) {
    $_SESSION['id_usuario'] = $usuario['id_usuario'];
    $_SESSION['rol'] = $usuario['rol'];
    
    if ($usuario['rol'] === 'cliente') {
        $_SESSION['id_cliente'] = $usuario['id_cliente'];
        header("Location: ../cliente/perfil.php");
    } else {
        // Para casos donde otros roles aún no se usan
        header("Location: ../login.php?error=Rol no disponible en esta versión");
    }
    exit();
} else {
    header("Location: ../login.php?error=Correo o contraseña incorrectos");
    exit();
}
