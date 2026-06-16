<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Application;
use App\Bootstrap\ContainerFactory;
use App\Core\ApiResponse;

try {
    $container = ContainerFactory::create();

    $app = $container->get(Application::class);
    $app->run();

} catch (Throwable $e) { // para não retornar stacktrace
    error_log((string) $e);
    ApiResponse::erro('Erro interno no servidor');
}