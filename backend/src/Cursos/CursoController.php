<?php declare(strict_types=1);

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

use Override;

class CursoController extends RestController
{
    public function __construct(
        private readonly CursoService $cursoService,
        private readonly CursoValidator $cursoValidator
    ) {}

    #[Override]
    public static function routes(): array
    {
        return [
            new Route(HttpMethod::GET, '/cursos', 'buscarCursos'),
            new Route(HttpMethod::GET, '/cursos/destaques', 'buscarCursosEmDestaque'),
            new Route(HttpMethod::GET, '/cursos/{cursoId:\d+}', 'buscarCursoPorId'),
            new Route(HttpMethod::POST, '/cursos', 'cadastrarCurso', true, Perfil::ADMIN),
            new Route(HttpMethod::PUT, '/cursos/{cursoId:\d+}', 'editarCurso', true, Perfil::ADMIN),
            new Route(HttpMethod::DELETE, '/cursos/{cursoId:\d+}', 'removerCurso', true, Perfil::ADMIN)
        ];
    }

    // GET
    public function buscarCursos(): void
    {
        $cursos = $this->cursoService->listarCursos();
        ApiResponse::json($cursos);
    }

    // GET /destaques
    public function buscarCursosEmDestaque(): void
    {
        $cursos = $this->cursoService->listarCursosEmDestaque();
        ApiResponse::json($cursos);
    }

    // GET /{cursoId}
    public function buscarCursoPorId(int $cursoId): void
    {
        try {
            $curso = $this->cursoService->buscarCursoPorId($cursoId);
            ApiResponse::json($curso);

        } catch (CursoNaoEncontradoException) {
            ApiResponse::erro("Curso não encontrado", 404);
        }
    }

    // POST
    public function cadastrarCurso(): void
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
                (int) $dados['categoria_id'],
                $dados['nivel'],
                (float) $dados['preco'],
                (float) $dados['preco_original'],
                (bool) $dados['em_destaque']
            );

            ApiResponse::json(['criado' => true, 'curso' => $curso], 201);
        
        } catch (CategoriaNaoEncontradaException) {
            ApiResponse::json(
                [ 'criado' => false, 'erros' => ['Categoria não encontrada'] ],
                404
            );

        } catch (CursoDuplicadoException) {
            ApiResponse::json(
                [ 'criado' => false, 'erros' => ['Curso já cadastrado'] ],
                409
            );
        }
    }

    // PUT /{cursoId}
    public function editarCurso(int $cursoId): void
    {
        $cursoId = filter_var($cursoId, FILTER_VALIDATE_INT);

        if (!is_int($cursoId)) {
            ApiResponse::erro('ID inválido', 400);
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
                (int) $dados['categoria_id'],
                $dados['nivel'],
                (float) $dados['preco'],
                (float) $dados['preco_original'],
                (bool) $dados['em_destaque']
            );

            ApiResponse::json(['editado' => true, "curso" => $cursoAtualizado]);

        } catch (SemAlteracoesException) {// Também retorna 200 OK
            ApiResponse::json(["editado" => false, "mensagem" => "Nenhuma alteração detectada."]);

        } catch (CategoriaNaoEncontradaException) {
            ApiResponse::json(
                [ "editado" => false, "mensagem" => "Categoria não encontrada" ],
                404
            );

        } catch (CursoNaoEncontradoException) {
            ApiResponse::erro("Curso não encontrado", 404);

        } catch (CursoDuplicadoException) {
            ApiResponse::erro("Curso já cadastrado", 409);

        }
    }

    // DELETE /{cursoId}
    public function removerCurso(int $cursoId): void
    {        
        $cursoId = filter_var($cursoId, FILTER_VALIDATE_INT);

        if (!is_int($cursoId)) {
            ApiResponse::erro('ID inválido', 400);
        }

        $removido = $this->cursoService->remover($cursoId);

        if ($removido) {
            http_response_code(204);
            exit;
        }

        ApiResponse::erro('Curso não encontrado', 404);
    }
}
