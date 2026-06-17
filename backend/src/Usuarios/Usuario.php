<?php declare(strict_types=1);

namespace App\Usuarios;

use DateTimeInterface;
use JsonSerializable;
use Override;

class Usuario implements JsonSerializable
{
    private int $id;
    private string $nome;
    private string $email;
    private string $senhaHash;
    private Perfil $perfil;
    private DateTimeInterface $dataCriacao;
    
    public function __construct(
        int $id,
        string $nome,
        string $email,
        string $senha,
        Perfil $perfil,
        DateTimeInterface $dataCriacao
    ) {
        $this->id = $id;    
        $this->nome = $nome;
        $this->email = $email;
        $this->senhaHash = $senha;
        $this->perfil = $perfil;
        $this->dataCriacao = $dataCriacao;
    }

    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'perfil' => $this->perfil->value,
            'data_criacao' => $this->dataCriacao->format(DateTimeInterface::ATOM)
        ];
    }
    
    // Utilizar este método permite manter o atributo senha como private e sem getter
    public function verificarSenha(string $senha): bool
    {
        return password_verify($senha, $this->senhaHash);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPerfil(): Perfil
    {
        return $this->perfil;
    }
    
    public function getDataCriacao(): DateTimeInterface
    {
        return $this->dataCriacao;
    }
}
