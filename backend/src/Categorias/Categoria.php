<?php declare(strict_types=1);

namespace App\Categorias;

class Categoria 
{
    public int $id;
    public string $nome;
    public string $nomeNormalizado;
    
    public function __construct(
        int $id,
        string $nome,
        string $nomeNormalizado
    ) {
        $this->id = $id;    
        $this->nome = $nome;
        $this->nomeNormalizado = $nomeNormalizado;
    }   
}
