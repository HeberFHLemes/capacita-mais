<?php

namespace App\Cursos;

use App\Core\ApiResponse;
use App\Core\RestController;
use App\Core\HttpMethod;
use App\Core\Route;

use App\Categorias\Exceptions\CategoriaNaoEncontradaException;

use App\Cursos\Exceptions\CursoDuplicadoException;
use App\Cursos\Exceptions\CursoNaoEncontradoException;
use App\Cursos\Exceptions\SemAlteracoesException;

use App\Usuarios\Perfil;

use Exception;
use Override;

class CursoController extends RestController
{
    private CursoValidator $cursoValidator;

    public function __construct(private CursoService $cursoService)
    {
        $this->cursoValidator = new CursoValidator();
    }

    #[Override]
    public static function routes(): array
    {
        return [
            new Route(HttpMethod::GET, '/api/cursos', 'buscarCursos'),
            new Route(HttpMethod::GET, '/api/cursos/destaques', 'buscarCursosEmDestaque'),
            new Route(HttpMethod::POST, '/api/cursos', 'cadastrarCurso', true, Perfil::ADMIN),
            new Route(HttpMethod::PUT, '/api/cursos/{cursoId:\d+}', 'editarCurso', true, Perfil::ADMIN),
            new Route(HttpMethod::DELETE, '/api/cursos/{cursoId:\d+}', 'removerCurso', true, Perfil::ADMIN)
        ];
    }

    // GET
    public function buscarCursos() 
    {
        try {
            $cursos = $this->cursoService->listarCursos();

            $this->jsonResponse($cursos);

        } catch (Exception $e) {
            $this->jsonResponse(['erro' => 'Erro ao buscar cursos'], 500);
        }
        exit;
    }

    // GET /destaques
    public function buscarCursosEmDestaque()
    {
        try {
            $cursos = $this->cursoService->listarCursosEmDestaque();

            $this->jsonResponse($cursos);

        } catch (Exception $e) {
            $this->jsonResponse(['erro' => 'Erro ao buscar cursos em destaque'], 500);
        }
        exit;
    }

    // POST
    public function cadastrarCurso() 
    {
        $dados = $this->obterDadosDaRequisicao();

        $this->cursoValidator->validar($dados);

        if ($this->cursoValidator->validacaoFalhou()) {
            $erros = $this->cursoValidator->getErros();
            ApiResponse::erro('Existem campos não-preenchidos ou inválidos', 422, $erros);
        }
        
        try {
            $curso = $this->cursoService->criar(
                $dados['nome'],
                $dados['descricao'],
                $dados['categoria_id'],
                $dados['nivel'],
                $dados['preco'],
                $dados['preco_original'],
                $dados['em_destaque']
            );

            ApiResponse::json(['criado' => true, 'curso' => $curso], 201);
        
        } catch (CategoriaNaoEncontradaException $e) {
            ApiResponse::json(
                [ 'criado' => false, 'erros' => ['Categoria não encontrada'] ],
                404
            );

        } catch (CursoDuplicadoException $e) {
            ApiResponse::json(
                [ 'criado' => false, 'erros' => ['Curso já cadastrado'] ],
                409
            );
        }
    }

    // PUT
    public function editarCurso(int $cursoId)
    {
        $cursoId = filter_var($cursoId, FILTER_VALIDATE_INT);

        if (!is_int($cursoId)) {
            $this->jsonResponse([ 'erros' => ['ID inválido'] ], 400);
            return;
        }

        $dados = $this->obterDadosDaRequisicao();

        $this->cursoValidator->validar($dados);

        if ($this->cursoValidator->validacaoFalhou()) {
            $erros = $this->cursoValidator->getErros();
            ApiResponse::erro('Existem campos não-preenchidos ou inválidos', 422, $erros);
        }

        try {
            $cursoAtualizado = $this->cursoService->editar(
                $cursoId,
                $dados['nome'],
                $dados['descricao'],
                $dados['categoria_id'],
                $dados['nivel'],
                $dados['preco'],
                $dados['preco_original'],
                $dados['em_destaque']
            );

            ApiResponse::json(['editado' => true, "curso" => $cursoAtualizado]);

        } catch (SemAlteracoesException $e) { // Também retorna 200 OK
            ApiResponse::json(["editado" => false, "mensagem" => "Nenhuma alteração detectada."]);

        } catch (CategoriaNaoEncontradaException $e) {
            ApiResponse::json(
                [ "editado" => false, "mensagem" => "Categoria não encontrada" ],
                404
            );

        } catch (CursoNaoEncontradoException $e) {
            ApiResponse::erro("Curso não encontrado", 404);

        } catch (CursoDuplicadoException $e) {
            ApiResponse::erro("Curso já cadastrado", 409);

        } catch (Exception $e) {
            error_log($e);
            ApiResponse::erro("Erro interno");
        }
    }

    // DELETE
    public function removerCurso(int $cursoId): void
    {        
        $cursoId = filter_var($cursoId, FILTER_VALIDATE_INT);

        if (!is_int($cursoId)) {
            ApiResponse::erro('ID inválido', 400);
        }
        
        try {
            $removido = $this->cursoService->remover($cursoId);

            if ($removido) {
                http_response_code(204);
                exit;
            }

            ApiResponse::erro('Curso não encontrado', 404);

        } catch (Exception $e) {
            ApiResponse::erro('Erro interno');
        }
    }
}