<?php
/*
 * Cadastrar usuário (admin) por script, com variáveis de ambiente.
 * USO (Banco de dados já deve estar funcionando):
 * - docker compose exec [serviço do php] php scripts/seed_usuario.php
 * - php scripts/seed_usuario.php
 * 
 * https://pt.stackoverflow.com/questions/126770/o-que-%C3%A9-e-para-que-serve-um-seeder
 */ 
require_once __DIR__ . '/../vendor/autoload.php';

use App\Database\Conexao;
use App\Utils\Env;

$pdo = Conexao::getInstance();

$email = Env::get('USUARIO_EMAIL');

// Verifica se já existe
$stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
$stmt->execute([':email' => $email]);

if ($stmt->fetch()) {
    echo "Usuário já existe.\n";
    exit;
}

$senha = password_hash(Env::get('USUARIO_SENHA'), PASSWORD_DEFAULT);

$stmt = $pdo->prepare("
    INSERT INTO usuarios (email, senha)
    VALUES (:email, :senha)
");

$sucesso = $stmt->execute([
    ':email' => $email,
    ':senha' => $senha
]);

if ($sucesso) {
    echo "Usuário criado com sucesso!\n";
} else {
    echo "Não foi possível criar usuário...\n";
}