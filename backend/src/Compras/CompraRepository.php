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
                        i.compra_id, 
                        i.valor_pago, 
                        c.id AS curso_id,
                        c.nome AS curso_nome
                    FROM itens_compra i 
                    JOIN cursos c ON i.curso_id = c.id 
                    WHERE i.compra_id = :compra_id";

        $stmt = $this->pdo->prepare($sql_itens);
        $stmt->execute([
            "compra_id" => $idCompra
        ]);

        $dadosItens = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $itens = $this->montarItensPorCompra($dadosItens);

        return $this->montarCompra($dadosCompra, $itens);
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

        // retorna array só com os IDs
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Retorna o conjunto de compras realizadas pelo usuário,
     * cada uma com seus respectivos itens.
     *
     * @param int $idUsuario
     * @return Compra[]
     */
    public function buscarComprasPorUsuarioId(int $idUsuario): array
    {
        $dadosCompras = $this->buscarComprasDoUsuario($idUsuario);

        if (!$dadosCompras) {
            return [];
        }

        $dadosItens = $this->buscarItensDoUsuario($idUsuario);
        $itensPorCompra = $this->montarItensPorCompra($dadosItens);

        return array_map(
            fn($compra) => $this->montarCompra($compra, $itensPorCompra),
            $dadosCompras
        );
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

    private function buscarComprasDoUsuario(int $usuarioId): array
    {
        $sql = "SELECT 
                    co.id, 
                    co.data_compra, 
                    co.valor_total
                FROM compras co
                WHERE co.usuario_id = :usuario_id
                ORDER BY data_compra DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            "usuario_id" => $usuarioId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function buscarItensDoUsuario(int $usuarioId): array
    {
        $sql = "SELECT 
                    ic.compra_id, 
                    c.id AS curso_id, 
                    c.nome AS curso_nome, 
                    ic.valor_pago
                FROM itens_compra ic
                JOIN cursos c ON c.id = ic.curso_id
                JOIN compras co ON co.id = ic.compra_id
                WHERE co.usuario_id = :usuario_id
                ORDER BY ic.compra_id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            "usuario_id" => $usuarioId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param array $dadosItens
     * @return array<int, ItemCompra[]>
     */
    private function montarItensPorCompra(array $dadosItens): array
    {
        $itensPorCompra = [];

        foreach ($dadosItens as $item) {
            $itensPorCompra[$item["compra_id"]][] = new ItemCompra(
                (int) $item["curso_id"],
                $item["curso_nome"],
                (float) $item["valor_pago"]
            );
        }

        return $itensPorCompra;
    }

    /**
     * @param array $dados
     * @param array<int, ItemCompra[]> $itensPorCompra
     * @return Compra
     */
    private function montarCompra(array $dados, array $itensPorCompra): Compra
    {
        try {
            $dataCompra = new DateTime($dados["data_compra"]);

        } catch (\DateMalformedStringException $e) {
            throw new \RuntimeException(
                "Data da compra inválida: compra " . (int) $dados["id"],
                previous: $e
            );
        }

        return new Compra(
            (int) $dados["id"],
            (float) $dados["valor_total"],
            $dataCompra,
            $itensPorCompra[$dados["id"]] ?? []
        );
    }
}