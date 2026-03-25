<?php declare(strict_types=1);

namespace App\Utils;

use Dotenv\Dotenv;

use RuntimeException;

/**
 * Classe para facilitar a manipulação de variáveis de ambiente.
 */
class Env
{
    private static bool $loaded = false; // para dotenv (biblioteca)

    /**
     * Carrega o arquivo de variáveis de ambiente (.env)
     */
    private static function load(): void
    {
        if (self::$loaded) return;

        if (file_exists(__DIR__ . '/../../.env')) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
            $dotenv->load();
        }
        self::$loaded = true;
    }

    /**
     * Lê o valor de uma variável de ambiente `key`,
     * ou retorna um valor `default` caso seja definido um valor
     * padrão de retorno.
     */
    public static function get(string $key, ?string $default = null): string
    {
        self::load();

        // busca a variável de ambiente
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? null;

        if ($value === false || $value === null) {
            if ($default !== null) {
                return $default;
            }
            throw new RuntimeException("Variável de ambiente [{$key}] não definida.");
        }
        return $value;
    }
}