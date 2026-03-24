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
            "criado" => true,
            "curso" => $curso->toArray()
        ]);

        exit;
    }

    // PUT
    public function editar()
    {
        header('Content-Type: application/json');

        // TODO: 
        //  1. Pegar o id enviado na requisição (.../cursos.php?id=...)
        //  2. Tratar falta de id
        //  3. Receber o corpo da requisição (dados do curso)
        //  4. Chamar o método de edição do curso no service
        //  5. Retornar resposta ao usuário.
        echo "Implementar edição de cursos existentes";
        
        exit;
    }

    // DELETE
    public function remover()
    {
        header('Content-Type: application/json');
        
        $cursoId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!is_int($cursoId)) {
            http_response_code(400);
            echo json_encode([
                'erro' => 'ID inválido'
            ]);
            return;
        }
        
        try {
            $removido = $this->cursoService->remover($cursoId);

            if ($removido) {
                http_response_code(204);
                return;
            }

            http_response_code(404);
            echo json_encode([
                'erro' => 'Curso não encontrado'
            ]);

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'erro' => 'Erro interno'
            ]);
        }
    }
}