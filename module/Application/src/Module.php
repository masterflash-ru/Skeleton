<?php
/**
 * Скелетное приложение для SIMBA
 * GetControllersInfoAdmin - прерывание для генерации списка MVC для меню
 * GetMap - прерывание для генерации карты сайта
 * при использовании этих прерываний расскоментируйте нужное, измените обработчик каждого под нужды приложения
 */

namespace Application;

use Zend\Session\SessionManager;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;
use Application\Service\GetControllersInfo;
use Application\Service\GetMap;


class Module
{
    /*экземпляр сервис-менеджера*/
    protected $ServiceManager;
    
    
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
    $this->ServiceManager=$event->getApplication()-> getServiceManager();
	$eventManager = $event->getApplication()->getEventManager();
    $sharedEventManager = $eventManager->getSharedManager();
    // объявление слушателя для получения списка MVC для генерации меню сайта 
	$sharedEventManager->attach("simba.admin", "GetControllersInfoAdmin", [$this, 'GetControllersInfoAdmin']);
    //слушатель для генерации карты сайта
    $sharedEventManager->attach("simba.sitemap", "GetMap", [$this, 'GetMap']);
    */

}
/*
слушает событие GetControllersInfoAdmin 
для визуаллизации в админке маршрутов/путей в меню админки
в параметрах передается:
name=>имя_раздела "admin", ""
container - объект с интерфейсом Interop\Container\ContainerInterface - то что передается в фабрики
* /
public function GetControllersInfoAdmin(Event $event)
{
	$name=$event->getParam("name",NULL);
	$locale=$event->getParam("locale",NULL);
	//сервис который будет возвращать
	$service=$this->ServiceManager->build(GetControllersInfo::class,compact("locale","name"));
	return $service->GetDescriptors();
}

/**
*обработчик события GetMap - получение карты сайта
* /
public function GetMap(Event $event)
{
    $type=$event->getParam("type",NULL);
    $name=$event->getParam("name",NULL);
    $locale=$event->getParam("locale",NULL);
    //сервис который будет возвращать карту
    $service=$this->ServiceManager->build(GetMap::class,compact("type","locale","name"));
    return $service->GetMap();
}
*/
    
}
