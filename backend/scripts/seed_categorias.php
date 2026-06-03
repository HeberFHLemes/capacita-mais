<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Categorias\CategoriaRepository;
use App\Database\Conexao;
use App\Categorias\CategoriaService;

$categoriaService = new CategoriaService(
    new CategoriaRepository(Conexao::getInstance())
);

$arquivoJson = __DIR__ . '/data/categorias.json';
$json = file_get_contents($arquivoJson);

if ($json === false) {
    die("Erro ao ler o arquivo JSON.\n");
}

$categorias = json_decode($json);

if (json_last_error() !== JSON_ERROR_NONE) {
    die("Erro no JSON: " . json_last_error_msg() . "\n");
}

foreach ($categorias as $nomeCategoria) {
    $categoriaService->criar($nomeCategoria);
}

echo "Categorias cadastradas com sucesso!\n";