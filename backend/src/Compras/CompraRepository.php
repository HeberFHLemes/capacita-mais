<?php declare(strict_types=1);

namespace App\Compras;

use App\Compras\Exceptions\CompraNaoEncontrada;

use DateTime;
use PDO;

class CompraRepository
{
    public function __construct(private PDO $pdo) {}

    /**
     * Busca dados de uma compra em específico.
     *
     * @param int $idCompra
     * @return Compra
     */
    public function buscarCompraPorId(int $idCompra): Compra
    {
        $sql = "SELECT 
                    co.id, 
                    co.valor_total, 
                    co.data_compra 
                FROM compras co 
                WHERE co.id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            "id" => $idCompra
        ]);

        $dadosCompra = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$dadosCompra) {
            throw new CompraNaoEncontrada();
        }

        $sql_itens = "SELECT 
                        c.id, 
                        i.valor_pago, 
                        c.nome
                    FROM itens_compra i 
                    JOIN cursos c ON i.curso_id = c.id 
                    WHERE i.compra_id = :compra_id";

        $stmt = $this->pdo->prepare($sql_itens);
        $stmt->execute([
            "compra_id" => $idCompra
        ]);

        $dadosItens = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $itens = [];
        foreach ($dadosItens as $item) {
            $itens[] = new ItemCompra(
                (int) $item['id'],
                $item['nome'],
                (float) $item['valor_pago']
            );
        }

        try {
            $dataCompra = new DateTime($dadosCompra["data_compra"]);

        } catch (\DateMalformedStringException $e) {
            throw new \RuntimeException(
                "Data da compra inválida: compra " . $idCompra,
                previous: $e
            );
        }

        return new Compra(
            (int) $dadosCompra['id'],
            (float) $dadosCompra['valor_total'],
            $dataCompra,
            $itens
        );
    }

    /**
     * Retorna os IDs dos cursos já comprados pelo usuário.
     *
     * @param int $usuarioId
     * @return int[]
     */
    public function buscarItensCompradosPeloUsuario(int $usuarioId): array
    {
        $sql = "SELECT i.curso_id FROM itens_compra i
                JOIN compras co ON co.id = i.compra_id
                WHERE usuario_id = :usuario_id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            "usuario_id" => $usuarioId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * TODO: buscar o conjunto de compras realizadas por um usuário específico.
     *
     * @param int $idUsuario
     * @return array
     */
    public function buscarComprasPorUsuarioId(int $idUsuario): array
    {
        // TODO
        return [];
    }

    /**
     * Insere um registro na tabela compras,
     * para preparar a inserção dos registros de itens_compra.
     *
     * Deve receber valores já validados (valor total).
     *
     * @param int $usuarioId
     * @param float $valorTotal
     * @return int
     */
    public function criarCompra(int $usuarioId, float $valorTotal): int
    {
        $sql = "INSERT INTO compras (usuario_id, valor_total) 
                VALUES (:usuario_id, :valor_total)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            "usuario_id" => $usuarioId,
            "valor_total" => $valorTotal
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Insere um registro na tabela itens_compra.
     * Deve receber valores já validados.
     *
     * @param int $compraId
     * @param int $cursoId
     * @param float $cursoPreco
     * @return void
     */
    public function criarItemCompra(int $compraId, int $cursoId, float $cursoPreco): void
    {
        $sql = "INSERT INTO itens_compra (compra_id, curso_id, valor_pago)
                VALUES (:compra_id, :curso_id, :valor_pago)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            "compra_id" => $compraId,
            "curso_id" => $cursoId,
            "valor_pago" => $cursoPreco
        ]);
    }
}