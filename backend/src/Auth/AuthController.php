<?php declare(strict_types=1);

namespace App\Auth;

use App\Auth\Exceptions\CredenciaisInvalidasException;
use App\Auth\Validation\CadastroUsuarioValidator;
use App\Auth\Validation\LoginValidator;

use App\Core\ApiResponse;
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

        $validator = new LoginValidator();
        $validator->validar($dados);

        if ($validator->validacaoFalhou()) {
            $erros = $validator->getErros();
            ApiResponse::erro('Existem campos não-preenchidos ou inválidos', 422, $erros);
        }

        try {
            $authResponse = $this->authService->login(
                $dados['email'], 
                $dados['senha']
            );

            ApiResponse::json($authResponse);
            
        } catch (CredenciaisInvalidasException $e) {
            ApiResponse::erro('Credenciais inválidas', 401);
        }
    }

    public function cadastrarUsuario(): void
    {
        $dados = $this->obterDadosDaRequisicao();

        $validator = new CadastroUsuarioValidator();
        $validator->validar($dados);

        if ($validator->validacaoFalhou()) {
            $erros = $validator->getErros();
            ApiResponse::erro('Existem campos não-preenchidos ou inválidos', 422, $erros);
        }

        try {
            $authResponse = $this->authService->cadastrarUsuario(
                $dados['email'],
                $dados['nome'],
                $dados['senha']
            );

            ApiResponse::json($authResponse);

        } catch (EmailJaCadastradoException $e) {
            ApiResponse::erro('E-mail já cadastrado', 409);
        }
    }

    public function buscarUsuarioAutenticado(): void
    {
        $dadosUsuario = AuthContext::getUsuario();

        if (empty($dadosUsuario)) {
            ApiResponse::erro('Usuário não autenticado', 401);
        }

        ApiResponse::json($dadosUsuario);
    }
}