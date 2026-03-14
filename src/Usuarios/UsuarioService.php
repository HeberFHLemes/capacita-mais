<?php

namespace App\Usuarios;

class UsuarioService 
{
    // TODO: implementar query no banco para procurar usuário com os mesmos dados
    public function usuarioExiste($email, $senha): bool
    {
        return $email == "admin@capacita.com" && password_verify($senha, password_hash("admin", PASSWORD_DEFAULT));
    }
}