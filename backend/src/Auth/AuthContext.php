<?php declare(strict_types=1);

namespace App\Auth;

use App\Auth\Dto\UsuarioAuth;

/**
 * Contexto de autenticação do usuário, contendo os dados
 * do usuário autenticado/autorizado pelo middleware JWT,
 * para serem utilizados por outras partes da aplicação.
 */
final class AuthContext
{
    private static ?UsuarioAuth $usuario = null;

    public static function setUsuario(UsuarioAuth $usuario): void
    {
        self::$usuario = $usuario;
    }

    public static function getUsuario(): ?UsuarioAuth
    {
        return self::$usuario;
    }
}