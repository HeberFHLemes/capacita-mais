<?php
/*
 * Para criar alguns registros de cursos iniciais,
 * o que é um pouco mais verboso no SQL por conta dos
 * relacionamento, então utiliza-se da lógica já preparada
 * da aplicação.
 * 
 * USO (Banco de dados já deve estar funcionando):
 * - docker compose exec [serviço do php] php scripts/seed_cursos.php
 * - php scripts/seed_cursos.php
 */
require_once __DIR__ . '/../vendor/autoload.php';

use App\Database\Conexao;
use App\Cursos\CursoService;

$pdo = Conexao::getInstance();

$cursoService = CursoService::with($pdo);

// verifica se já há registro na tabela cursos,
// se houver pelo menos um, NÃO executa...
$stmt = $pdo->prepare("SELECT id FROM cursos LIMIT 1");
$stmt->execute();

if ($stmt->fetch()) {
    echo "Já existem cursos cadastrados.\n";
    exit;
}

// antigo public/data/cursos.json
$arquivoJson = __DIR__ . '/data/cursos.json';

$json = file_get_contents($arquivoJson);

if ($json === false) {
    die("Erro ao ler o arquivo JSON.\n");
}

$cursosDados = json_decode($json, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die("Erro no JSON: " . json_last_error_msg() . "\n");
}

// inserts
foreach ($cursosDados as $curso) {
    $cursoService->criar(
        $curso['titulo'],
        $curso['descricao'],
        $curso['categoria'],
        $curso['plataforma'],
        $curso['url'],
        (bool) $curso['gratuito']
    );
}

echo "Cursos cadastrados com sucesso!\n";