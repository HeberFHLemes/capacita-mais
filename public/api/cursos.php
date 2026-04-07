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

    $authService = new AuthService();

    switch ($_SERVER['REQUEST_METHOD']) {
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
    echo json_encode(['erro' => 'Sistema temporariamente indisponível']);
    exit;
}