<?php

$seeders = ['categorias', 'cursos', 'usuario'];

foreach ($seeders as $seeder) {
    echo '--- Cadastrando: ' . $seeder . ' ---' . PHP_EOL;
    include __DIR__ . '/seed_' . $seeder . '.php';
}
