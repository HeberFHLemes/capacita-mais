<?php declare(strict_types=1);

namespace App\Categorias;

use JsonSerializable;
use Override;

class Categoria implements JsonSerializable
{
    public function __construct(
        public readonly int $id,
        public readonly string $nome, 
        public readonly string $nomeNormalizado
    ) {}

    #[Override]
    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'nome_normalizado' => $this->nomeNormalizado,
        ];
    }
}
