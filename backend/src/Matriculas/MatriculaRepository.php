<?php declare(strict_types=1);

namespace App\Matriculas;

use App\Compras\CompraRepository;
use DateTime;
use PDO;

class MatriculaRepository
{
    public function __construct(private PDO $pdo) {}

    /**
     * Retorna os cursos adquiridos pelo usuário, com id, nome e a data da compra.
     *
     * @param int $usuarioId
     * @return CursoMatriculado[]
     */
    public function buscarMatriculasDoUsuario(int $usuarioId): array
    {
        // GROUP BY no id e no nome do curso, com MIN na data da compra,
        // para evitar o caso (raro) de ter o mesmo curso em duas compras diferentes.
        $sql = "SELECT 
                    c.id,
                    c.nome,
                    MIN(co.data_compra) AS data_compra
                FROM cursos c
                JOIN itens_compra ic ON ic.curso_id = c.id
                JOIN compras co ON co.id = ic.compra_id
                WHERE co.usuario_id = :usuario_id
                GROUP BY c.id, c.nome
                ORDER BY data_compra DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ":usuario_id" => $usuarioId
        ]);

        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $cursos = [];

        foreach ($dados as $dado) {
            try {
                $dataCompra = new DateTime($dado["data_compra"]);

            } catch (\DateMalformedStringException $e) {
                throw new \RuntimeException(
                    "Erro ao converter data da compra",
                    previous: $e
                );
            }

            $cursos[] = new CursoMatriculado(
                (int) $dado['id'],
                $dado['nome'],
                $dataCompra,
            );
        }

        return $cursos;
    }
}