<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'includes/csrf.php';

$mensajeError = $_GET['error'] ?? '';
$mensajeInfo  = $_GET['mensaje'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login - Alquiler de Vehículos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card">
        <div class="card-body">
          <h3 class="text-center mb-4">Iniciar Sesión</h3>
          
          <?php if ($mensajeError): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($mensajeError); ?></div>
          <?php elseif ($mensajeInfo): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($mensajeInfo); ?></div>
          <?php endif; ?>

          <form method="POST" action="controladores/validar_login.php">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generarToken()); ?>">
            <div class="mb-3">
              <label for="correo" class="form-label">Correo electrónico</label>
              <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="mb-3">
              <label for="contrasena" class="form-label">Contraseña</label>
              <input type="password" class="form-control" id="contrasena" name="contrasena" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
            <div class="text-center mt-3">
              <a href="registro.php" class="btn btn-link">Crear cuenta</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
