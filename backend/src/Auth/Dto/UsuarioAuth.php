<?php

namespace App\Auth\Dto;

use JsonSerializable;
use Override;

readonly class UsuarioAuth implements JsonSerializable
{
    public function __construct(
        public int $id,
        public string $nome,
        public string $perfil
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