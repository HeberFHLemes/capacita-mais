<?php
/*
 * Para criar alguns registros de cursos iniciais,
 * o que é um pouco mais verboso no SQL por conta dos
 * relacionamentos, então utiliza-se da lógica já preparada
 * da aplicação.
 * 
 * Uso: php [DIR]/seed_cursos.php [--com-categorias]
 */
$comCategorias = in_array('--com-categorias', $argv);

if ($comCategorias) {
    include __DIR__ . '/seed_categorias.php';
}

require_once __DIR__ . '/../vendor/autoload.php';

use App\Bootstrap\ContainerFactory;
use App\Cursos\CursoService;

try {
    $container = ContainerFactory::create();

    $pdo = $container->get(PDO::class);

    // verifica se já há registro na tabela cursos,
    // se houver pelo menos um, NÃO executa...
    $stmt = $pdo->prepare("SELECT id FROM cursos LIMIT 1");
    $stmt->execute();

    if ($stmt->fetch()) {
        echo "Já existem cursos cadastrados.\n";
        return;
    }

    $arquivoJson = __DIR__ . '/data/cursos.json';

    $json = file_get_contents($arquivoJson);

    if ($json === false) {
        die("Erro ao ler o arquivo JSON.\n");
    }

    $cursosDados = json_decode($json, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        die("Erro no JSON: " . json_last_error_msg() . "\n");
    }

    $cursoService = $container->get(CursoService::class);

    // inserts
    foreach ($cursosDados as $curso) {
        $cursoService->criar(
            $curso['nome'],
            $curso['descricao'],
            (int) $curso['categoria_id'],
            $curso['nivel'],
            (float) $curso['preco'],
            (float) $curso['preco_original'],
            (bool) $curso['em_destaque']
        );
    }

    echo "Cursos cadastrados com sucesso!\n";

} catch (Throwable $e) {
    die($e->getMessage());
}