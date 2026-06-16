<?php

namespace App\Compras;

use App\Auth\AuthContext;
use App\Carrinhos\Exceptions\CarrinhoVazioException;
use App\Compras\Exceptions\CompraNaoRealizadaException;
use App\Compras\Exceptions\PrecosDiferentesException;
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
            new Route(HttpMethod::POST, '/compras', 'realizarCompra', true)
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
        if (!$totalEsperado) {
            ApiResponse::erro('É necessário informar o valor total a ser pago.', 400);
        }

        try {
            $compra = $this->compraService->realizarCompra($usuarioId, $totalEsperado);
            ApiResponse::json($compra);

        } catch (CarrinhoVazioException) {
            ApiResponse::erro('O carrinho do usuário está vazio.', 404);

        } catch (CompraNaoRealizadaException) {
            ApiResponse::erro('Não foi possível concluir a compra.');

        } catch (PrecosDiferentesException) {
            ApiResponse::erro(
                'Houve uma atualização nos preços dos cursos. Atualize o carrinho e tente novamente.',
                409
            );
        }
    }
}