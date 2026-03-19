<?php declare(strict_types=1);

namespace App\Cursos;

class Curso 
{
    private int $id;
    private string $nome;
    private string $descricao;
    private string $categoria;
    private string $plataforma;
    private bool $gratuito;
    private string $url;
    
    public function __construct(
        int $id,
        string $nome,
        string $descricao,
        string $categoria,
        string $plataforma,
        bool $gratuito,
        string $url
    ) {
        $this->id = $id;    
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->categoria = $categoria;
        $this->plataforma = $plataforma;
        $this->gratuito = $gratuito;
        $this->url = $url;
    }

    public function toArray(): array 
    {
        return [
            "id" => $this->id,
            "nome" => $this->nome,
            "descricao" => $this->descricao,
            "categoria" => $this->categoria,
            "plataforma" => $this->plataforma,
            "gratuito" => $this->gratuito,
            "url" => $this->url
        ];
    }
}
