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
    
    echo json_encode([
        "success" => true,
        "received" => $dados
    ]);
}

// PUT
function editar()
{
    echo "Implementar edição de cursos existentes";
}

// DELETE
function remover()
{
    echo "Implementar remoção de cursos existentes";
}
