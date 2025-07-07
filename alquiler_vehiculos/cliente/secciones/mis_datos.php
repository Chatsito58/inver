<?php
// Obtener ID del cliente desde la sesión
$idCliente = $_SESSION['id_cliente'] ?? null;

require_once '../../modelos/conexion.php';
require_once '../../includes/csrf.php';

// Obtener instancia de PDO
$pdo = Conexion::getPDO();

$cliente = [];
$licencia = [];

if ($idCliente) {
    // Datos personales del usuario
    $stmt = $pdo->prepare('SELECT numero_identificacion, CONCAT(nombre, " ", apellido) AS nombre_completo, telefono, email, direccion FROM usuario WHERE id = ?');
    $stmt->execute([$idCliente]);
    $cliente = $stmt->fetch();

    // Datos de la licencia y su categoría
    $licenciaQuery = 'SELECT l.numero, l.fecha_expedicion, l.fecha_vencimiento,  c.nombre_categoria FROM licencia l LEFT JOIN categoria c ON c.id_licencia = l.id WHERE l.id_usuario = ?';
    $stmt = $pdo->prepare($licenciaQuery);
    $stmt->execute([$idCliente]);
    $licencia = $stmt->fetch();
}
?>

<?php if (($_GET['actualizado'] ?? '') === '1'): ?>
    <div class="alert alert-success">
        Licencia actualizada
    </div>
<?php elseif (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        <?php echo htmlspecialchars($_GET['error']); ?>
    </div>
<?php endif; ?>

<form method="POST" action="/controladores/actualizar_licencia.php">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generarToken()); ?>">

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Documento</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($cliente['numero_identificacion'] ?? ''); ?>" readonly>
        </div>
        <div class="col-md-6">
            <label class="form-label">Nombre completo</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($cliente['nombre_completo'] ?? ''); ?>" readonly>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Teléfono</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($cliente['telefono'] ?? ''); ?>" readonly>
        </div>
        <div class="col-md-6">
            <label class="form-label">Correo</label>
            <input type="email" class="form-control" value="<?php echo htmlspecialchars($cliente['email'] ?? ''); ?>" readonly>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Dirección</label>
        <input type="text" class="form-control" value="<?php echo htmlspecialchars($cliente['direccion'] ?? ''); ?>" readonly>
    </div>

    <h5 class="mt-4">Datos de la licencia</h5>
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Categoría</label>
            <input type="text" name="categoria" class="form-control" value="<?php echo htmlspecialchars($licencia['nombre_categoria'] ?? ''); ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Número</label>
            <input type="text" name="numero" class="form-control" value="<?php echo htmlspecialchars($licencia['numero'] ?? ''); ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Fecha de expedición</label>
            <input type="date" name="fecha_expedicion" class="form-control" value="<?php echo htmlspecialchars($licencia['fecha_expedicion'] ?? ''); ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Fecha de vencimiento</label>
            <input type="date" name="fecha_vencimiento" class="form-control" value="<?php echo htmlspecialchars($licencia['fecha_vencimiento'] ?? ''); ?>">
        </div>
    </div>
    <div id="fecha-error" class="alert alert-danger d-none" role="alert">
        La fecha de expedición no puede ser posterior a la de vencimiento
    </div>

    <button type="submit" id="btnActualizarLicencia" class="btn btn-primary">Actualizar licencia</button>
</form>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form[action="/controladores/actualizar_licencia.php"]');
    if (!form) return;

    const fechaExp = form.querySelector('input[name="fecha_expedicion"]');
    const fechaVenc = form.querySelector('input[name="fecha_vencimiento"]');
    const errorDiv = document.getElementById('fecha-error');

    form.addEventListener('submit', function (e) {
        if (fechaExp.value && fechaVenc.value && fechaExp.value > fechaVenc.value) {
            e.preventDefault();
            if (errorDiv) {
                errorDiv.classList.remove('d-none');
            }
        } else if (errorDiv) {
            errorDiv.classList.add('d-none');
        }
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnLicencia = document.getElementById('btnActualizarLicencia');
    const btnPago = document.getElementById('btnConfirmarPago');

    const attachConfirm = function(button, title, text) {
        if (!button) return;
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = button.closest('form');
            if (!form) return;

            Swal.fire({
                title: title,
                text: text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (typeof form.requestSubmit === 'function') {
                        form.requestSubmit(button);
                    } else {
                        form.submit();
                    }
                }
            });
        });
    };

    attachConfirm(btnLicencia, '¿Actualizar licencia?', 'Se guardarán los cambios de la licencia');
    attachConfirm(btnPago, '¿Confirmar pago?', 'Se procederá con el pago seleccionado');
});
</script>
