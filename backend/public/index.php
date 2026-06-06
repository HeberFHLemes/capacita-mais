<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Application;

try {
    (new Application())->run();

} catch (\Throwable $e) { // para não retornar stacktrace
    error_log((string) $e);

    http_response_code(500);

    echo json_encode([
        'erros' => [ 'Erro interno no servidor' ]
    ]);
}