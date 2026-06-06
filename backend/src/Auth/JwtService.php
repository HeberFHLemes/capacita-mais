<?php

namespace App\Auth;

class JwtService
{   
    // private readonly string $KEY;

    public function __construct() {
        // $this->KEY = Env::get("JWT_SECRET_KEY");
    }

    // TODO: gerar token com os dados do parâmetro $claims.
    public function gerarToken(array $claims): string {
        throw new \RuntimeException("Ainda não implementado");
    }

    // TODO: validar o token, extrair claims do token e retornar os dados extraidos.
    public function validarToken(string $token): array {
        throw new \RuntimeException("Ainda não implementado");
    }
}