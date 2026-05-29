<?php

namespace App\Cursos;

use App\Core\RestController;
use App\Core\HttpMethod;
use App\Core\Route;

use App\Cursos\CursoService;
use App\Cursos\CursoValidator;

use App\Cursos\Exceptions\CursoDuplicadoException;
use App\Cursos\Exceptions\CursoNaoEncontradoException;
use App\Cursos\Exceptions\SemAlteracoesException;
use App\Usuarios\Perfil;

class CursoController extends RestController
{
    public function __construct(
        private CursoService $cursoService
    ) {}

    public static function routes(): array
    {
        return [
            new Route(HttpMethod::GET, '/api/cursos', 'buscarCursos'),
            new Route(HttpMethod::POST, '/api/cursos', 'cadastrar', true, Perfil::ADMIN),
            new Route(HttpMethod::PUT, '/api/cursos/{id:\d+}', 'editar', true, Perfil::ADMIN),
            new Route(HttpMethod::DELETE, '/api/cursos/{id:\d+}', 'removerCurso', true, Perfil::ADMIN)
        ];
    }

    // GET
    public function buscarCursos() 
    {
        try {
            $cursos = $this->cursoService->listarCursos();

            $this->jsonResponse($cursos);

        } catch (\Exception $e) {
            $this->jsonResponse(['erro' => 'Erro ao buscar cursos'], 500);
        }
        exit;
    }

    // POST
    // TODO: adaptar ao novo jeito (Router)
    public function cadastrar() 
    {
        $requestBody = file_get_contents("php://input");
        $dados = json_decode($requestBody, true);

        $erros = CursoValidator::validar($dados);
        if (!empty($erros)) {
            $this->jsonResponse(['erros' => $erros], 400);
            exit;
        }
        
        try {
            $curso = $this->cursoService->criar(
                $dados['nome'],
                $dados['descricao'],
                $dados['categoria'],
                $dados['nivel'],
                $dados['preco'],
                $dados['preco_original'],
                $dados['em_destaque']
            );

            $this->jsonResponse(['criado' => true, 'curso' => $curso], 201);

        } catch (CursoDuplicadoException $e) {
            $this->jsonResponse(    
                ['criado' => false, 'erro' => 'Curso já cadastrado'],
                409
            );
        }
        exit;
    }

    // PUT
    // TODO: adaptar ao novo jeito (Router)
    public function editar()
    {
        $cursoId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!is_int($cursoId)) {
            $this->jsonResponse(['erro' => 'ID inválido'], 400);
            return;
        }

        $requestBody = file_get_contents("php://input");
        $dados = json_decode($requestBody, true);

        $erros = CursoValidator::validar($dados);
        if (!empty($erros)) {
            $this->jsonResponse(['erros' => $erros], 400);
            exit;
        }

        try {
            $cursoAtualizado = $this->cursoService->editar(
                $cursoId,
                $dados['nome'],
                $dados['descricao'],
                $dados['categoria'],
                $dados['nivel'],
                $dados['preco'],
                $dados['preco_original'],
                $dados['em_destaque']
            );

            $this->jsonResponse(
                ["editado" => true, "curso" => $cursoAtualizado],
                200
            );

        } catch (SemAlteracoesException $e) {
            $this->jsonResponse(
                ["editado" => false, 'mensagem' => "Nenhuma alteração detectada."],
                200
            );

        } catch (CursoNaoEncontradoException $e) {
            $this->jsonResponse(["erro" => "Curso não encontrado"], 404);

        } catch (CursoDuplicadoException $e) {
            $this->jsonResponse(["erro" => "Curso já cadastrado"], 409);

        } catch (\Exception $e) {
            $this->jsonResponse(["erro" => "Erro interno"], 500);
        }
        exit;
    }

    // DELETE
    public function removerCurso(int $id): void
    {        
        $cursoId = filter_var($id, FILTER_VALIDATE_INT);

        if (!is_int($cursoId)) {
            $this->jsonResponse(['erro' => 'ID inválido'], 400);
            return;
        }
        
        try {
            $removido = $this->cursoService->remover($cursoId);

            if ($removido) {
                $this->jsonResponse(status: 204);
                return;
            }

            $this->jsonResponse(['erro' => 'Curso não encontrado'], 404);

        } catch (\Exception $e) {
            $this->jsonResponse(['erro' => 'Erro interno'], 500);
        }
    }
}