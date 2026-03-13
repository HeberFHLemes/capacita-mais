<?php

require_once dirname(__DIR__) . '/database/Database.php';

// GET
function buscarCursos() 
{
    header('Content-Type: application/json');
    echo json_encode(getCursos());
}

// POST
function cadastrar() 
{
    header('Content-Type: application/json');
    $requestBody = file_get_contents("php://input");

    $dados = json_decode($requestBody, true);
    
    // TODO: Persistir no banco
    
    http_response_code(201);
    echo json_encode([
        "success" => true,
        "received" => $dados
    ]);
}

// PUT
function editar()
{
    header('Content-Type: application/json');

    // TODO: atualizar registro no banco de dados
    //       requisição por query params (/api/cursos.php/{id}) ?

    echo "Implementar edição de cursos existentes";
}

// DELETE
function remover()
{
    // TODO: atualizar registro no banco de dados
    //       requisição por query params (/api/cursos.php/{id}) ?
    echo "Implementar remoção de cursos existentes";
}
