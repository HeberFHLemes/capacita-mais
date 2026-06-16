<?php declare(strict_types=1);

namespace App\Compras;

use App\Carrinhos\CarrinhoRepository;
use App\Carrinhos\ItemCarrinho;

use App\Carrinhos\Exceptions\CarrinhoVazioException;
use App\Database\TransactionManager;
use Throwable;

readonly class CompraService
{
    public function __construct(
        private CompraRepository $compraRepository,
        private CarrinhoRepository $carrinhoRepository,
        private TransactionManager $transactionManager
    ) {}

    public function buscarCompraPorId(int $compraId): Compra
    {
        return $this->compraRepository->buscarCompraPorId($compraId);
    }

    /**
     * TODO:
     *  1 - receber o total esperado do usuário e validar com total calculado internamente;
     *  2 - Validar se os itens a serem comprados já não foram comprados anteriormente.
     * @param int $usuarioId
     * @return Compra
     * @throws Throwable
     */
    public function realizarCompra(int $usuarioId): Compra
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

        // Realiza as operações dentro de uma transação no banco de dados
        $compraId = $this->transactionManager->execute(
            function () use ($usuarioId, $total, $itensCarrinho): int
            {
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

        return $this->compraRepository->buscarCompraPorId($compraId);
    }
}