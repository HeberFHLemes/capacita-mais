<?php declare(strict_types=1);

namespace App\Categorias;

use App\Categorias\Categoria;

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
            $dados['id'],
            $dados['nome'],
            $dados['nome_normalizado']
        );
    }

    public function buscarTodas(): array
    {
        $sql = "SELECT * FROM categorias";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$dados) {
            return [];
        }

        $categorias = [];

        foreach ($dados as $row) {
            $categorias[] = new Categoria(
                $row['id'],
                $row['nome'],
                $row['nome_normalizado']
            );
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
            $dados['id'],
            $dados['nome'],
            $dados['nome_normalizado']
        );
    }
}