<?php
session_start();

// Redirección automática si ya hay sesión activa
if (isset($_SESSION['rol'])) {
    switch ($_SESSION['rol']) {
        case 'cliente':
            header('Location: cliente/perfil.php');
            exit();
        case 'empleado':
            header('Location: empleado/dashboard.php');
            exit();
        case 'admin':
            header('Location: admin/panel.php');
            exit();
        default:
            session_destroy();
            header('Location: login.php');
            exit();
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <div class="text-center">
        <h1 class="mb-4">Bienvenido al Sistema de Alquiler de Vehículos</h1>
        <p class="lead">Por favor inicia sesión para acceder a tu perfil o administrar el sistema.</p>
        <a href="login.php" class="btn btn-primary btn-lg mt-3">Iniciar sesión</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
