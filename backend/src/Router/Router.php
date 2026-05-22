<?php

namespace App\Router;

use App\Auth\AuthService;
use App\Auth\Authenticator;

use App\Cursos\CursoController;
use App\Cursos\CursoService;

use App\Database\Conexao;

use App\Usuarios\UsuarioRepository;

use App\Utils\Env;

class Router
{
    public function dispatch(string $uri, string $method): void
    {
        header('Content-Type: application/json');

        $path = parse_url($uri, PHP_URL_PATH);

        $authService = new AuthService();
        $pdo = Conexao::getInstance();

        if ($path === '/api/login') {
            // enquanto se desenvolve o 'novo' frontend!!!
            $usuario = new Authenticator(new UsuarioRepository($pdo))->autenticar(
                Env::get('USUARIO_EMAIL'), Env::get('USUARIO_SENHA')
            );
            
            $authService->login($usuario);
              
            http_response_code(200);
            echo json_encode([
              'mensagem' => "Bem-vindo(a), " . $usuario->getEmail() . "!",
              'autenticado' => true,
              'perfil' => $usuario->getPerfil()
            ]);
            
            exit;
        }

        if ($path !== '/api/cursos') {
            http_response_code(404);
            echo json_encode(['erro' => 'Endpoint desconhecido']);
            exit;
        }

        $cursoController = new CursoController(CursoService::with($pdo));

        try {
            switch ($method) {
                case 'GET':
                    $cursoController->buscarCursos();
                    break;

                case 'POST':
                    $authService->exigirAutenticacaoApi();
                    $cursoController->cadastrar();
                    break;

                case 'PUT':
                    $authService->exigirAutenticacaoApi();
                    $cursoController->editar();
                    break;

                case 'DELETE':
                    $authService->exigirAutenticacaoApi();
                    $cursoController->remover();
                    break;
                    
                default:
                    http_response_code(405);
                    header('Allow: GET, POST, PUT, DELETE');

                    echo json_encode([
                        'erro' => 'Método não suportado',
                        'metodo' => $method
                    ]);
                    exit;
            }
        } catch (\Throwable $e) {
            error_log($e);
            http_response_code(500);
            echo json_encode(['erro' => 'Sistema temporariamente indisponível']);
            exit;
        }
    }
}
