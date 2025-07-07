<?php
session_start();

require_once '../includes/csrf.php';

// Validar el token CSRF antes de procesar los datos del formulario
if (!validarToken($_POST['csrf_token'] ?? '')) {
    header('Location: /cliente/perfil.php?error=Token CSRF inválido');
    exit;
}

// Lógica de actualización (placeholder)

header('Location: /cliente/perfil.php?exito=Licencia actualizada');
