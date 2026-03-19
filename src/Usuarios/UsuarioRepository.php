<?php declare(strict_types=1);

namespace App\Usuarios;

use PDO;

class UsuarioRepository
{
    public function __construct(private PDO $conexao) {}

    public function buscarPorEmail(string $email): ?Usuario
    {
        $sql = "SELECT id, email, senha FROM usuarios WHERE email = :email";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([
            'email' => $email
        ]);

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$dados) {
            return null;
        }

        return new Usuario(
            $dados['id'],
            $dados['email'],
            $dados['senha']
        );
    }
}