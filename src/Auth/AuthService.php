<?php

namespace App\Auth;

use App\Usuarios\UsuarioRepository;
use App\Usuarios\Usuario;

class AuthService
{
    public const ROLE_ADMIN = 'admin';

    public function __construct(
        private ?UsuarioRepository $usuarioRepository = null
    ) {}

    public function iniciarSessao(): void 
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public function exigirLogin(): void 
    {
        $this->iniciarSessao();

        if (!$this->usuarioLogado()) {
            header('Location: /login.php');
            exit;
        }
    }
    
    public function autenticar(string $email, string $senha): ?Usuario
    {
        if (!$this->usuarioRepository) {
            throw new \RuntimeException('UsuarioRepository não configurado.');
        }

        $usuario = $this->usuarioRepository->buscarPorEmail($email);

        if ($usuario && $usuario->verificarSenha($senha)) {
            return $usuario;
        }

        return null;
    }

    public function login(Usuario $usuario): void
    {
        $this->iniciarSessao();

        session_regenerate_id(true);

        $_SESSION['usuario'] = [
            'id' => $usuario->getId(),
            'role' => self::ROLE_ADMIN
        ];
    }

    public function usuario(): ?array
    {
        $this->iniciarSessao();
        return $_SESSION['usuario'] ?? null;
    }

    public function usuarioLogado(): bool
    {
        $this->iniciarSessao();
        return isset($_SESSION['usuario']['id']);
    }

    public function temRole(string $role): bool
    {
        $usuario = $this->usuario();

        return $usuario !== null &&  
            ($usuario['role'] ?? null) === $role;
    }
}