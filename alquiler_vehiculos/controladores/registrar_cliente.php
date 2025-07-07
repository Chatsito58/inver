<?php
session_start();

require_once '../modelos/conexion.php';
require_once '../includes/csrf.php';

$pdo = Conexion::getPDO();

if (!validarToken($_POST['csrf_token'] ?? '')) {
    header('Location: ../registro.php?error=Acceso%20no%20autorizado');
    exit();
}

$nombre         = trim($_POST['nombre'] ?? '');
$tipoDocumento  = trim($_POST['tipo_documento'] ?? '');
$documento      = trim($_POST['documento'] ?? '');
$correo         = trim($_POST['correo'] ?? '');
$telefono       = trim($_POST['telefono'] ?? '');
$direccion      = trim($_POST['direccion'] ?? '');
$codigoPostal   = trim($_POST['codigo_postal'] ?? '');
$licencia       = trim($_POST['licencia'] ?? '');
$contrasena1    = $_POST['contrasena'] ?? '';
$contrasena2    = $_POST['contrasena2'] ?? '';

if ($nombre === '' || $tipoDocumento === '' || $documento === '' || $correo === '' ||
    $telefono === '' || $direccion === '' || $codigoPostal === '' || $licencia === '' ||
    $contrasena1 === '' || $contrasena2 === '') {
    header('Location: ../registro.php?error=Todos%20los%20campos%20son%20obligatorios');
    exit();
}

if ($contrasena1 !== $contrasena2) {
    header('Location: ../registro.php?error=Las%20contrase%C3%B1as%20no%20coinciden');
    exit();
}

$stmt = $pdo->prepare('SELECT 1 FROM usuario WHERE usuario = ?');
$stmt->execute([$correo]);
if ($stmt->fetch()) {
    header('Location: ../registro.php?error=El%20correo%20ya%20existe');
    exit();
}

try {
    $pdo->beginTransaction();

    $clienteStmt = $pdo->prepare('INSERT INTO usuario (numero_identificacion, nombre, apellido, email, telefono, direccion, codigo_postal) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $clienteStmt->execute([$documento, $nombre, '', $correo, $telefono, $direccion, $codigoPostal]);
    $idCliente = (int)$pdo->lastInsertId();

    $rolStmt = $pdo->prepare('SELECT id_rol FROM rol WHERE nombre = ?');
    $rolStmt->execute(['cliente']);
    $rol = $rolStmt->fetch();
    $idRol = $rol['id_rol'] ?? null;

    $usuarioStmt = $pdo->prepare('INSERT INTO usuario (usuario, contrasena, id_cliente, id_rol) VALUES (?, ?, ?, ?)');
    $usuarioStmt->execute([$correo, password_hash($contrasena1, PASSWORD_DEFAULT), $idCliente, $idRol]);


    $pdo->commit();

    header('Location: ../login.php?mensaje=Cuenta%20creada');
    exit();
} catch (PDOException $e) {
    $pdo->rollBack();
    header('Location: ../registro.php?error=Error%20al%20registrar%20el%20usuario');
    exit();
}
