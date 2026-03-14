<?php declare(strict_types=1);

namespace Tests;

use App\Usuarios\UsuarioService;
use PHPUnit\Framework\TestCase;

// Testando o PHPUnit
final class UsuarioServiceTest extends TestCase
{
    public function testUsuarioExisteSeCredenciaisEstaoCorretas(): void
    {
        $email = "admin@capacita.com";
        $senha = "admin";

        $this->assertTrue(new UsuarioService()->usuarioExiste($email, $senha));
    }
}