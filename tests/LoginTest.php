<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../cliente/includes/csrf.php';
require_once __DIR__ . '/../validar_login.php';

class LoginTest extends TestCase
{
    protected function setUp(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
    }

    public function testLoginSuccess(): void
    {
        $token = generarToken();
        $this->assertTrue(procesarLogin('user@example.com', 'secret', $token));
        $this->assertEquals('user@example.com', $_SESSION['usuario']);
    }

    public function testMissingPassword(): void
    {
        $token = generarToken();
        $this->assertFalse(procesarLogin('user@example.com', '', $token));
    }

    public function testWrongEmail(): void
    {
        $token = generarToken();
        $this->assertFalse(procesarLogin('wrong@example.com', 'secret', $token));
    }

    public function testInvalidCsrfToken(): void
    {
        generarToken();
        $this->assertFalse(procesarLogin('user@example.com', 'secret', 'invalid'));
    }
}
