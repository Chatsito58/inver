<?php
require_once __DIR__ . '/../../modelos/vehiculo_modelo.php';

// Obtener la lista de vehículos directamente desde el modelo
$vehiculos = [];
try {
    $vehiculos = VehiculoModelo::obtenerTodos();
} catch (Exception $e) {
    $vehiculos = [];
}
?>
<?php include '../../includes/header.php'; ?>
<div class="container mt-5">
    <h2 class="mb-4">Vehículos Disponibles</h2>
    <?php if (empty($vehiculos)): ?>
        <div class="alert alert-warning">No hay vehículos disponibles en este momento.</div>
    <?php else: ?>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Placa</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Kilometraje</th>
                <th>Fecha Adquisición</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vehiculos as $vehiculo): ?>
            <tr>
                <td><?php echo htmlspecialchars($vehiculo['placa']); ?></td>
                <td><?php echo htmlspecialchars($vehiculo['marca']); ?></td>
                <td><?php echo htmlspecialchars($vehiculo['modelo']); ?></td>
                <td><?php echo htmlspecialchars($vehiculo['kilometraje']); ?></td>
                <td><?php echo htmlspecialchars($vehiculo['fecha_adquisicion']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
<?php include '../../includes/footer.php'; ?> 