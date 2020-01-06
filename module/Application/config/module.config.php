<?php
/**
 */

namespace Application;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

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

use Laminas\Validator\File\IsImage;
use Laminas\Validator\File\ImageSize;


if (empty($_SERVER["SERVER_NAME"])){
    //скорей всего запустили из консоли
    $_SERVER["SERVER_NAME"]="localhost";
    $_SERVER["REQUEST_SCHEME"]="http";
}

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

    "menu"=>[
        "MenuUp"=>'Меню в верху',
        "MenuDown"=>"Нижнее меню"
    ],

	/*"statpage"=>[
		'tpl'=>[                                  //пользовательские шаблоны вывода контента, если нужны, пусто - по умолчанию, используется внутренний
            "application/statpage/1"=>"Шаблон 1",
        ],
        'layout'=>[                               //имена макетов которые имеются в приложении, если нужны, пусто - по умолчанию
            "layout/layout_glav"=>"Главная страница",
        ],
		'media_folder'=>"media",                  //имя папки в public для размещения медиаматериала стат.страниц, это значение по умолчанию
		'status'=>[                               //статусы страниц (по умолчанию используются эти)
			0=>"Не опубликовано",
			1=>"Опубликовано",
			2=>"Для внутренних целей",
		],
        "defaultStatus"=>1,                     //код статуса по умолчанию (опубликовано)
	],*/

    'streams'=>[
        "config"=>[                                       /*если имена базы и кеша отличны от значения по умолчанию:*/
            "database"  =>  "DefaultSystemDb",            /*Имя базы данных с которой работаем*/
            "cache"     =>  "DefaultSystemCache",         /*имя кеша с которым работаем*/
        ],
        "categories"=>[
            'news'=>[                                   /*раздел ленты*/
                'description'=>'Новости',               /*ОБЯЗАТЕЛЬНО Имя ленты*/
                'pagination'=> [                        /*параметры вывода страниц, здесь указаны параметры по умолчанию*/
                    'paginationControl'=> [
                        'tpl'=>'simba',                  /*шаблон вывода номеров страниц, по умолчанию внутренний, можно bootstrap4, см. пакет masterflash-ru/navigation*/
                        'ScrollingStyle'=> 'Sliding',    /*стиль прокрутки номеров, допускается All, Elastic, Jumping, Sliding - по умолчанию*/
                    ],
                    'ItemCountPerPage' => 10,               /*кол-во элементов при просмотре анонсов*/
                    'PageRange' =>   10                     /*кол-во ссылок для перехода на другие страницы списка*/
                ],
                'tpl' => [                               /*НЕ обязательно, указаны параметры по умолчанию*/
                    'index' => 'stream/index/index',     /*шаблон вывода списка статей*/
                    'detal' => 'stream/index/detal',     /*шаблон вывода подробностей статьи*/
                ],
                'layout' => null,                        /*имя макета в котором выводится, по умолчанию текущий*/
            ],
        ],
    ],

    /*хранилище и обработка (ресайз) фото*/
    "storage"=>[

        /*хранит загруженные файлы, готовые для обработки
        это промедуточное хранение
        */
        'data_folder'=>"data/datastorage",

        /*
        *Именованные хранилища фото в виде множества вложенных папок
        *по умолчанию имеется всегда default
        *уровень вложений и размеры имен каталогов определяются параметром в фильтр CopyToStorage
        */
        'file_storage'=>[
            'default'=>[
                'base_url'=>"media/pics/",
            ],
        ],
        
        /*чистить хранилище только по расписанию, используется при очень больших хранилищах
        *когда за текущую операцию не успевает обойти все каталоги
        * включите по расписанию обращение к адресу http://site.ru/clear-storage-cron
        */
        "clear_storage_only_cron"=>false,
        'items'=>[
            /*хранилище для ленты новостей, ключ это имя секции, которая используется для работы
            *он же является именем раздела, под которым записываются и считываются файлы*/
            
            "news"=>[
                "description"=>"Хранение фото новостей",
                'file_storage'=>'default', /*имя хранилища*/
                'file_rules'=>[
                    'admin_img'=>[
                        'filters'=>[
                            CopyToStorage::class => [   /*Наличе этого фильтра ОБЯЗАТЕЛЬНО!*/
                                'folder_level'=>1,
                                'folder_name_size'=>3,
                                'strategy_new_name'=>'translit' /*стратегия создания нового имени, none, md5, sha1, translit, uniqid*/
                            ],
                            ImgResize::class=>[
                                "method"=>1,
                                "width"=>150,
                                "height"=>150,
                                'adapter'=>ImgAdapter::class,
                            ],
                            ImgOptimize::class=>[
                                "jpegoptim"=>85,
                                "optipng"=>3,
                            ],
                            Watermark::class=>[
                                "waterimage"=>"data/images/water2.png",
                                'adapter'=>'Consoleimagick',
                            ],
                        ],
                        'validators' => [/*валидаторы достаточно применить для одной ветки, т.к. последующие ветки используют исходное изображание вновь*/
                            IsImage::class=>[],
                            ImageSize::class => [
                                'minWidth' => 500,
                                'minHeight' => 250,
                            ],
                        ],
                    ],
                    'anons'=>[
                        'filters'=>[
                            CopyToStorage::class => [
                                'folder_level'=>1,
                                'folder_name_size'=>3,
                            ],
                            ImgResize::class=>[
                                "method"=>1,
                                "width"=>500,
                                "height"=>250,
                                'adapter'=>ImgAdapter::class,
                            ],
                        ],
                    ],
                ],
            ],//news
        ],
    ],

];
