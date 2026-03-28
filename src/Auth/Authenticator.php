<?php

namespace App\Auth;

use App\Usuarios\UsuarioRepository;
use App\Usuarios\Usuario;

class Authenticator
{
    public function __construct(
        private UsuarioRepository $usuarioRepository
    ) {}

    public function autenticar(string $email, string $senha): ?Usuario
    {
        $usuario = $this->usuarioRepository->buscarPorEmail($email);

        if ($usuario && $usuario->verificarSenha($senha)) {
            return $usuario;
        }

        return null;
    }
}