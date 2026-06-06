<?php

namespace App\Auth;

use App\Auth\Dto\AuthResponse;
use App\Auth\Dto\UsuarioAuthResponse;
use App\Usuarios\UsuarioService;

use App\Auth\Exceptions\CredenciaisInvalidasException;
use App\Usuarios\Perfil;

class AuthService
{
    public function __construct(
        private UsuarioService $usuarioService,
        private JwtService $jwtService
    ) {}

    public function login(string $email, string $senha): AuthResponse
    {
        $usuario = $this->usuarioService->buscarPorEmail($email);

        if (!$usuario || !$usuario->verificarSenha($senha)) {
            throw new CredenciaisInvalidasException("Credenciais inválidas");
        }

        $dadosUsuario = new UsuarioAuthResponse(
            $usuario->getId(),
            $usuario->getNome(),
            $usuario->getPerfil()->value
        );

        // TODO: Gerar o token com o JwtService
        return new AuthResponse(
            "token-nao-implementado", 
            $dadosUsuario
        );
    }

    public function cadastrarUsuario(string $email, string $nome, string $senha): AuthResponse
    {
        $email = filter_var(trim($email), FILTER_VALIDATE_EMAIL);

        $id = $this->usuarioService->criar($nome, $email, $senha);

        $dadosUsuario = new UsuarioAuthResponse($id, $nome, Perfil::COMUM->value);
        
        // TODO: Gerar o token com o JwtService
        return new AuthResponse(
            "token-nao-implementado", 
            $dadosUsuario
        );
    }
}