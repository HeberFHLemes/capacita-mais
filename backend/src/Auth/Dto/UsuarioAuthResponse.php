<?php

namespace App\Auth\Dto;

use JsonSerializable;
use Override;

final class UsuarioAuthResponse implements JsonSerializable
{
    public function __construct(
        public readonly int $id,
        public readonly string $nome,
        public readonly string $perfil
    ) {}

    #[Override]
    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'perfil' => $this->perfil
        ];
    }
}