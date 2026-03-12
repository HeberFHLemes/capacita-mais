<?php

require_once dirname(__DIR__) . '/database/Database.php';

function iniciar_sessao(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function conferir_auth(): void {
    iniciar_sessao();

    if (empty($_SESSION['admin_id'])) {
        header('Location: /login.php');
        exit;
    }
}

function autenticar(): string {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return '';

    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $senha = trim($_POST['senha'] ?? '');

    if (!$email || !$senha) {
        return 'E-mail ou senha inválidos.';
    }

    iniciar_sessao();

    // TODO: validar com banco de dados
    if (isUsuarioCadastrado($email, $senha)) {
        $_SESSION['admin_id'] = 1;

        header('Location: /cadastro.php');
        exit;
    }

    return 'E-mail ou senha inválidos.';
}
