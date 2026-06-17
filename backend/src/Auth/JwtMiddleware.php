<?php declare(strict_types=1);

namespace App\Auth;

use App\Auth\Exceptions\AcessoNegadoException;
use App\Auth\Exceptions\UsuarioNaoAutenticadoException;

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
                throw new AcessoNegadoException();
            }
        }

        // Preenche o contexto de autenticação
        // (controller poderá saber id e perfil do usuário, por exemplo).
        AuthContext::setUsuario($usuario);
    }

    private function extrairToken(): string
    {
        $header = $_SERVER['Authorization']
           ?? $_SERVER['HTTP_AUTHORIZATION']
           ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION']
           ?? null;

        if (empty($header)) {
            throw new UsuarioNaoAutenticadoException();
        }

        // Regex para remover o 'Bearer ', retornando só o token
        if (!preg_match('/Bearer\s+(\S+)/', $header, $matches)) {
            throw new UsuarioNaoAutenticadoException();
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

        if ($perfilNecessario !== Perfil::ADMIN) {
            return true;
        }

        return $perfilUsuario === Perfil::ADMIN;
    }
}