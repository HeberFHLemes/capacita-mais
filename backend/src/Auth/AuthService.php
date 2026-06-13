<?php declare(strict_types=1);

namespace App\Auth;

use App\Auth\Dto\AuthResponse;
use App\Auth\Dto\UsuarioAuth;
use App\Auth\Exceptions\CredenciaisInvalidasException;

use App\Usuarios\UsuarioService;
use App\Usuarios\Perfil;

class AuthService
{
    public function __construct(
        private readonly UsuarioService $usuarioService,
        private readonly JwtService $jwtService
    ) {}

    public function login(string $email, string $senha): AuthResponse
    {
        $usuario = $this->usuarioService->buscarPorEmail($email);

        if (!$usuario || !$usuario->verificarSenha($senha)) {
            throw new CredenciaisInvalidasException("Credenciais inválidas");
        }

        $dadosUsuario = new UsuarioAuth(
            $usuario->getId(),
            $usuario->getNome(),
            $usuario->getPerfil()->value
        );

        $token = $this->jwtService->gerarToken($dadosUsuario);

        return new AuthResponse($token, $dadosUsuario);
    }

    public function cadastrarUsuario(string $email, string $nome, string $senha): AuthResponse
    {
        $email = filter_var(trim($email), FILTER_VALIDATE_EMAIL);

        $id = $this->usuarioService->criar($nome, $email, $senha);

        $dadosUsuario = new UsuarioAuth($id, $nome, Perfil::COMUM->value);

        $token = $this->jwtService->gerarToken($dadosUsuario);

        return new AuthResponse($token, $dadosUsuario);
    }
}