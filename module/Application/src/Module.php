<?php
/**
 * Скелетное приложение для SIMBA
 * GetControllersInfoAdmin - прерывание для генерации списка MVC для меню
 * GetMap - прерывание для генерации карты сайта
 * при использовании этих прерываний расскоментируйте нужное, измените обработчик каждого под нужды приложения
 */

namespace Application;

use Laminas\Session\SessionManager;
use Laminas\Mvc\MvcEvent;
use Laminas\EventManager\Event;
use Laminas\Session\Container;
use Application\Service\GetControllersInfo;
use Application\Service\GetMap;


class Module
{
    
    
public function getConfig()
{
    return include __DIR__ . '/../config/module.config.php';
}

public function onBootstrap(MvcEvent $event)
{
    //устанавливаем менеджер сессии по умолчанию
    $manager = new SessionManager();
    Container::setDefaultManager($manager);
    /*
    $ServiceManager=$event->getApplication()-> getServiceManager();
	$eventManager = $event->getApplication()->getEventManager();
    $sharedEventManager = $eventManager->getSharedManager();
    
    // объявление слушателя для получения списка MVC для генерации меню сайта 
	$sharedEventManager->attach("simba.admin", "GetControllersInfoAdmin", [$this, 'GetControllersInfoAdmin']);
    
    //объявление слушателя для получения всех MVC адресов разбитых по языкам
    $sharedEventManager->attach("simba.admin", "GetMvc", function(Event $event) use ($ServiceManager){
        $category=$event->getParam("category",NULL);
        $service=$ServiceManager->build(GetControllersInfo::class,["category"=>$category]);
        return $service->GetMvc();
    });
    
    
    //слушатель для генерации карты сайта
    $sharedEventManager->attach("simba.sitemap", "GetMap", function(Event $event) use ($ServiceManager){
        $name=$event->getParam("name",NULL);
        $type=$event->getParam("type",NULL);
        $locale=$event->getParam("locale",NULL);
        $service=$ServiceManager->build(GetMap::class,["name"=>$name,"locale"=>$locale,"type"=>$type]);
        return $service->GetMap();
    });
    */

}
    
}
