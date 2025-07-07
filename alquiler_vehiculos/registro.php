<?php
session_start();
require_once 'includes/csrf.php';
$mensaje = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center mb-4">Crear cuenta</h3>
                    <?php if ($mensaje): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($mensaje); ?></div>
                    <?php endif; ?>
                    <form method="POST" action="controladores/registrar_cliente.php">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generarToken()); ?>">
                        <div class="mb-3">
                            <label class="form-label">Nombre completo</label>
                            <input type="text" class="form-control" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipo de documento</label>
                            <input type="text" class="form-control" name="tipo_documento" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Número de documento</label>
                            <input type="text" class="form-control" name="documento" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" name="correo" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control" name="telefono" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dirección</label>
                            <input type="text" class="form-control" name="direccion" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Código postal</label>
                            <input type="text" class="form-control" name="codigo_postal" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Licencia</label>
                            <input type="text" class="form-control" name="licencia" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="contrasena" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Repetir contraseña</label>
                            <input type="password" class="form-control" name="contrasena2" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
