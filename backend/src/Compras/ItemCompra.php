<?php declare(strict_types=1);

namespace App\Compras;

use JsonSerializable;
use Override;

class ItemCompra implements JsonSerializable
{
    public function __construct(
        public int $cursoId,
        public string $cursoNome,
        public float $valorPago
    ) {}

    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->cursoId,
            'nome' => $this->cursoNome,
            'valor_pago' => $this->valorPago
        ];
    }
}