<?php declare(strict_types=1);

namespace App\Auth\Validation;

use App\Core\Validator;
use Override;

class CadastroUsuarioValidator extends Validator
{
    #[Override]
    public function validar(array $dados): void
    {
        $this->validarCampoNaoVazio($dados, 'email');
        $this->validarCampoNaoVazio($dados, 'senha');
        $this->validarCampoNaoVazio($dados, 'nome');

        if (!isset($this->erros['email'])) {
            $this->validarEmail($dados, 'email');
        }
    }
}