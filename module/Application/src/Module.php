<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Session\SessionManager;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

class Module
{
const VERSION = '1.0.0-dev';
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
public function onBootstrap(MvcEvent $event)
{
        //устанавливаем менеджер сессии по умолчанию
        $manager = new SessionManager();
        Container::setDefaultManager($manager);
}
}
