<?php
// ID del cliente en sesión
$idCliente = $_SESSION['id_cliente'] ?? null;

require_once '../../modelos/conexion.php';

// Obtener la conexión a la base de datos
$pdo = Conexion::getPDO();

$alquileres = [];

if ($idCliente) {
    $sql = 'SELECT A.id,
                   V.placa,
                   V.modelo,
                   A.fecha_inicio,
                   A.fecha_fin,
                   S.nombre AS sede,
                   A.estado,
                   VA.valor_total
            FROM alquiler A
            JOIN vehiculo V ON V.placa = A.vehiculo_id
            JOIN sede S ON S.id = A.sede_id
            JOIN valor_alquiler VA ON VA.id = A.valor_alquiler_id
           WHERE A.usuario_id = ?';

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idCliente]);
    $alquileres = $stmt->fetchAll();
}
?>

<?php if (empty($alquileres)): ?>
    <div class="alert alert-info">Aún no tienes alquileres registrados.</div>
<?php else: ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Placa</th>
                <th>Modelo</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Sede</th>
                <th>Estado</th>
                <th>Valor total</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($alquileres as $a): ?>
            <?php
                $estado = strtolower($a['estado'] ?? '');
                $color = 'secondary';
                if ($estado === 'finalizado') {
                    $color = 'success';
                } elseif ($estado === 'activo') {
                    $color = 'warning';
                } elseif ($estado === 'cancelado') {
                    $color = 'secondary';
                }
            ?>
            <tr>
                <td><?php echo htmlspecialchars($a['id']); ?></td>
                <td><?php echo htmlspecialchars($a['placa']); ?></td>
                <td><?php echo htmlspecialchars($a['modelo']); ?></td>
                <td><?php echo htmlspecialchars($a['fecha_inicio']); ?></td>
                <td><?php echo htmlspecialchars($a['fecha_fin']); ?></td>
                <td><?php echo htmlspecialchars($a['sede']); ?></td>
                <td><span class="badge bg-<?php echo $color; ?>"><?php echo htmlspecialchars($a['estado']); ?></span></td>
                <td><?php echo htmlspecialchars($a['valor_total']); ?></td>
                <td>
                    <a class="btn btn-sm btn-primary" href="/cliente/detalle_alquiler.php?id=<?php echo urlencode($a['id']); ?>">
                        Ver
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

