<?php

namespace App\Auth\Dto;

use JsonSerializable;
use Override;

class AuthResponse implements JsonSerializable
{
    public function __construct(
        public readonly string $token,
        public readonly UsuarioAuthResponse $usuario
    ) {}

    #[Override]
    public function jsonSerialize(): mixed
    {
        return [
            'token' => $this->token,
            'usuario' => $this->usuario
        ];
    }
}