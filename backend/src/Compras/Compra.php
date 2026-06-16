<?php declare(strict_types=1);

namespace App\Compras;

use DateTime;
use JsonSerializable;
use Override;

class Compra implements JsonSerializable
{
    /**
     * @param int $id
     * @param float $valorTotal
     * @param DateTime $dataCompra
     * @param ItemCompra[] $itens
     */
    public function __construct(
        public int $id,
        public float $valorTotal,
        public DateTime $dataCompra,
        public array $itens
    ) {}

    #[Override]
    public function jsonSerialize(): array
    {
      return [
          'id' => $this->id,
          'valor_total' => $this->valorTotal,
          'data_compra' => $this->dataCompra,
          'itens' => $this->itens
      ];
    }
}