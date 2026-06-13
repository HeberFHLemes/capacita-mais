<?php declare(strict_types=1);

namespace App\Carrinhos;

use JsonSerializable;
use Override;

readonly class Carrinho implements JsonSerializable
{
    /**
     * @param float $total
     * @param ItemCarrinho[] $cursos
     */
    public function __construct(
        public float $total,
        public array $cursos
    ) {}

    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'total' => $this->total,
            'cursos' => $this->cursos
        ];
    }
}