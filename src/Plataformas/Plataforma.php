<?php

namespace App\Plataformas;

class Plataforma 
{
    public int $id;
    public string $nome;
    
    public function __construct(
        int $id,
        string $nome
    ) {
        $this->id = $id;    
        $this->nome = $nome;
    }
    
}
