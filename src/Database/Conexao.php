<?php declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOException;

// Adaptado da UA "Padrões de Projeto PHP" - Livro
class Conexao 
{
    private static ?PDO $instance = null;

    private function __construct() {}

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO(
                    'mysql:' . 
                    'host=' . getenv("DB_HOST") . ';' .
                    'dbname=' . getenv("DB_DATABASE") . ';' .
                    'charset=utf8mb4',
                    getenv("DB_USER"),
                    getenv("DB_PASSWORD"),
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                throw new \RuntimeException("Erro ao tentar se conectar ao banco de dados", previous: $e);
            }
        }
        return self::$instance;
    }
}

?>