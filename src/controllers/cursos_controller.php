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
    echo "Implementar cadastro de cursos";
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
