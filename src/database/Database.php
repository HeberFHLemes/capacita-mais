<?php

require_once dirname(__DIR__) . '/models/Curso.php';

// TODO: implementar conexão com banco de dados real,
//       apenas testando por enquanto...

// TODO: implementar query no banco de dados para retornar a lista de cursos,
//       futuramente com paginação
function getCursos(): array {
    return [    
        new Curso(
            1,
            "HTML5", 
            "Aprender a criar sites do zero nunca foi tão acessível!", 
            "Programação Front-End", 
            "Curso em Vídeo", 
            true, 
            "https://www.cursoemvideo.com/curso/html5/"
        )->toArray()
    ];
}

// TODO: implementar query no banco para procurar usuário com os mesmos dados
function isUsuarioCadastrado($email, $senha): bool
{
    return $email == "admin@capacita.com" && $senha == "admin";
}