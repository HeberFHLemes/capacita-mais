<?php declare(strict_types=1);

namespace App\Usuarios;

class Usuario 
{
    private int $id;
    private string $email;
    private string $senhaHash;
    private string $perfil;
    
    public function __construct(
        int $id,
        string $email,
        string $senha,
        string $perfil
    ) {
        $this->id = $id;    
        $this->email = $email;
        $this->senhaHash = $senha;
        $this->perfil = $perfil;
    }
    
    // Utilizar este método permite manter o atributo senha como private
    public function verificarSenha(string $senha): bool
    {
        return password_verify($senha, $this->senhaHash);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPerfil(): string
    {
        return $this->perfil;
    }
}
