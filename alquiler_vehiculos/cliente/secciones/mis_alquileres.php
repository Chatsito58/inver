<?php
// ID del cliente en sesión
$idCliente = $_SESSION['id_cliente'] ?? null;

<<<<<<< HEAD
require_once 'modelos/conexion.php';
=======
require_once __DIR__ . '/../../modelos/conexion.php';
>>>>>>> 8d02ac62080603dd5692250635e759bb6cfb8167

// Obtener la conexión a la base de datos
$pdo = Conexion::getPDO();

$alquileres = [];

if ($idCliente) {
    $condiciones = ['A.id_cliente = ?'];
    $params = [$idCliente];

    if (isset($_GET['fecha_inicio']) && $_GET['fecha_inicio'] !== '') {
        $condiciones[] = 'A.fecha_inicio >= ?';
        $params[] = $_GET['fecha_inicio'];
    }

    if (isset($_GET['estado']) && $_GET['estado'] !== '' && $_GET['estado'] !== 'Todos') {
        $condiciones[] = 'A.estado = ?';
        $params[] = $_GET['estado'];
    }

    if (isset($_GET['placa']) && $_GET['placa'] !== '') {
        $condiciones[] = 'V.placa LIKE ?';
        $params[] = '%' . $_GET['placa'] . '%';
    }

    $where = implode(' AND ', $condiciones);

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
           WHERE ' . $where;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $alquileres = $stmt->fetchAll();
}

$hayFiltros = (
    (isset($_GET['fecha_inicio']) && $_GET['fecha_inicio'] !== '') ||
    (isset($_GET['estado']) && $_GET['estado'] !== '' && $_GET['estado'] !== 'Todos') ||
    (isset($_GET['placa']) && $_GET['placa'] !== '')
);
?>

<form method="GET" class="row g-3 mb-3">
    <div class="col-md-3">
        <label class="form-label">Fecha desde</label>
        <input type="date" name="fecha_inicio" class="form-control" value="<?php echo htmlspecialchars($_GET['fecha_inicio'] ?? ''); ?>">
    </div>
    <div class="col-md-3">
        <label class="form-label">Estado</label>
        <?php $estadoActual = $_GET['estado'] ?? 'Todos'; ?>
        <select name="estado" class="form-select">
            <option value="Todos"<?php echo ($estadoActual === 'Todos' || $estadoActual === '') ? ' selected' : ''; ?>>Todos</option>
            <option value="Activo"<?php echo $estadoActual === 'Activo' ? ' selected' : ''; ?>>Activo</option>
            <option value="Finalizado"<?php echo $estadoActual === 'Finalizado' ? ' selected' : ''; ?>>Finalizado</option>
            <option value="Cancelado"<?php echo $estadoActual === 'Cancelado' ? ' selected' : ''; ?>>Cancelado</option>
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Placa</label>
        <input type="text" name="placa" class="form-control" value="<?php echo htmlspecialchars($_GET['placa'] ?? ''); ?>">
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn btn-primary me-2">Filtrar</button>
        <a href="?" class="btn btn-secondary">Limpiar</a>
    </div>
</form>

<?php if (empty($alquileres)): ?>
    <?php if ($hayFiltros): ?>
        <div class="alert alert-warning">No se encontraron alquileres con los filtros seleccionados.</div>
    <?php else: ?>
        <div class="alert alert-info">Aún no tienes alquileres registrados.</div>
    <?php endif; ?>
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
                $color = $estado === 'finalizado'
                    ? 'success'
                    : ($estado === 'activo' ? 'warning' : 'secondary');
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
                        <i class="bi bi-eye"></i> Ver
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

