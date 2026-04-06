<?php declare(strict_types=1);

namespace App\Cursos;

use JsonSerializable;

class Curso implements JsonSerializable
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

    /**
     * Para definir como o objeto será serializado.
     * 
     * @link https://www.php.net/manual/pt_BR/jsonserializable.jsonserialize.php
     */ 
    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'categoria' => $this->categoria,
            'plataforma' => $this->plataforma,
            'gratuito' => $this->gratuito,
            'url' => $this->url
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getCategoria(): string
    {
        return $this->categoria;
    }

    public function getPlataforma(): string
    {
        return $this->plataforma;
    }

    public function isGratuito(): bool
    {
        return $this->gratuito;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
