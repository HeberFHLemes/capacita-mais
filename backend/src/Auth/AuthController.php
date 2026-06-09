<?php

namespace App\Auth;

use App\Auth\Exceptions\CredenciaisInvalidasException;
use App\Core\ErrorResponse;
use App\Core\HttpMethod;
use App\Core\RestController;
use App\Core\Route;
use App\Usuarios\Exceptions\EmailJaCadastradoException;

class AuthController extends RestController
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    public static function routes(): array
    {
        return [
            new Route(HttpMethod::POST, '/api/auth/login', 'autenticar'),
            new Route(HttpMethod::POST, '/api/auth/cadastro', 'cadastrarUsuario'),
            new Route(HttpMethod::GET, '/api/auth/me', 'buscarUsuarioAutenticado', true)
        ];
    }

    public function autenticar(): void
    {
        $dados = $this->obterDadosDaRequisicao();

        $erros = AuthValidator::validarLogin($dados);
        if (!empty($erros)) {
            $this->jsonResponse(['erros' => $erros], 400);
            exit;
        }

        try {
            $authResponse = $this->authService->login(
                $dados['email'], 
                $dados['senha']
            );
                
            $this->jsonResponse($authResponse);
            
        } catch (CredenciaisInvalidasException $e) {
            $this->jsonResponse(['erros' => 'Credenciais inválidas'], 401);
        }
        exit;
    }

    public function cadastrarUsuario(): void
    {
        $dados = $this->obterDadosDaRequisicao();

        $erros = AuthValidator::validarCadastro($dados);
        if (!empty($erros)) {
            $this->jsonResponse(['erros' => $erros], 400);
            exit;
        }

        try {
            $authResponse = $this->authService->cadastrarUsuario(
                $dados['email'],
                $dados['nome'],
                $dados['senha']
            );
            
            $this->jsonResponse($authResponse);

        } catch (EmailJaCadastradoException $e) {
            $this->jsonResponse([
                'erros' => [ "E-mail já cadastrado" ]
            ], 409);
        }
        exit;
    }

    public function buscarUsuarioAutenticado(): void
    {
        $dadosUsuario = AuthContext::getUsuario();

        if (empty($dadosUsuario)) {
            $this->jsonResponse([ 'erros' => ['Usuário não autenticado'] ], 401);
            exit;
        }

        $this->jsonResponse($dadosUsuario);
    }
}