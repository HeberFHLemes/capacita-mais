<?php

namespace App\Cursos;

use App\Cursos\CursoService;

class CursoController 
{
    public function __construct(
        private CursoService $cursoService
    ) {}

    // GET
    public function buscarCursos() 
    {
        header('Content-Type: application/json');
        echo json_encode($this->cursoService->listarCursos());
        exit;
    }

    // POST
    public function cadastrar() 
    {
        header('Content-Type: application/json');

        $requestBody = file_get_contents("php://input");
        $dados = json_decode($requestBody, true);
        
        $curso = $this->cursoService->criar(
            $dados['nome'],
            $dados['descricao'],
            $dados['categoria'],
            $dados['plataforma'],
            $dados['url'],
            $dados['gratuito']
        );
        
        http_response_code(201);

        echo json_encode([
            "success" => true,
            "received" => $curso->toArray()
        ]);

        exit;
    }

    // PUT
    public function editar()
    {
        header('Content-Type: application/json');

        // TODO: atualizar registro no banco de dados
        //       requisição por query params (/api/cursos.php/{id}) ?

        echo "Implementar edição de cursos existentes";
        
        exit;
    }

    // DELETE
    public function remover()
    {
        header('Content-Type: application/json');
        
        // TODO: atualizar registro no banco de dados
        //       requisição por query params (/api/cursos.php/{id}) ?
        echo "Implementar remoção de cursos existentes";
        
        exit;
    }
    
}