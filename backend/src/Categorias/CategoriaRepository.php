<?php declare(strict_types=1);

namespace App\Categorias;

use App\Categorias\Categoria;
use App\Utils\Normalizador;

use PDO;

class CategoriaRepository
{

    public function __construct(private PDO $conexao) {}

    public function buscarOuCriar(string $nome): Categoria
    {
        $normalizado = Normalizador::normalizarTexto($nome);

        $categoria = $this->buscarPorNormalizado($normalizado);

        if ($categoria) {
            return $categoria;
        }

        try {
            return $this->criar($nome, $normalizado);
        } catch (\PDOException $e) {
            // caso já foi inserido (outra requisição/unique)
            $categoria = $this->buscarPorNormalizado($normalizado);
            if ($categoria === null) {
                throw $e;
            }
            return $categoria;
        }
    }

    public function criar(string $nome, string $nome_normalizado): Categoria
    {
        $sql = "INSERT INTO categorias (nome, nome_normalizado)
                VALUES (:nome, :nome_normalizado)";
        
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':nome_normalizado' => $nome_normalizado
        ]);

        $id = (int) $this->conexao->lastInsertId();

        return new Categoria($id, $nome);
    }

    public function buscarPorNormalizado(string $normalizado): ?Categoria
    {
        $sql = "SELECT id, nome FROM categorias WHERE nome_normalizado = :normalizado";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([':normalizado' => $normalizado]);

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$dados) {
            return null;
        }

        return new Categoria(
            $dados['id'],
            $dados['nome']
        );
    }
}