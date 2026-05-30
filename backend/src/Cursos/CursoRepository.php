<?php declare(strict_types=1);

namespace App\Cursos;

use PDO;
use PDOException;

use App\Cursos\Exceptions\CursoDuplicadoException;

class CursoRepository
{
    public function __construct(private PDO $conexao) {}

    public function buscarPorId(int $id): ?Curso
    {
        $sql = "SELECT c.*, cat.nome AS categoria_nome
            FROM cursos c
            JOIN categorias cat ON c.categoria_id = cat.id
            WHERE c.id = :id
        ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        return new Curso(
            $row['id'],
            $row['nome'],
            $row['descricao'],
            $row['categoria_nome'],
            $row['nivel'],
            (float) $row['preco'],
            (float) $row['preco_original'],
            (bool) $row['em_destaque']
        );
    }

    /**
     * @return Curso[]
     */
    public function buscarTodos(): array
    {
        $sql = "SELECT c.*, cat.nome AS categoria_nome
            FROM cursos c
            JOIN categorias cat ON c.categoria_id = cat.id
        ";

        $stmt = $this->conexao->query($sql);
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $cursos = [];

        foreach ($dados as $row) {
            $cursos[] = new Curso(
                $row['id'],
                $row['nome'],
                $row['descricao'],
                $row['categoria_nome'],
                $row['nivel'],
                (float) $row['preco'],
                (float) $row['preco_original'],
                (bool) $row['em_destaque']
            );
        }

        return $cursos;
    }

    public function buscarCursosEmDestaque(): array
    {
        $sql = "SELECT c.*, cat.nome AS categoria_nome
            FROM cursos c
            JOIN categorias cat ON c.categoria_id = cat.id
            WHERE c.em_destaque = 1
        ";

        $stmt = $this->conexao->query($sql);
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $cursos = [];

        foreach ($dados as $row) {
            $cursos[] = new Curso(
                $row['id'],
                $row['nome'],
                $row['descricao'],
                $row['categoria_nome'],
                $row['nivel'],
                (float) $row['preco'],
                (float) $row['preco_original'],
                (bool) $row['em_destaque']
            );
        }

        return $cursos;
    }

    public function criar(
        string $nome,
        ?string $descricao,
        int $categoriaId,
        string $nivel,
        float $preco,
        float $precoOriginal,
        bool $emDestaque
    ): int
    {
        $sql = "INSERT INTO cursos (nome, descricao, categoria_id, nivel, preco, preco_original, em_destaque)
                VALUES (:nome, :descricao, :categoria_id, :nivel, :preco, :preco_original, :em_destaque)";

        $stmt = $this->conexao->prepare($sql);

        try {
            $stmt->execute([
                ':nome' => $nome,
                ':descricao' => $descricao,
                ':categoria_id' => $categoriaId,
                ':nivel' => $nivel,
                ':preco' => $preco,
                ':preco_original' => $precoOriginal,
                ':em_destaque' => (int) $emDestaque
            ]);
        } catch (PDOException $e) {
            // tratar erro de campos UNIQUE. 
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
        string $nivel,
        float $preco,
        float $precoOriginal,
        bool $emDestaque
    ): bool {
        $sql = "UPDATE cursos 
                SET nome = :nome,
                    descricao = :descricao,
                    categoria_id = :categoria_id,
                    nivel = :nivel,
                    preco = :preco,
                    preco_original = :preco_original,
                    em_destaque = :em_destaque
                WHERE id = :id";

        $stmt = $this->conexao->prepare($sql);

        try {
            $stmt->execute([
                ':id' => $id,
                ':nome' => $nome,
                ':descricao' => $descricao,
                ':categoria_id' => $categoriaId,
                ':nivel' => $nivel,
                ':preco' => $preco,
                ':preco_original' => $precoOriginal,
                ':em_destaque' => (int) $emDestaque
            ]);
        } catch (PDOException $e) {
            // tratar erro de campos UNIQUE
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