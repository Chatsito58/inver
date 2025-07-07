<?php
session_start();
require_once __DIR__ . '/cliente/includes/csrf.php';

function verificarCredenciales(string $email, string $password): bool {
    $usuarios = [
        'user@example.com' => password_hash('secret', PASSWORD_DEFAULT),
    ];
    return isset($usuarios[$email]) && password_verify($password, $usuarios[$email]);
}

function procesarLogin(string $email, string $password, string $token): bool {
    if (!validarToken($token)) {
        return false;
    }
    if (empty($password)) {
        return false;
    }
    if (!verificarCredenciales($email, $password)) {
        return false;
    }
    $_SESSION['usuario'] = $email;
    return true;
}
?>
