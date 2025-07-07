<?php
session_start();

if (!isset($_SESSION['id_cliente']) || ($_SESSION['rol'] ?? '') !== 'cliente') {
    header('Location: /login.php');
    exit;
}

require_once 'includes/header.php';
require_once 'includes/nav_cliente.php';

?>

<div class="container mt-4">
    <ul class="nav nav-tabs" id="perfilTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="datos-tab" data-bs-toggle="tab" data-bs-target="#datos" type="button" role="tab" aria-controls="datos" aria-selected="true">
                <i class="bi bi-person"></i> Mis datos
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pagos-tab" data-bs-toggle="tab" data-bs-target="#pagos" type="button" role="tab" aria-controls="pagos" aria-selected="false">
                <i class="bi bi-cash-coin"></i> Pagos y facturas
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="alquileres-tab" data-bs-toggle="tab" data-bs-target="#alquileres" type="button" role="tab" aria-controls="alquileres" aria-selected="false">
                <i class="bi bi-car-front"></i> Mis alquileres
            </button>
        </li>
    </ul>
    <div class="tab-content" id="perfilTabsContent">
        <div class="tab-pane fade show active" id="datos" role="tabpanel" aria-labelledby="datos-tab">
            <?php include 'secciones/mis_datos.php'; ?>
        </div>
        <div class="tab-pane fade" id="pagos" role="tabpanel" aria-labelledby="pagos-tab">
            <?php include 'secciones/pagos_facturas.php'; ?>
        </div>
        <div class="tab-pane fade" id="alquileres" role="tabpanel" aria-labelledby="alquileres-tab">
            <?php include 'secciones/mis_alquileres.php'; ?>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';

