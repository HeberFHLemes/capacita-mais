<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Auth\AuthService;
use App\Cursos\CursoController;
use App\Cursos\CursoService;
use App\Database\Conexao;

try {
    $pdo = Conexao::getInstance();

    $cursoService = CursoService::with($pdo);

    $cursoController = new CursoController($cursoService);

    $authService = new AuthService(null);
    $authService->iniciarSessao();

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $cursoController->buscarCursos();
            break;

        case 'POST':
            exigirAutenticacao($authService);
            $cursoController->cadastrar();
            break;

        case 'PUT':
            exigirAutenticacao($authService);
            $cursoController->editar();
            break;

        case 'DELETE':
            exigirAutenticacao($authService);
            $cursoController->remover();
            break;
            
        default:
            http_response_code(405);
            header('Content-Type: application/json');
            header('Allow: GET, POST, PUT, DELETE');

            echo json_encode([
                'erro' => 'Método não suportado',
                'metodo' => $_SERVER['REQUEST_METHOD']
            ]);
            exit;
    }
} catch (\Throwable $e) {
    error_log($e);
    http_response_code(500);
    echo "Sistema temporariamente indisponível.";
    exit;
}

function exigirAutenticacao(AuthService $authService)
{
    if (!$authService->usuarioLogado()) {
        header('Content-Type: application/json');
        http_response_code(401);
        echo json_encode(['erro' => 'Não autenticado']);
        exit;
    }
}