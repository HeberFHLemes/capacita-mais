<?php

namespace App\Cursos;

use App\Cursos\CursoService;
use App\Cursos\CursoValidator;

use App\Cursos\Exceptions\CursoDuplicadoException;
use App\Cursos\Exceptions\CursoNaoEncontradoException;
use App\Cursos\Exceptions\SemAlteracoesException;

class CursoController 
{
    public function __construct(
        private CursoService $cursoService
    ) {}

    // GET
    public function buscarCursos() 
    {
        header('Content-Type: application/json');

        try {
            $cursos = $this->cursoService->listarCursos();

            http_response_code(200);
            echo json_encode($cursos);

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'erro' => 'Erro ao buscar cursos'
            ]);
        }
        exit;
    }

    // POST
    public function cadastrar() 
    {
        header('Content-Type: application/json');

        $requestBody = file_get_contents("php://input");
        $dados = json_decode($requestBody, true);

        $erros = CursoValidator::validar($dados);
        if (!empty($erros)) {
            http_response_code(400);
            echo json_encode(['erros' => $erros]);
            exit;
        }
        try {
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
                'criado' => true,
                'curso' => $curso->toArray()
            ]);

        } catch (CursoDuplicadoException $e) {
            http_response_code(409);
            echo json_encode(['erro' => 'Curso já cadastrado']);
        }
        exit;
    }

    // PUT
    public function editar()
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

        $requestBody = file_get_contents("php://input");
        $dados = json_decode($requestBody, true);

        $erros = CursoValidator::validar($dados);
        if (!empty($erros)) {
            http_response_code(400);
            echo json_encode(['erros' => $erros]);
            exit;
        }

        try {
            $cursoAtualizado = $this->cursoService->editar(
                $cursoId,
                $dados['nome'],
                $dados['descricao'],
                $dados['categoria'],
                $dados['plataforma'],
                $dados['url'],
                $dados['gratuito']
            );

            http_response_code(200);

            echo json_encode([
                "editado" => true,
                "curso" => $cursoAtualizado->toArray()
            ]);

        } catch (SemAlteracoesException $e) {
            http_response_code(200);
            echo json_encode([
                'editado' => false, 
                'mensagem' => "Nenhuma alteração detectada."
            ]);

        } catch (CursoNaoEncontradoException $e) {
            http_response_code(404);
            echo json_encode([
                'erro' => 'Curso não encontrado'
            ]);

        } catch (CursoDuplicadoException $e) {
            http_response_code(409);
            echo json_encode(['erro' => 'Curso já cadastrado']);

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'erro' => 'Erro interno'
            ]);
        }
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