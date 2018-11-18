<?php
namespace Application\Service\Factory;

use Interop\Container\ContainerInterface;


/*
Фабрика 
сервис обработки прерывания GetMap simba.sitemap
нужен для генерации карты сайта

$options - массив с ключами


*/

class GetMapFactory
{

public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
{
    $Router=$container->get("Application")->getMvcEvent()->getRouter();
    $connection = $container->get('ADO\Connection');
    return new $requestedName($Router,$options,$connection);
}
}

