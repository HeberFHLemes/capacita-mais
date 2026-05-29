<?php declare(strict_types=1);

namespace App\Usuarios;

enum Perfil: string
{
    case ADMIN = "admin";
    case COMUM = "comum";
}