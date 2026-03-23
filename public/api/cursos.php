<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Cursos\CursoController;
use App\Cursos\CursoService;
use App\Database\Conexao;

try {
    $pdo = Conexao::getInstance();

    $cursoService = CursoService::with($pdo);

    $cursoController = new CursoController($cursoService);

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $cursoController->buscarCursos();
            break;

        case 'POST':
            $cursoController->cadastrar();
            break;

        case 'PUT':
            $cursoController->editar();
            break;

        case 'DELETE':
            $cursoController->remover();
            break;
            
        default:
            http_response_code(405);
            echo "Método não suportado - " . $_SERVER['REQUEST_METHOD'];
            exit;
    }
} catch (\Throwable $e) {
    error_log($e);
    http_response_code(500);
    echo "Sistema temporariamente indisponível.";
    exit;
}