<?php declare(strict_types=1);

namespace App\Usuarios;

use DateTime;
use PDO;

class UsuarioRepository
{
    public function __construct(private PDO $conexao) {}

    public function buscarPorEmail(string $email): ?Usuario
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email";

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
            $dados['nome'],
            $dados['email'],
            $dados['senha'],
            Perfil::from($dados['perfil']),
            new DateTime($dados['data_criacao'])
        );
    }
}