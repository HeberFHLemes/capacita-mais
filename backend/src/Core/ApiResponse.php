<?php declare(strict_types=1);

namespace App\Core;

final class ApiResponse
{
    private function __construct() {}

    public static function json(mixed $dados, int $status = 200): never
    {
        http_response_code($status);
        echo json_encode($dados);
        exit;
    }

    public static function erro(string $mensagem, int $status = 500, array $erros = []): never
    {
        self::json(new ErrorResponse($mensagem, $erros), $status);
    }
}