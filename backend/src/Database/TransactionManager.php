<?php

namespace App\Database;

use PDO;
use Throwable;

/**
 * Para manipular transactions do BD, sem que camadas que não sejam
 * de Repository conheçam detalhes como PDO, commits e etc.
 */
class TransactionManager
{
    public function __construct(private PDO $pdo) {}

    public function start(): void
    {
        $this->pdo->beginTransaction();
    }

    /**
     * Executa uma operação (action) no contexto de uma transação,
     * com rollback caso exceções ou erros ocorram.
     *
     * @param callable $action
     * @return mixed
     * @throws Throwable
     */
    public function execute(callable $action): mixed
    {
        try {
            $this->start();

            $result = $action();

            $this->commit();

            return $result;

        } catch (Throwable $e) {
            $this->rollBack();
            throw $e;
        }
    }

    public function commit(): void
    {
        $this->pdo->commit();
    }

    public function rollback(): void
    {
        $this->pdo->rollBack();
    }
}