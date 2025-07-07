<?php
session_start();

<<<<<<< HEAD
require_once 'modelos/conexion.php';
require_once 'includes/csrf.php';
=======
require_once __DIR__ . '/../modelos/conexion.php';
require_once __DIR__ . '/../includes/csrf.php';
>>>>>>> 8d02ac62080603dd5692250635e759bb6cfb8167

$pdo = Conexion::getPDO();

if (!validarToken($_POST['csrf_token'] ?? '')) {
    header('Location: registro.php?error=Acceso%20no%20autorizado');
    exit();
}

$nombre         = trim($_POST['nombre'] ?? '');
$tipoDocumento  = trim($_POST['tipo_documento'] ?? '');
$documento      = trim($_POST['documento'] ?? '');
$correo         = trim($_POST['correo'] ?? '');
$telefono       = trim($_POST['telefono'] ?? '');
$direccion      = trim($_POST['direccion'] ?? '');
$codigoPostal   = trim($_POST['codigo_postal'] ?? '');
$categoria      = trim($_POST['categoria'] ?? '');
$licenciaNumero = trim($_POST['numero'] ?? '');
$fechaExp       = $_POST['fecha_expedicion'] ?? '';
$fechaVenc      = $_POST['fecha_vencimiento'] ?? '';
$contrasena1    = $_POST['contrasena'] ?? '';
$contrasena2    = $_POST['contrasena2'] ?? '';

if ($nombre === '' || $tipoDocumento === '' || $documento === '' || $correo === '' ||
    $telefono === '' || $direccion === '' || $codigoPostal === '' || $categoria === '' ||
    $licenciaNumero === '' || $fechaExp === '' || $fechaVenc === '' ||
    $contrasena1 === '' || $contrasena2 === '') {
    header('Location: registro.php?error=Todos%20los%20campos%20son%20obligatorios');
    exit();
}

if ($contrasena1 !== $contrasena2) {
    header('Location: registro.php?error=Las%20contrase%C3%B1as%20no%20coinciden');
    exit();
}

if (strtotime($fechaExp) > strtotime($fechaVenc)) {
    header('Location: registro.php?error=La%20fecha%20de%20expedici%C3%B3n%20no%20puede%20ser%20posterior%20a%20la%20de%20vencimiento');
    exit();
}

$stmt = $pdo->prepare('SELECT 1 FROM usuario WHERE usuario = ?');
$stmt->execute([$correo]);
if ($stmt->fetch()) {
    header('Location: registro.php?error=El%20correo%20ya%20existe');
    exit();
}

try {
    $pdo->beginTransaction();

    // Obtener id del rol de cliente
    $rolStmt = $pdo->prepare('SELECT id_rol FROM rol WHERE nombre = ?');
    $rolStmt->execute(['cliente']);
    $rol = $rolStmt->fetch();
    $idRol = $rol['id_rol'] ?? null;

    // Insertar usuario completo en una sola fila
    $usuarioStmt = $pdo->prepare('INSERT INTO usuario (numero_identificacion, nombre, apellido, email, telefono, direccion, codigo_postal, usuario, contrasena, id_rol) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $usuarioStmt->execute([$documento, $nombre, '', $correo, $telefono, $direccion, $codigoPostal, $correo, password_hash($contrasena1, PASSWORD_DEFAULT), $idRol]);
    $idUsuario = (int)$pdo->lastInsertId();

    // Asignar id_cliente para mantener compatibilidad
    $pdo->prepare('UPDATE usuario SET id_cliente = ? WHERE id_usuario = ?')->execute([$idUsuario, $idUsuario]);

    // Crear registro de licencia
    $licStmt = $pdo->prepare('INSERT INTO licencia (numero, fecha_expedicion, fecha_vencimiento, estado, id_usuario) VALUES (?, ?, ?, ?, ?)');
    $licStmt->execute([$licenciaNumero, $fechaExp, $fechaVenc, 'activo', $idUsuario]);
    $idLicencia = (int)$pdo->lastInsertId();

    // Registrar categoría inicial si aplica
    $catStmt = $pdo->prepare('INSERT INTO categoria (nombre_categoria, id_licencia) VALUES (?, ?)');
    $catStmt->execute([$categoria, $idLicencia]);

    $pdo->commit();

    header('Location: login.php?mensaje=Cuenta%20creada');
    exit();
} catch (PDOException $e) {
    $pdo->rollBack();
    header('Location: registro.php?error=Error%20al%20registrar%20el%20usuario');
    exit();
}
