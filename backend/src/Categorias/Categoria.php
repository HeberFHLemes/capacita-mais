<?php declare(strict_types=1);

namespace App\Categorias;

use JsonSerializable;
use Override;

readonly class Categoria implements JsonSerializable
{
    public function __construct(
        public int $id,
        public string $nome,
        public string $nomeNormalizado
    ) {}

    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'nome_normalizado' => $this->nomeNormalizado,
        ];
    }
}
