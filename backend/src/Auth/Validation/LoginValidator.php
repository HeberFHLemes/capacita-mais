<?php

namespace App\Auth\Validation;

use App\Core\Validator;
use Override;

class LoginValidator extends Validator
{
    #[Override]
    public function validar(array $dados): void
    {
        $this->validarCampoNaoVazio($dados, 'email');
        $this->validarCampoNaoVazio($dados, 'senha');
        $this->validarEmail($dados, 'email');

        if (!isset($this->erros['email'])) {
            $this->validarEmail($dados, 'email');
        }
    }
}