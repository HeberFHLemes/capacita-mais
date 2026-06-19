<?php declare(strict_types=1);

namespace App\Categorias;

use App\Categorias\Exceptions\CategoriaJaExistenteException;

use App\Core\ApiResponse;
use App\Core\HttpMethod;
use App\Core\RestController;
use App\Core\Route;

use App\Usuarios\Perfil;

use Override;

class CategoriaController extends RestController
{
    public function __construct(
        private readonly CategoriaService $categoriaService
    ) {}

    #[Override]
    public static function routes(): array
    {
        return [
            new Route(HttpMethod::GET, '/categorias', 'buscarCategorias'),
            new Route(HttpMethod::GET, '/categorias/{categoriaId:\d+', 'buscarCategoriaPorId'),
            new Route(HttpMethod::POST, '/categorias', 'cadastrarCategoria', true, Perfil::ADMIN),
            new Route(HttpMethod::PUT, '/categorias/{categoriaId:\d+}', 'editarCategoria', true, Perfil::ADMIN),
            new Route(HttpMethod::DELETE, '/categorias/{categoriaId:\d+}', 'removerCategoria', true, Perfil::ADMIN)
        ];
    }

    public function buscarCategorias(): void
    {
        $categorias = $this->categoriaService->buscarTodas();
        ApiResponse::json($categorias);
    }

    public function buscarCategoriaPorId(int $categoriaId): void
    {
        $categoria = $this->categoriaService->buscarPorId($categoriaId);

        if ($categoria) {
            ApiResponse::json($categoria);
        }

        ApiResponse::erro('Categoria não encontrada', 404);
    }

    public function cadastrarCategoria(): void
    {
        $dados = $this->obterDadosDaRequisicao();

        $nome = $dados['nome'];
        if (!isset($nome)) {
           ApiResponse::erro('É necessário informar o nome da categoria', 400);
        }

        try {
            $categoria = $this->categoriaService->criar($nome);

            ApiResponse::json($categoria, 201);

        } catch (CategoriaJaExistenteException) {
            ApiResponse::erro('Categoria já existente', 409);
        }
    }

    public function editarCategoria(int $categoriaId): void
    {
        $dados = $this->obterDadosDaRequisicao();

        $nome = $dados['nome'];
        if (!isset($nome)) {
            ApiResponse::erro('É necessário informar o nome da categoria', 400);
        }

        try {
            $categoria = $this->categoriaService->editar($categoriaId, $nome);

            ApiResponse::json($categoria);

        } catch (CategoriaJaExistenteException) {
            ApiResponse::erro('Categoria já existente', 409);
        }
    }

    public function removerCategoria(int $categoriaId): void
    {
        $removido = $this->categoriaService->remover($categoriaId);

        if ($removido) {
            http_response_code(204);
            exit;
        }

        ApiResponse::erro('Não foi possível remover a categoria', 404);
    }
}