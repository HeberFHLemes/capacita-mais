<?php declare(strict_types=1);

namespace App\Bootstrap;

use App\Database\Conexao;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

use Exception;
use PDO;

use function DI\factory;

final class ContainerFactory
{
    /**
     * Cria e configura o container de injeção de dependências da aplicação.
     *
     * @throws Exception
     */
    public static function create(): ContainerInterface
    {
        $builder = new ContainerBuilder();

        $builder->addDefinitions([
            PDO::class => factory(fn() => Conexao::getInstance())
        ]);

        return $builder->build();
    }
}