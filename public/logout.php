<?php
session_start();

// Remove all session variables
$_SESSION = [];

// Destroy the session.
session_destroy();

// Redirect to login page
header('Location: /public/login.php');
exit;
?>
