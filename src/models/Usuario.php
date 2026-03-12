<?php

declare(strict_types=1);

class Usuario {
    private int $id;
    private string $email;
    private string $senha;
    
    public function __construct(
        int $id,
        string $email,
        string $senha
    ) {
        $this->id = $id;    
        $this->email = $email;
        $this->senha = $senha;
    }

    public function toArray(): array {
        return [
            "id" => $this->id,
            "email" => $this->email,
            "senha" => $this->senha
        ];
    }
}
