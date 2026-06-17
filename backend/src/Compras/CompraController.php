<?php declare(strict_types=1);

namespace App\Compras;

use App\Auth\AuthContext;
use App\Carrinhos\Exceptions\CarrinhoVazioException;
use App\Compras\Exceptions\CursoJaCompradoException;
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

        // Recebe o total "conhecido" do front-end, para evitar que o usuário pague um
        // valor diferente daquilo que ele está sendo informado.
        $totalEsperado = $dados['total'] ?? null;

        if (!is_numeric($totalEsperado)) {
            ApiResponse::erro(
                'É necessário informar um valor total válido.',
                400
            );
        }

        $totalEsperado = (float) $totalEsperado;

        try {
            $compra = $this->compraService->realizarCompra($usuarioId, $totalEsperado);
            ApiResponse::json($compra);

        } catch (CarrinhoVazioException) {
            ApiResponse::erro('O carrinho do usuário está vazio.', 422);

        } catch (CursoJaCompradoException) {
            ApiResponse::erro('Existem cursos no carrinho que já foram adquiridos.', 409);

        } catch (PrecosDiferentesException) {
            ApiResponse::erro(
                'Houve uma atualização nos preços dos cursos. Atualize o carrinho e tente novamente.',
                409
            );
        }
    }
}