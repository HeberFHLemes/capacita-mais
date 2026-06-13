<?php declare(strict_types=1);

namespace App\Auth\Dto;

use JsonSerializable;
use Override;

readonly class AuthResponse implements JsonSerializable
{
    public function __construct(
        public readonly string $token,
        public readonly UsuarioAuth $usuario
    ) {}

    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'token' => $this->token,
            'usuario' => $this->usuario
        ];
    }
}