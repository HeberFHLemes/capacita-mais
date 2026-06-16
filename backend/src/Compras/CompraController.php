<?php

namespace App\Compras;

use App\Auth\AuthContext;
use App\Core\ApiResponse;
use App\Core\HttpMethod;
use App\Core\RestController;
use App\Core\Route;

class CompraController extends RestController
{
    public static function routes(): array
    {
        return [
            new Route(HttpMethod::GET, '/compras', 'buscarCompras', true),
            new Route(HttpMethod::POST, '/compras', 'realizarCompra', true),

        ];
    }

    public function __construct(
        private readonly CompraService $compraService
    ) {}

    public function buscarCompras(): void
    {
        $usuarioId = AuthContext::getUsuario()->id;
        $compras = $this->compraService->buscarComprasPorUsuarioId($usuarioId);
        ApiResponse::json($compras);
    }

    public function realizarCompra(): void
    {
        $usuarioId = AuthContext::getUsuario()->id;

        $dados = $this->obterDadosDaRequisicao();

        $totalEsperado = $dados['total'];

        $compra = $this->compraService->realizarCompra($usuarioId, $totalEsperado);

        ApiResponse::json($compra);
    }
}