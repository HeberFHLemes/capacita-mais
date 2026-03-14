<?php

namespace App\Auth;

use App\Usuarios\UsuarioService;

class AuthService
{
    public function __construct(
        private UsuarioService $usuarioService
    ) {}

    public function iniciarSessao(): void 
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function exigirLogin(): void 
    {
        $this->iniciarSessao();

        if (empty($_SESSION['admin_id'])) {
            header('Location: /login.php');
            exit;
        }
    }

    public function autenticar(): string 
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { 
            return '';
        }

        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $senha = trim($_POST['senha'] ?? '');

        if (!$email || !$senha) {
            return 'E-mail ou senha inválidos.';
        }

        $this->iniciarSessao();

        // TODO: validar com banco de dados
        if ($this->usuarioService->usuarioExiste($email, $senha)) {
            session_regenerate_id(true);

            $_SESSION['admin_id'] = 1;

            header('Location: /cadastro.php');
            exit;
        }

        return 'E-mail ou senha inválidos.';
    }
}