<?php declare(strict_types=1);

namespace Tests;

use App\Auth\AuthService;
use App\Usuarios\Usuario;

use PHPUnit\Framework\TestCase;

final class AuthServiceTest extends TestCase
{
    protected function setUp(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];
    }

    public function testLoginIniciaSessaoDoUsuario()
    {
        $auth = new AuthService(null);

        $usuario = new Usuario(1, 'a@a.com', password_hash('123', PASSWORD_DEFAULT));

        $auth->login($usuario);

        $this->assertArrayHasKey('usuario', $_SESSION);
        $this->assertEquals(1, $_SESSION['usuario']['id']);
    }

    public function testUsuarioLogadoRetornaTrueAposLogin()
    {
        $auth = new AuthService(null);

        $usuario = new Usuario(1, 'a@a.com', password_hash('123', PASSWORD_DEFAULT));

        $auth->login($usuario);

        $this->assertTrue($auth->usuarioLogado());
    }
}