<?php declare(strict_types=1);

namespace App\Carrinhos;

use App\Carrinhos\Exceptions\ItemCarrinhoJaExisteException;
use App\Carrinhos\Exceptions\ItemCarrinhoNaoEncontradoException;

use App\Cursos\Exceptions\CursoNaoEncontradoException;

use PDO;
use PDOException;

class CarrinhoRepository
{
    public function __construct(private PDO $conexao) {}

    public function buscarCarrinhoPorUsuario(int $usuarioId): Carrinho
    {
        // Realizando duas consultas separadas:
        // uma pro conjunto de itens, outra pro total.
        $itens = $this->buscarItens($usuarioId);
        $total = $this->buscarTotal($usuarioId);

        return new Carrinho($total, $itens);
    }

    public function buscarTotal(int $usuarioId): float
    {
        $sql = "SELECT 
                COALESCE(SUM(c.preco), 0) AS total 
                FROM itens_carrinho ic
                JOIN cursos c ON c.id = ic.curso_id
                WHERE ic.usuario_id = :usuarioId
        ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([':usuarioId' => $usuarioId]);

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        return (float) $dados['total'];
    }

    /**
     * @param int $usuarioId
     * @return ItemCarrinho[]
     */
    public function buscarItens(int $usuarioId): array
    {
        $sql = "SELECT 
                c.id, 
                c.nome, 
                c.preco
            FROM itens_carrinho ic
            JOIN cursos c ON c.id = ic.curso_id
            WHERE ic.usuario_id = :usuarioId
        ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([':usuarioId' => $usuarioId]);

        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $itens = [];

        foreach ($dados as $row) {
            $itens[] = new ItemCarrinho(
                (int) $row['id'],
                $row['nome'],
                (float) $row['preco']
            );
        }

        return $itens;
    }

    public function buscarItem(int $usuarioId, int $cursoId): ItemCarrinho
    {
        $sql = "SELECT 
                c.id, 
                c.nome, 
                c.preco
            FROM itens_carrinho ic
            JOIN cursos c ON c.id = ic.curso_id
            WHERE ic.usuario_id = :usuarioId AND ic.curso_id = :cursoId
        ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([
            ':usuarioId' => $usuarioId,
            ':cursoId' => $cursoId
        ]);

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$dados) {
            throw new ItemCarrinhoNaoEncontradoException();
        }

        return new ItemCarrinho(
            (int) $dados['id'],
            $dados['nome'],
            (float) $dados['preco']
        );
    }

    public function inserirItem(int $usuarioId, int $cursoId): void
    {
        $sql = "INSERT INTO itens_carrinho (usuario_id, curso_id) 
                VALUES (:usuarioId, :cursoId)
        ";

        $stmt = $this->conexao->prepare($sql);

        try {
            $stmt->execute([
                ':usuarioId' => $usuarioId,
                ':cursoId' => $cursoId
            ]);
        } catch (PDOException $e) {

            $errorInfo = $e->errorInfo[1] ?? null;
            if ($errorInfo === 1062) {
                // Violação de UNIQUE
                throw new ItemCarrinhoJaExisteException();

            } else if ($errorInfo === 1452) {
                // Violação de chave estrangeira (usuario_id ou curso_id)
                // Como o usuario_id vem do JWT (autenticado),
                // assume-se que o problema esteja no curso.
                throw new CursoNaoEncontradoException();
            }
            throw $e;
        }

        // diferente dos outros repositories da aplicação,
        // por ser chave conjunta não se retorna o lastInsertId aqui
        // (já se conhece os ids para busca).
    }

    public function removerItem(int $usuarioId, int $cursoId): bool
    {
        $sql = "DELETE FROM itens_carrinho WHERE curso_id = :cursoId AND usuario_id = :usuarioId";
        $stmt = $this->conexao->prepare($sql);

        $stmt->execute([
            ':usuarioId' => $usuarioId,
            ':cursoId' => $cursoId
        ]);

        return $stmt->rowCount() > 0;
    }

    /**
     * Remove todos os registros da tabela itens_carrinho de um usuário específico
     *
     * @param int $usuarioId
     * @return void
     */
    public function limparCarrinho(int $usuarioId): void
    {
        $sql = "DELETE FROM itens_carrinho WHERE usuario_id = :usuario_id";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([
            ':usuario_id' => $usuarioId
        ]);
    }
}