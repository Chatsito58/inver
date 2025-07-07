<?php
session_start();
require_once __DIR__ . '/../cliente/includes/csrf.php';
require_once __DIR__ . '/../cliente/modelos/cliente_modelo.php';

$token = generarToken();
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $csrf = $_POST['csrf_token'] ?? '';

    if (!verificarToken($csrf)) {
        $error = 'Token CSRF inválido. Intenta nuevamente.';
    } else {
        $resultado = ClienteModelo::verificarCredenciales($email, $password);

        if ($resultado) {
            $_SESSION['usuario'] = $resultado['usuario'];
            $_SESSION['db_origen'] = $resultado['origen'];

            switch ($resultado['usuario']['tipo_usuario_id']) {
                case 1: header("Location: admin/menu_admin.php"); break;
                case 2: header("Location: cliente/menu_cliente.php"); break;
                case 3: header("Location: trabajador/menu_trabajador.php"); break;
                default:
                    $error = "Tipo de usuario desconocido.";
            }
            exit;
        } else {
            $error = "Credenciales incorrectas.";
        }
    }

    $token = generarToken(); // renovar token si falló
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2>Iniciar sesión</h2>

    <?php if (!empty($error)): ?>
        <div class='alert alert-danger'><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($token) ?>">
        <div class="mb-3">
            <label for="email">Correo:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Ingresar</button>
    </form>
</div>
</body>
</html>
