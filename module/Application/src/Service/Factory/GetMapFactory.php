<?php
namespace Application\Service\Factory;

use Interop\Container\ContainerInterface;
use Mf\Stream\Service\Stream;

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
    $streamService = $container->get(Stream::class);
    return new $requestedName($Router,$options,$streamService);
}
}

