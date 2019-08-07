<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

use Mf\Stream\Controller\IndexController as Stream;


/*адаптеры ресайза*/
use Mf\Imglib\Filter\Adapter\Gd;
use Mf\Imglib\Filter\Adapter\Consoleimagick  as ImgAdapter;
use Mf\Imglib\Filter\Adapter\Imagick;

/** 
* адаптеры (фильтры) ресайза, оптимизации и наложения водных знаков на фото
* это обертка к выбранному адаптеру, см. выше
*/
use Mf\Imglib\Filter\ImgResize;
use Mf\Imglib\Filter\ImgOptimize;
use Mf\Imglib\Filter\Watermark;
/*
как обрабатывать фото определяют эти константы:
IMG_METHOD_SCALE_WH_CROP //точное вырезание
IMG_METHOD_SCALE_FIT_W   //точно по горизонатали, вертикаль пропорционально
IMG_METHOD_SCALE_FIT_H   //точно к вертикали, горизонталь пропорционально
IMG_METHOD_CROP"         //просто вырезать из исходного часть

IMG_ALIGN_CENTER         //выравнивать по центру
IMG_ALIGN_LEFT          //выравнивать по левой части
IMG_ALIGN_RIGHT         //выравнивать по правой
IMG_ALIGN_TOP            //выравнивать по верху
IMG_ALIGN_BOTTOM        //выравнивать по низу
*/

/**
* специальный фильтр для генерации альтернативных форматов изображений
*/
use Mf\Imglib\Filter\ImgAlternative;


/*фильтр копировщик файлов в хранилище*/
use Mf\Storage\Filter\CopyToStorage;

use Zend\Validator\File\IsImage;
use Zend\Validator\File\ImageSize;




return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
	 'service_manager' => [
			  'factories' => [//сервисы-фабрики
                  //Service\GetControllersInfo::class => Service\Factory\GetControllersInfoFactory::class,
                  Service\GetMap::class => Service\Factory\GetMapFactory::class,
			  ],
	  ],

    /*публичная папка с медиаматериалом*/
    'public_media_folder'=>"media",
    "locale_default"=>"ru_RU",
    //"locale_enable_list"=>["ru_RU","en_US"], //если мультиязычный, то расскоментировать и указать список допустимых локалей
    
    /*Канонический адрес сайта*/
    "ServerDefaultUri"=>$_SERVER["REQUEST_SCHEME"]."://".trim($_SERVER["SERVER_NAME"],"w."),


];
