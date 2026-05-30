<?php declare(strict_types=1);

namespace App\Cursos;

use JsonSerializable;
use Override;

class Curso implements JsonSerializable
{
    private int $id;
    private string $nome;
    private string $descricao;
    private string $categoria;
    private string $nivel;
    private float $preco;
    private float $precoOriginal;
    private bool $emDestaque;
    
    public function __construct(
        int $id,
        string $nome,
        string $descricao,
        string $categoria,
        string $nivel,
        float $preco,
        float $precoOriginal,
        bool $emDestaque
    ) {
        $this->id = $id;    
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->categoria = $categoria;
        $this->nivel = $nivel;
        $this->preco = $preco;
        $this->precoOriginal = $precoOriginal;
        $this->emDestaque = $emDestaque;
    }

    /**
     * Para definir como o objeto será serializado.
     * 
     * @link https://www.php.net/manual/pt_BR/jsonserializable.jsonserialize.php
     */
    #[Override]
    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'categoria' => $this->categoria,
            'nivel' => $this->nivel,
            'preco' => $this->preco,
            'preco_original' => $this->precoOriginal,
            'em_destaque' => $this->emDestaque
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

    public function getDescricao(): string|null 
    { 
        return $this->descricao; 
    }

    public function getCategoria(): string 
    { 
        return $this->categoria; 
    }

    public function getNivel(): string
    { 
        return $this->nivel; 
    }

    public function getPreco(): float 
    { 
        return $this->preco; 
    }
    
    public function getPrecoOriginal(): float
    { 
        return $this->precoOriginal;
    }
 
    public function isEmDestaque(): bool 
    { 
        return $this->emDestaque; 
    }
}
