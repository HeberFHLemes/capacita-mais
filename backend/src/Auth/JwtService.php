<?php

namespace App\Auth;

use App\Auth\Dto\UsuarioAuth;
use App\Auth\Exceptions\UsuarioNaoAutenticadoException;

use App\Core\Env;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService
{   
    private readonly string $key;

    public function __construct() {
        $this->key = Env::get("SECRET_KEY");
    }

    public function gerarToken(UsuarioAuth $dadosUsuario): string
    {
        $claims = [];

        $time = time();
        $claims['iat'] = $time;
        $claims['nbf'] = $time;
        $claims['exp'] = $time + 3600;
        $claims['sub'] = $dadosUsuario->id;
        $claims['name'] = $dadosUsuario->nome;
        $claims['role'] = $dadosUsuario->perfil;

        return JWT::encode($claims, $this->key, 'HS256');
    }

    public function validarToken(string $token): UsuarioAuth
    {
        try {
            $payload = JWT::decode(
                $token,
                new Key($this->key, 'HS256')
            );

            $claims = (array) $payload;

            return new UsuarioAuth(
                (int) $claims['sub'],
                $claims['name'],
                $claims['role'],
            );

        } catch (\Exception $e) {
            error_log($e->getMessage());

            throw new UsuarioNaoAutenticadoException(
                previous: $e
            );
        }
    }
}