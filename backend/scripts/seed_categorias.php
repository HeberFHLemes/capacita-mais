<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Bootstrap\ContainerFactory;
use App\Categorias\CategoriaService;

$arquivoJson = __DIR__ . '/data/categorias.json';
$json = file_get_contents($arquivoJson);

if ($json === false) {
    die("Erro ao ler o arquivo JSON.\n");
}

$categorias = json_decode($json);

if (json_last_error() !== JSON_ERROR_NONE) {
    die("Erro no JSON: " . json_last_error_msg() . "\n");
}

try {
    $container = ContainerFactory::create();
    $categoriaService = $container->get(CategoriaService::class);

    foreach ($categorias as $nomeCategoria) {
        $categoriaService->criar($nomeCategoria);
    }
} catch (Throwable $e) {
    die($e->getMessage());
}

echo "Categorias cadastradas com sucesso!\n";