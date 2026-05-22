<?php

namespace App\Router;

use App\Auth\AuthService;
use App\Cursos\CursoController;

use App\Auth\Authenticator;
use App\Usuarios\UsuarioRepository;
use App\Utils\Env;
use App\Database\Conexao;

class ApiRouter {

    public function __construct(
        private CursoController $cursoController,
        private AuthService $authService
    ) {}

    public function handle(string $uri, string $method): void
    {
        header('Content-Type: application/json');

        $path = parse_url($uri, PHP_URL_PATH);

        if ($path === '/api/login') {
            // enquanto se desenvolve o 'novo' frontend!!!
            $usuario = new Authenticator(new UsuarioRepository(Conexao::getInstance()))->autenticar(
                Env::get('USUARIO_EMAIL'), Env::get('USUARIO_SENHA')
            );
            
            $this->authService->login($usuario);
              
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

        try {
            switch ($method) {
                case 'GET':
                    $this->cursoController->buscarCursos();
                    break;

                case 'POST':
                    $this->authService->exigirAutenticacaoApi();
                    $this->cursoController->cadastrar();
                    break;

                case 'PUT':
                    $this->authService->exigirAutenticacaoApi();
                    $this->cursoController->editar();
                    break;

                case 'DELETE':
                    $this->authService->exigirAutenticacaoApi();
                    $this->cursoController->remover();
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
