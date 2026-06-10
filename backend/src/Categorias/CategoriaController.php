<?php

namespace App\Categorias;

use App\Core\ApiResponse;
use App\Core\HttpMethod;
use App\Core\RestController;
use App\Core\Route;

use App\Usuarios\Perfil;

use Exception;
use Override;

class CategoriaController extends RestController
{
    public function __construct(
        private CategoriaService $categoriaService
    ) {}

    #[Override]
    public static function routes(): array
    {
        return [
            new Route(HttpMethod::GET, '/api/categorias', 'buscarCategorias'),
            new Route(HttpMethod::POST, '/api/categorias', 'cadastrarCategoria', true, Perfil::ADMIN),
            new Route(HttpMethod::PUT, '/api/categorias/{categoriaId:\d+}', 'editarCategoria', true, Perfil::ADMIN),
            new Route(HttpMethod::DELETE, '/api/categorias/{categoriaId:\d+}', 'removerCategoria', true, Perfil::ADMIN)
        ];
    }

    public function buscarCategorias(): void
    {
        try {
            $categorias = $this->categoriaService->buscarTodas();

            ApiResponse::json($categorias);

        } catch (Exception $e) {
            ApiResponse::erro('Erro ao buscar categorias');
        }
    }

    public function cadastrarCategoria(): void
    {
        // TODO: implementar POST /api/categorias
        ApiResponse::erro('Funcionalidade não implementada', 501);
    }

    public function editarCategoria(int $categoriaId): void
    {
        // TODO: implementar PUT /api/categorias
        ApiResponse::erro('Funcionalidade não implementada', 501);
    }

    public function removerCategoria(int $categoriaId): void
    {
        // TODO: implementar DELETE /api/categorias
        ApiResponse::erro('Funcionalidade não implementada', 501);
    }
}