<?php

// Obtido da UA "Padrões de Projeto PHP" - Livro
class Conexao 
{
    private static $instance = null;

    private function __construct() {}

    // TODO: Alterar credenciais (usar variáveis de ambiente) e tratar exceções
    public static function getInstance() 
    {
        if (self::$instance === null) {
            self::$instance = new PDO(
                'mysql:' . 
                'host=localhost;' . 
                'dbname=capacita-mais-db;' . 
                'charset=utf8',
                'root',
                ''
            );
        }
        return Conexao::$instance;
    }
}

?>