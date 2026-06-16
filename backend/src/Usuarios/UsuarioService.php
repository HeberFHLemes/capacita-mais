<?php declare(strict_types=1);

namespace App\Usuarios;

use App\Usuarios\Exceptions\EmailJaCadastradoException;
use RuntimeException;

readonly class UsuarioService
{
    public function __construct(
        private UsuarioRepository $usuarioRepository
    ) {}

    public function buscarPorId(int $id): ?Usuario
    {
        return $this->usuarioRepository->buscarPorId($id);
    }

    public function buscarPorEmail(string $email): ?Usuario
    {
        return $this->usuarioRepository->buscarPorEmail($email);
    }

    public function criar(string $nome, string $email, string $senha): int
    {
        if ($this->usuarioRepository->emailExiste($email)) {
            throw new EmailJaCadastradoException();
        }

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        
        if ($senhaHash === false) {
            throw new RuntimeException('Não foi possível gerar o hash da senha');
        }

        return $this->usuarioRepository->cadastrarUsuario(
                $nome, $email, $senhaHash
        );
    }
}