<?php

namespace App\Auth\Dto;

use JsonSerializable;
use Override;

readonly class UsuarioAuth implements JsonSerializable
{
    public function __construct(
        public readonly int $id,
        public readonly string $nome,
        public readonly string $perfil
    ) {}

    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'perfil' => $this->perfil
        ];
    }
}