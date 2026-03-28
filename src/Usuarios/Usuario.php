<?php declare(strict_types=1);

namespace App\Usuarios;

class Usuario 
{
    private int $id;
    private string $email;
    private string $senhaHash;
    private string $role = "ROLE_ADMIN";
    
    public function __construct(
        int $id,
        string $email,
        string $senha
    ) {
        $this->id = $id;    
        $this->email = $email;
        $this->senhaHash = $senha;
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

    public function getRole(): string
    {
        return $this->role;
    }
}
