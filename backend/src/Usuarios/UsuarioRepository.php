<?php declare(strict_types=1);

namespace App\Usuarios;

use App\Usuarios\Exceptions\EmailJaCadastradoException;

use PDO;
use PDOException;

class UsuarioRepository
{
    public function __construct(private PDO $conexao) {}

    public function cadastrarUsuario(
        string $nome,
        string $email,
        string $senhaHash
    ): int {
        $sql = "INSERT INTO usuarios (nome, email, senha, perfil) 
            VALUES (:nome, :email, :senha, :perfil)";

        $stmt = $this->conexao->prepare($sql);

        try {
            $stmt->execute([
                'nome' => $nome,
                'email' => $email,
                'senha' => $senhaHash,
                'perfil' => Perfil::COMUM->value
            ]);
        } catch (PDOException $e) {
            // tratar erro de campos UNIQUE (email)
            if ($e->errorInfo[1] === 1062) {
                throw new EmailJaCadastradoException("Usuário já cadastrado");
            }
            throw $e;
        }

        return (int) $this->conexao->lastInsertId();
    }

    public function buscarPorId(int $id): ?Usuario
    {
        $sql = "SELECT * FROM usuarios WHERE id = :id";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$dados) {
            return null;
        }

        return $this->montarUsuario($dados);
    }

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

        return $this->montarUsuario($dados);
    }

    public function emailExiste(string $email): bool
    {
        $sql = "SELECT 1 FROM usuarios WHERE email = :email";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([
            'email' => $email
        ]);

        return $stmt->fetchColumn() !== false;
    }

    private function montarUsuario(array $dados): Usuario
    {
        try {
            $dataCriacao = new \DateTimeImmutable($dados["data_criacao"]);

        } catch (\DateMalformedStringException $e) {
            throw new \RuntimeException(
                "Erro ao converter data de criação da conta do usuário",
                previous: $e
            );
        }

        return new Usuario(
            $dados['id'],
            $dados['nome'],
            $dados['email'],
            $dados['senha'],
            Perfil::from($dados['perfil']),
            $dataCriacao
        );
    }
}