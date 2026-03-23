<?php

namespace App\Auth;

use App\Usuarios\UsuarioRepository;
use App\Usuarios\Usuario;

class AuthService
{
    public function __construct(
        private UsuarioRepository $usuarioRepository
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

        if (
            !isset($_SESSION['usuario']) ||
            !isset($_SESSION['usuario']['id'])
        ) {
            header('Location: /login.php');
            exit;
        }
    }
    
    public function autenticar(string $email, string $senha): ?Usuario
    {
        $usuario = $this->usuarioRepository->buscarPorEmail($email);

        if ($usuario && $usuario->verificarSenha($senha)) {
            return $usuario;
        }

        return null;
    }
}