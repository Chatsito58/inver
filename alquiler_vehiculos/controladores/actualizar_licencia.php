<?php
session_start();

require_once '../modelos/conexion.php';
require_once '../includes/csrf.php';

if (!isset($_SESSION['id_cliente']) || !validarToken($_POST['csrf_token'] ?? '')) {
    header('Location: /cliente/perfil.php?error=Acceso%20no%20autorizado');
    exit;
}

$categoria = trim($_POST['categoria'] ?? '');
$numero = trim($_POST['numero'] ?? '');
$fechaExp = $_POST['fecha_expedicion'] ?? '';
$fechaVenc = $_POST['fecha_vencimiento'] ?? '';

if ($categoria === '' || $numero === '' || $fechaExp === '' || $fechaVenc === '') {
    header('Location: /cliente/perfil.php?error=Todos%20los%20campos%20son%20obligatorios');
    exit;
}

if ($fechaExp > $fechaVenc) {
    header('Location: /cliente/perfil.php?error=La%20fecha%20de%20expedicion%20no%20puede%20ser%20posterior%20a%20la%20de%20vencimiento');
    exit;
}

try {
    $query = 'UPDATE licencia SET numero = ?, fecha_expedicion = ?, fecha_vencimiento = ? WHERE id_usuario = ?';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$numero, $fechaExp, $fechaVenc, $_SESSION['id_cliente']]);

    $catQuery = 'UPDATE categoria c JOIN licencia l ON c.id_licencia = l.id SET c.nombre_categoria = ? WHERE l.id_usuario = ?';
    $stmtCat = $pdo->prepare($catQuery);
    $stmtCat->execute([$categoria, $_SESSION['id_cliente']]);

    header('Location: /cliente/perfil.php?exito=Licencia%20actualizada');
    exit;
} catch (PDOException $e) {
    header('Location: /cliente/perfil.php?error=Error%20al%20actualizar%20la%20licencia');
    exit;
}

