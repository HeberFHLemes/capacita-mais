<?php

namespace App\Cursos;

use App\Cursos\Curso;

class CursoService 
{
    // TODO: implementar query no banco de dados para retornar a lista de cursos
    public function listarCursos(): array 
    {
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
}