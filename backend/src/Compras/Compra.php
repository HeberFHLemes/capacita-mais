<?php declare(strict_types=1);

namespace App\Compras;

use DateTimeInterface;
use JsonSerializable;
use Override;

class Compra implements JsonSerializable
{
    /**
     * @param int $id
     * @param float $valorTotal
     * @param DateTimeInterface $dataCompra
     * @param ItemCompra[] $itens
     */
    public function __construct(
        public int $id,
        public float $valorTotal,
        public DateTimeInterface $dataCompra,
        public array $itens
    ) {}

    #[Override]
    public function jsonSerialize(): array
    {
      return [
          'id' => $this->id,
          'valor_total' => $this->valorTotal,
          'data_compra' => $this->dataCompra->format(DateTimeInterface::ATOM),
          'itens' => $this->itens
      ];
    }
}