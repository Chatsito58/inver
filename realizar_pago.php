<?php
session_start();

require_once '../modelos/conexion.php';
require_once '../includes/csrf.php';

// Verificar sesion y token CSRF
if (!isset($_SESSION['id_cliente']) ||
    ($_SESSION['rol'] ?? '') !== 'cliente' ||
    !validarToken($_POST['csrf_token'] ?? '')) {
    header('Location: /cliente/perfil.php?error=Acceso%20no%20autorizado');
    exit;
}

$idCliente   = $_SESSION['id_cliente'];
$idAbono     = (int) ($_POST['id_abono'] ?? 0);
$idMedioPago = (int) ($_POST['id_medio_pago'] ?? 0);

if ($idAbono <= 0 || $idMedioPago <= 0) {
    header('Location: /cliente/perfil.php?error=Datos%20no%20validos');
    exit;
}

$pdo = Conexion::getPDO();

// Comprobar que el abono pertenece al cliente y que está pendiente
$abonoStmt = $pdo->prepare(
    'SELECT AR.id
       FROM Abono_reserva AR
       JOIN Reserva_alquiler RA ON AR.id_reserva_alquiler = RA.id
       JOIN Alquiler A ON RA.id_alquiler = A.id
      WHERE AR.id = ?
        AND AR.estado = "pendiente"
        AND A.id_cliente = ?'
);
$abonoStmt->execute([$idAbono, $idCliente]);
$abono = $abonoStmt->fetch();

if (!$abono) {
    header('Location: /cliente/perfil.php?error=Abono%20inexistente%20o%20ya%20pagado');
    exit;
}

// Comprobar que el medio de pago pertenece al cliente
$medioStmt = $pdo->prepare('SELECT id FROM medio_pago WHERE id = ? AND id_cliente = ?');
$medioStmt->execute([$idMedioPago, $idCliente]);
$medio = $medioStmt->fetch();

if (!$medio) {
    header('Location: /cliente/perfil.php?error=Medio%20de%20pago%20invalido');
    exit;
}

try {
    $pdo->beginTransaction();

    // Registrar el pago
    $pagoStmt = $pdo->prepare(
        'INSERT INTO pago (id_abono, id_medio_pago, fecha_pago) VALUES (?, ?, NOW())'
    );
    $pagoStmt->execute([$idAbono, $idMedioPago]);

    // Almacenar el evento para auditoría
    $eventoStmt = $pdo->prepare(
        'INSERT INTO pago_evento (id_abono, id_medio_pago, id_usuario, fecha_evento) VALUES (?, ?, ?, NOW())'
    );
    $eventoStmt->execute([$idAbono, $idMedioPago, $idCliente]);

    // Marcar el abono como pagado e indicar el medio utilizado
    $updateStmt = $pdo->prepare(
        'UPDATE Abono_reserva SET estado = "pagado", id_medio_pago = ? WHERE id_abono = ?'
    );
    $updateStmt->execute([$idMedioPago, $idAbono]);

    $pdo->commit();

    header('Location: /cliente/perfil.php?pago=1');
    exit;
} catch (PDOException $e) {
    $pdo->rollBack();
    header('Location: /cliente/perfil.php?error=Error%20al%20registrar%20pago');
    exit;
}
