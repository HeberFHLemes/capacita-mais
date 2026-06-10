<?php declare(strict_types=1);

namespace App\Categorias;

use PDO;

class CategoriaRepository
{
    public function __construct(private PDO $conexao) {}

    public function buscarPorId(int $id): ?Categoria
    {
        $sql = "SELECT * FROM categorias WHERE id = :id";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([':id' => $id]);

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$dados) {
            return null;
        }

        return new Categoria(
            (int) $dados['id'],
            $dados['nome'],
            $dados['nome_normalizado']
        );
    }

    public function buscarTodas(): array
    {
        $sql = "SELECT
                    cat.id,
                    cat.nome,
                    cat.nome_normalizado,
                    COUNT(c.id) AS quantidade_cursos
                FROM categorias cat
                LEFT JOIN cursos c
                    ON c.categoria_id = cat.id
                GROUP BY
                    cat.id,
                    cat.nome,
                    cat.nome_normalizado
                ORDER BY cat.nome"; // ordenadas alfabeticamente

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();

        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$dados) {
            return [];
        }

        $categorias = [];

        foreach ($dados as $row) {
            $categorias[] = [
                'id' => (int) $row['id'],
                'nome' => $row['nome'],
                'nome_normalizado' => $row['nome_normalizado'],
                'quantidade_cursos' => (int) $row['quantidade_cursos']
            ];
        }

        return $categorias;
    }

    public function criar(string $nome, string $nomeNormalizado): Categoria
    {
        $sql = "INSERT INTO categorias (nome, nome_normalizado)
                VALUES (:nome, :nome_normalizado)";
        
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':nome_normalizado' => $nomeNormalizado
        ]);

        $id = (int) $this->conexao->lastInsertId();

        return new Categoria($id, $nome, $nomeNormalizado);
    }

    public function buscarPorNormalizado(string $nomeNormalizado): ?Categoria
    {
        $sql = "SELECT * FROM categorias WHERE nome_normalizado = :nome_normalizado";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([':nome_normalizado' => $nomeNormalizado]);

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$dados) {
            return null;
        }

        return new Categoria(
            (int) $dados['id'],
            $dados['nome'],
            $dados['nome_normalizado']
        );
    }
}