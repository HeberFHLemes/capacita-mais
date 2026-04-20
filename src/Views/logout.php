<?php
    require_once __DIR__ . '/../../vendor/autoload.php';

    use App\Auth\AuthService;

    $authService = new AuthService();
    $authService->logout();

    header("Location: /login");
    exit();
?>