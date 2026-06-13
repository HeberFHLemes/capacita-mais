<?php declare(strict_types=1);

namespace App\Carrinhos;

class CarrinhoService
{
    public function __construct(
        private readonly CarrinhoRepository $carrinhoRepository
    ) {}

    public function buscarCarrinho(int $usuarioId): Carrinho
    {
        return $this->carrinhoRepository->buscarCarrinhoPorUsuario($usuarioId);
    }

    public function inserirItem(int $usuarioId, int $cursoId): ItemCarrinho
    {
        $this->carrinhoRepository->inserirItem(
            $usuarioId,
            $cursoId
        );

        return $this->carrinhoRepository->buscarItem(
            $usuarioId,
            $cursoId
        );
    }

    public function removerItem(int $usuarioId, int $cursoId): bool
    {
        return $this->carrinhoRepository->removerItem(
            $usuarioId,
            $cursoId
        );
    }
}