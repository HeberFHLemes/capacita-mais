<?php declare(strict_types=1);

namespace App\Compras;

use App\Carrinhos\CarrinhoRepository;
use App\Carrinhos\ItemCarrinho;
use App\Carrinhos\Exceptions\CarrinhoVazioException;
use App\Compras\Exceptions\CompraNaoRealizadaException;
use App\Compras\Exceptions\PrecosDiferentesException;
use App\Database\TransactionManager;

use Throwable;

readonly class CompraService
{
    public function __construct(
        private CompraRepository $compraRepository,
        private CarrinhoRepository $carrinhoRepository,
        private TransactionManager $transactionManager
    ) {}

    /**
     * @param int $usuarioId
     * @return Compra[]
     */
    public function buscarComprasPorUsuarioId(int $usuarioId): array
    {
        return $this->compraRepository->buscarComprasPorUsuarioId($usuarioId);
    }

    /**
     * Realiza a persistência de um compra, executando validações
     * como se o total esperado está de acordo com as informações
     * do banco de dados (usuário não ser "enganado" com valores recém atualizados),
     * cursos já comprados pelo usuário não podem ser comprados novamente, etc.
     *
     * @param int $usuarioId
     * @param float $totalEsperado
     * @return Compra
     */
    public function realizarCompra(int $usuarioId, float $totalEsperado): Compra
    {
        $itensCarrinho = $this->carrinhoRepository->buscarItens($usuarioId);

        if ($itensCarrinho === []) {
            throw new CarrinhoVazioException();
        }

        // calcula o total a ser pago via dados do BD.
        $total = array_sum(
            array_map(
                fn (ItemCarrinho $item) => $item->preco,
                $itensCarrinho
            )
        );

        // uso das duas casas decimais apenas
        if ((round($totalEsperado, 2) !== round($total, 2))) {
            throw new PrecosDiferentesException(
                'Os preços dos cursos foram alterados. Atualize o carrinho e tente novamente'
            );
        }

        $idsComprados = $this->compraRepository->buscarItensCompradosPeloUsuario($usuarioId);
        $idsCarrinho = array_map(
            fn (ItemCarrinho $item) => $item->id,
            $itensCarrinho
        );

        // Verifica se existe, nos IDs presentes no carrinho,
        // se existe algum ID também presente no conjunto de itens já comprados pelo usuário.
        $idsDuplicados = array_intersect($idsComprados, $idsCarrinho);

        if ($idsDuplicados !== []) {
            throw new CompraNaoRealizadaException(
                'Existem cursos no carrinho que já foram adquiridos.'
            );
        }

        try {
            // Realiza as operações dentro de uma transação no banco de dados
            $compraId = $this->transactionManager->execute(
                function () use ($usuarioId, $total, $itensCarrinho): int {
                    $compraId = $this->compraRepository->criarCompra($usuarioId, $total);

                    foreach ($itensCarrinho as $item) {
                        $this->compraRepository->criarItemCompra(
                            $compraId,
                            $item->id,
                            $item->preco
                        );
                    }

                    $this->carrinhoRepository->limparCarrinho($usuarioId);

                    return $compraId;
                }
            );
        } catch (Throwable $e) {
            throw new CompraNaoRealizadaException();
        }

        return $this->compraRepository->buscarCompraPorId($compraId);
    }
}