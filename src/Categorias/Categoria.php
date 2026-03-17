<?php

namespace App\Categorias;

class Categoria 
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
