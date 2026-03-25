<?php declare(strict_types=1);

namespace App\Plataformas;

use App\Plataformas\Plataforma;
use App\Utils\Normalizador;

use PDO;

class PlataformaRepository
{
    public function __construct(private PDO $conexao) {}

    public function buscarOuCriar(string $nome): Plataforma
    {
        $normalizado = Normalizador::normalizarTexto($nome);

        $plataforma = $this->buscarPorNormalizado($normalizado);

        if ($plataforma) {
            return $plataforma;
        }

        try {
            return $this->criar($nome, $normalizado);
        } catch (\PDOException $e) {
            // caso já foi inserido (outra requisição/unique)
            $plataforma = $this->buscarPorNormalizado($normalizado);
            if ($plataforma === null) {
                throw $e;
            }
            return $plataforma;
        }
    }

    public function criar(string $nome, string $nome_normalizado): Plataforma
    {
        $sql = "INSERT INTO plataformas (nome, nome_normalizado)
                VALUES (:nome, :nome_normalizado)";
        
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':nome_normalizado' => $nome_normalizado
        ]);

        $id = (int) $this->conexao->lastInsertId();

        return new Plataforma($id, $nome);
    }

    public function buscarPorNormalizado(string $normalizado): ?Plataforma
    {
        $sql = "SELECT id, nome FROM plataformas WHERE nome_normalizado = :normalizado";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([':normalizado' => $normalizado]);

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$dados) {
            return null;
        }

        return new Plataforma(
            $dados['id'],
            $dados['nome']
        );
    }
}