<?php
session_start();

if (!isset($_SESSION['id_cliente']) || ($_SESSION['rol'] ?? '') !== 'cliente') {
    header('Location: /login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: /cliente/perfil.php');
    exit;
}

$id_alquiler = (int) $_GET['id'];

require_once '../modelos/conexion.php';

$pdo = Conexion::getPDO();

$detalleSql = 'SELECT A.id,
                     V.placa,
                     V.modelo,
                     S.nombre AS sede,
                     A.fecha_inicio,
                     A.fecha_fin,
                     A.estado,
                     VA.valor_total
              FROM alquiler A
              JOIN vehiculo V ON V.placa = A.vehiculo_id
              JOIN sede S ON S.id = A.sede_id
              JOIN valor_alquiler VA ON VA.id = A.valor_alquiler_id
             WHERE A.id = ?
               AND A.usuario_id = ?';

$detalleStmt = $pdo->prepare($detalleSql);
$detalleStmt->execute([$id_alquiler, $_SESSION['id_cliente']]);
$alquiler = $detalleStmt->fetch();

require_once '../includes/header.php';
require_once '../includes/nav_cliente.php';

if (!$alquiler) {
    echo '<div class="container mt-4"><div class="alert alert-danger">Acceso no autorizado o alquiler no encontrado.</div></div>';
    require_once '../includes/footer.php';
    return;
}

?>
<div class="container mt-4">
    <h2 class="mb-4">Detalle del alquiler #<?php echo htmlspecialchars($alquiler['id']); ?></h2>
    <ul class="list-group mb-4">
        <li class="list-group-item"><strong>Vehículo:</strong> <?php echo htmlspecialchars($alquiler['placa'] . ' - ' . $alquiler['modelo']); ?></li>
        <li class="list-group-item"><strong>Sede:</strong> <?php echo htmlspecialchars($alquiler['sede']); ?></li>
        <li class="list-group-item"><strong>Inicio:</strong> <?php echo htmlspecialchars($alquiler['fecha_inicio']); ?></li>
        <li class="list-group-item"><strong>Fin:</strong> <?php echo htmlspecialchars($alquiler['fecha_fin']); ?></li>
        <li class="list-group-item"><strong>Estado:</strong> <?php echo htmlspecialchars($alquiler['estado']); ?></li>
        <li class="list-group-item"><strong>Valor total:</strong> <?php echo htmlspecialchars($alquiler['valor_total']); ?></li>
    </ul>

<?php
$abonoSql = 'SELECT AR.valor, AR.fecha, AR.estado
             FROM Abono_reserva AR
             JOIN Reserva_alquiler RA ON AR.id_reserva_alquiler = RA.id
            WHERE RA.id_alquiler = ?';
$abonoStmt = $pdo->prepare($abonoSql);
$abonoStmt->execute([$id_alquiler]);
$abonos = $abonoStmt->fetchAll();
?>
    <h4>Abonos</h4>
    <?php if ($abonos): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Valor</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($abonos as $abono): ?>
            <tr>
                <td><?php echo htmlspecialchars($abono['valor']); ?></td>
                <td><?php echo htmlspecialchars($abono['fecha']); ?></td>
                <td><?php echo htmlspecialchars($abono['estado']); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>No hay abonos registrados.</p>
    <?php endif; ?>
<?php
$facturaSql = 'SELECT id, total, estado FROM factura WHERE alquiler_id = ?';
$facturaStmt = $pdo->prepare($facturaSql);
$facturaStmt->execute([$id_alquiler]);
$factura = $facturaStmt->fetch();
?>
    <?php if ($factura): ?>
    <div class="card mt-4">
        <div class="card-header">Factura</div>
        <div class="card-body">
            <p><strong>ID:</strong> <?php echo htmlspecialchars($factura['id']); ?></p>
            <p><strong>Total:</strong> <?php echo htmlspecialchars($factura['total']); ?></p>
            <p><strong>Estado:</strong> <?php echo htmlspecialchars($factura['estado']); ?></p>
        </div>
    </div>
    <?php endif; ?>
    <a class="btn btn-secondary mt-4" href="/cliente/perfil.php">Volver</a>
</div>
<?php
require_once '../includes/footer.php';
