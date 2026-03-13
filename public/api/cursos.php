<?php

require_once __DIR__ . '/../../src/controllers/cursos_controller.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        buscarCursos();
        break;

    case 'POST':
        cadastrar();
        break;

    case 'PUT':
        editar();
        break;

    case 'DELETE':
        remover();
        break;
        
    default:
        http_response_code(405);
        echo "Método não suportado - " . $_SERVER['REQUEST_METHOD'];
}