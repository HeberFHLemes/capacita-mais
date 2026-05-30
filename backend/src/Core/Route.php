<?php declare(strict_types=1);

namespace App\Core;

use App\Core\HttpMethod;
use App\Usuarios\Perfil;

/**
 * Classe para padronizar o array das rotas de cada controller.
 */
class Route
{
    public function __construct(
        public readonly HttpMethod $httpMethod,
        public readonly string $uri,
        public readonly string $action, // nome do método a ser executado
        public readonly bool $requerAuth = false,
        public readonly ?Perfil $perfilPermitido = null
    ) {}
}