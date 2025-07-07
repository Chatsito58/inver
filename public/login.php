<?php
session_start();
require_once __DIR__ . '/../cliente/includes/csrf.php';
require_once __DIR__ . '/../validar_login.php';

$token = generarToken();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $csrf = $_POST['csrf_token'] ?? '';

    if (procesarLogin($email, $password, $csrf)) {
        header('Location: index.php');
        exit;
    } else {
        $error = 'Credenciales inválidas o token incorrecto';
        $token = generarToken();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2>Iniciar sesión</h2>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($token, ENT_QUOTES, 'UTF-8'); ?>">
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
