<?php declare(strict_types=1);

namespace App\Carrinhos;

use JsonSerializable;
use Override;

readonly class ItemCarrinho implements JsonSerializable
{
    public function __construct(
        public int $id,
        public string $nome,
        public float $preco
    ) {}

    #[Override]
    public function jsonSerialize(): array
    {
      return [
          'id' => $this->id,
          'nome' => $this->nome,
          'preco' => $this->preco
      ];
    }
}