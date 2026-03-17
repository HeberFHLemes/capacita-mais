<?php

namespace App\Plataformas;

use App\Plataformas\Plataforma;
use App\Database\Conexao;
use App\Utils\Normalizador;

use PDO;

class PlataformaRepository
{
    private PDO $conexao;

    public function __construct()
    {
        $this->conexao = Conexao::getInstance();
    }

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
            return $this->buscarPorNormalizado($normalizado);
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

        $id = $this->conexao->lastInsertId();

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