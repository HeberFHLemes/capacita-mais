<?php declare(strict_types=1);

namespace App\Cursos;

enum Nivel: string
{
    case INICIANTE = "iniciante";
    case INTERMEDIARIO = "intermediario";
    case AVANCADO = "avancado";
}