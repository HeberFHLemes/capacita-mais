<?php declare(strict_types=1);

namespace App\Core;

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
        public readonly ?Perfil $perfilNecessario = null
    ) {
        if ($this->perfilNecessario !== null && !$requerAuth) {
            throw new \InvalidArgumentException(
                "Rota {$uri}: se a rota exige um perfilNecessario, é necessário definir requerAuth como true"
            );
        }
    }
}