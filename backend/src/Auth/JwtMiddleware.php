<?php

namespace App\Auth;

use App\Auth\Exceptions\CredenciaisInvalidasException;
use App\Usuarios\Perfil;

class JwtMiddleware
{
    public function __construct(
       private readonly JwtService $jwtService
    ) {}

    public function autorizarRequisicao(?Perfil $perfilNecessario): void
    {
        $token = $this->extrairToken();

        $usuario = $this->jwtService->validarToken($token);

        // quando se exige um perfil específico do usuário
        if ($perfilNecessario) {
            $autorizado = $this->validarPerfil($usuario->perfil, $perfilNecessario);

            if (!$autorizado) {
                throw new CredenciaisInvalidasException();
            }
        }

        // Preenche o contexto de autenticação
        // (controller poderá saber id e perfil do usuário, por exemplo).
        AuthContext::setUsuario($usuario);
    }

    private function extrairToken(): string
    {
        $header = null;

        if (isset($_SERVER['Authorization'])) {
            $header = $_SERVER['Authorization'];

        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $header = $_SERVER['HTTP_AUTHORIZATION'];
        }

        if (empty($header)) {
            throw new CredenciaisInvalidasException();
        }

        // Regex para remover o 'Bearer ', retornando só o token
        if (!preg_match('/Bearer\s+(\S+)/', $header, $matches)) {
            throw new CredenciaisInvalidasException();
        }

        return $matches[1]; // 1 é o índice do primeiro 'match' (0 é a string inteira).
    }

    public function validarPerfil(
        string $perfilUsuario,
        Perfil $perfilNecessario
    ): bool {
        $perfilUsuario = Perfil::tryFrom($perfilUsuario);

        if (!$perfilUsuario) {
            return false;
        }

        if ($perfilNecessario === Perfil::ADMIN) {
            return $perfilUsuario === Perfil::ADMIN;
        }

        return true;
    }
}