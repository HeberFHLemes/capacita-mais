<?php

namespace App\Auth;

use App\Usuarios\Usuario;

class AuthService
{
    public function iniciarSessao(): void 
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public function exigirLogin(): void 
    {
        if (!$this->usuarioLogado()) {
            header('Location: /login.php');
            exit;
        }
    }

    public function login(Usuario $usuario): void
    {
        $this->iniciarSessao();

        session_regenerate_id(true);

        $_SESSION['usuario'] = [
            'id' => $usuario->getId(),
            'role' => $usuario->getRole()
        ];
    }

    public function usuario(): ?array
    {
        return $_SESSION['usuario'] ?? null;
    }

    public function usuarioLogado(): bool
    {
        return isset($_SESSION['usuario']['id']);
    }

    public function temRole(string $role): bool
    {
        $usuario = $this->usuario();

        return $usuario !== null &&  
            ($usuario['role'] ?? null) === $role;
    }
}