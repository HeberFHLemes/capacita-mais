<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Cursos\CursoController;
use App\Cursos\CursoService;
use App\Cursos\CursoRepository;
use App\Database\Conexao;
use App\Categorias\CategoriaRepository;
use App\Plataformas\PlataformaRepository;

$pdo = Conexao::getInstance();

$cursoService = new CursoService(
    new CursoRepository($pdo),
    new PlataformaRepository($pdo),
    new CategoriaRepository($pdo)
);

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