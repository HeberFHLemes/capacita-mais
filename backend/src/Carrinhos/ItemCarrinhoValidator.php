<?php declare(strict_types=1);

namespace App\Carrinhos;

use App\Core\Validator;
use Override;

class ItemCarrinhoValidator extends Validator
{
    #[Override]
    public function validar(array $dados): void
    {
        $this->validarCampoObrigatorio($dados, 'curso_id');
        $this->validarInteiro($dados, 'curso_id');
    }
}