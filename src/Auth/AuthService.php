<?php

namespace App\Auth;

use App\Usuarios\Usuario;

class AuthService
{
    public function __construct()
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
        session_regenerate_id(true);

        $_SESSION['usuario'] = [
            'id' => $usuario->getId(),
            'role' => $usuario->getRole()
        ];
    }

    public function logout(): void
    {
        session_destroy();
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

    public function exigirAutenticacaoApi(): void
    {
        if (!$this->usuarioLogado()) {
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode(['erro' => 'Não autenticado']);
            exit;
        }
    }
}