<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$routes = [
  '/' => '/home.php',
  '/cursos' => '/cursos.php',
  '/sobre' => '/sobre.php',
  '/login' => '/login.php',
  '/logout' => '/logout.php',
  '/cadastro' => '/cadastro.php',
  '/edicao' => '/edicao.php',
  '/remocao' => '/remocao.php',
];

if (array_key_exists($uri, $routes)) {
  require __DIR__ . $routes[$uri];
} else {
  http_response_code(404);
  require __DIR__ . '/404.php';
}
