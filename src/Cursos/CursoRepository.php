<?php declare(strict_types=1);

namespace App\Cursos;

use PDO;
use PDOException;

use App\Cursos\Exceptions\CursoDuplicadoException;

class CursoRepository
{
    public function __construct(private PDO $conexao) {}

    public function buscarPorId(int $id): ?array  // array associativo
    {
        $sql = "SELECT c.*, cat.nome AS categoria_nome, p.nome AS plataforma_nome
            FROM cursos c
            JOIN categorias cat ON c.categoria_id = cat.id
            JOIN plataformas p ON c.plataforma_id = p.id
            WHERE c.id = :id
        ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        return [
            'id' => $row['id'],
            'nome' => $row['nome'],
            'descricao' => $row['descricao'],
            'url' => $row['url'],
            'gratuito' => (bool) $row['gratuito'],
            'categoria' => $row['categoria_nome'],
            'plataforma' => $row['plataforma_nome']
        ];
    }

    public function buscarTodos(): array // array associativo
    {
        $sql = "SELECT c.*, cat.nome AS categoria_nome, p.nome AS plataforma_nome
            FROM cursos c
            JOIN categorias cat ON c.categoria_id = cat.id
            JOIN plataformas p ON c.plataforma_id = p.id
        ";

        $stmt = $this->conexao->query($sql);
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $cursos = [];

        foreach ($dados as $row) {
            $cursos[] = [
                'id' => $row['id'],
                'nome' => $row['nome'],
                'descricao' => $row['descricao'],
                'url' => $row['url'],
                'gratuito' => (bool) $row['gratuito'],
                'categoria' => $row['categoria_nome'],
                'plataforma' => $row['plataforma_nome']
            ];
        }

        return $cursos;
    }

    public function criar(
        string $nome,
        ?string $descricao,
        int $categoriaId,
        int $plataformaId,
        string $url,
        bool $gratuito
    ): int
    {
        $sql = "INSERT INTO cursos (nome, descricao, categoria_id, plataforma_id, url, gratuito)
                VALUES (:nome, :descricao, :categoria_id, :plataforma_id, :url, :gratuito)";

        $stmt = $this->conexao->prepare($sql);

        try {
            $stmt->execute([
                ':nome' => $nome,
                ':descricao' => $descricao,
                ':categoria_id' => $categoriaId,
                ':plataforma_id' => $plataformaId,
                ':url' => $url,
                ':gratuito' => (int) $gratuito // MariaDB trata como int
            ]);
        } catch (PDOException $e) {
            // tratar erro de campos UNIQUE (nome + plataforma)
            // erro: 1062; ER_DUP_ENTRY; SQLSTATE: 23000
            // fonte: https://dev.mysql.com/doc/mysql-errors/9.6/en/server-error-reference.html
            if ($e->errorInfo[1] === 1062) {
                throw new CursoDuplicadoException();
            }
            throw $e;
        }

        return (int) $this->conexao->lastInsertId();
    }

    public function atualizar(
        int $id, 
        string $nome, 
        ?string $descricao, 
        int $categoriaId, 
        int $plataformaId, 
        string $url, 
        bool $gratuito
    ): bool {
        $sql = "UPDATE cursos 
                SET nome = :nome,
                    descricao = :descricao,
                    categoria_id = :categoria_id,
                    plataforma_id = :plataforma_id,
                    url = :url,
                    gratuito = :gratuito
                WHERE id = :id";

        $stmt = $this->conexao->prepare($sql);

        try {
            $stmt->execute([
                ':id' => $id,
                ':nome' => $nome,
                ':descricao' => $descricao,
                ':categoria_id' => $categoriaId,
                ':plataforma_id' => $plataformaId,
                ':url' => $url,
                ':gratuito' => (int) $gratuito
            ]);
        } catch (PDOException $e) {
            // tratar erro de campos UNIQUE (nome + plataforma)
            if ($e->errorInfo[1] === 1062) {
                throw new CursoDuplicadoException();
            }
            throw $e;
        }

        return $stmt->rowCount() > 0;
    }

    public function remover(int $id): bool
    {
        $sql = "DELETE FROM cursos WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);

        $stmt->execute([':id' => $id]);

        return $stmt->rowCount() > 0;
    }
}