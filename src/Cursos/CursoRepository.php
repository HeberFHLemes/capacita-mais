<?php

namespace App\Cursos;

use App\Database\Conexao;

use PDO;

class CursoRepository
{
    private PDO $conexao;

    public function __construct()
    {
        $this->conexao = Conexao::getInstance();
    }

    public function buscarTodos(): array
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
                'categoria'=> $row['categoria_nome'],
                'plataforma' => $row['plataforma_nome']
            ];
        }

        return $cursos;
    }

    public function criar(
        string $nome,
        string $descricao,
        int $categoriaId,
        int $plataformaId,
        string $url,
        bool $gratuito
    ): Curso
    {
        $sql = "INSERT INTO cursos (nome, descricao, categoria_id, plataforma_id, url, gratuito)
                VALUES (:nome, :descricao, :categoria_id, :plataforma_id, :url, :gratuito)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->execute([
            ':nome' => $nome,
            ':descricao' => $descricao,
            ':categoria_id' => $categoriaId,
            ':plataforma_id' => $plataformaId,
            ':url' => $url,
            ':gratuito' => $gratuito
        ]);

        $id = $this->conexao->lastInsertId();

        return new Curso(
            $id,
            $nome,
            $descricao,
            $categoriaId,
            $plataformaId,
            $url,
            $gratuito
        );
    }
}