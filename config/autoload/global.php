<?php
/**
 * Глобальная конфигурация, при необходимости нужно расскоментировать некоторые настройки, например, капчу
 */
use Laminas\Session\Storage\SessionArrayStorage;
use Laminas\Session\Validator\RemoteAddr;
use Laminas\Session\Validator\HttpUserAgent;
use Laminas\Cache\Storage\Adapter\Filesystem;
use Laminas\Cache\Storage\Plugin\Serializer;

//капча, если не используется, можно удалить соответсвующую секцию
use Laminas\Captcha;

return [
    "databases"=>[
        //соединение с базой + имя драйвера
        'DefaultSystemDb' => [
            'driver'=>'MysqlPdo',
            //"unix_socket"=>"/tmp/mysql.sock",
            "host"=>"localhost",
            'login'=>"root",
            "password"=>"vfibyf",
            "database"=>"simba4",
            "locale"=>"ru_RU",
            "character"=>"utf8"
        ],
    ],
    //конфигурация сессий (куки)
    'session_config' => [
        'cookie_lifetime'     => 60*60*3,
        'gc_maxlifetime'      => 60*60*24*30,
    ],
    //конфигурация менеджера сессий.
    'session_manager' => [
        //валидаторы сессий.
        'validators' => [
            //RemoteAddr::class,
            HttpUserAgent::class,
        ]
    ],
    //хранилище сессии.
    'session_storage' => [
        'type' => SessionArrayStorage::class
    ],

    // Настройка кэша.
    'caches' => [
        'DefaultSystemCache' => [
            'adapter' => [
                'name'    => Filesystem::class,
                'options' => [
                    // Store cached data in this directory.
                    'cache_dir' => './data/cache',
                    // Store cached data for 3 hour.
                    'ttl' => 60*60*2,
                    'file_permission'=>0666,
                    'dir_permission'=>0770,
                ],
            ],
            'plugins' => [
                [
                    'name' => Serializer::class,
                    'options' => [
                    ],
                ],
            ],
        ],
    ],

    //настройки капчи
    "captcha"=>[
      "adapter"=>Captcha\Image::class,                           //используемый на сайте вариант капчи
        "options"=>[
          Captcha\Image::class=>[
            "font"=>__DIR__."/../../data/captcha/Arial.ttf",
            "imgDir"=> trim(str_replace(getcwd(),'',$_SERVER['DOCUMENT_ROOT']),DIRECTORY_SEPARATOR).  "/img/captcha",
            "imgUrl"=>"/img/captcha/",
            //"FontSize"=>24,
            //"Width"=>200,
            //"Height"=>50,
          ],
          Captcha\ReCaptcha::class=>[
            "SecretKey"=>"",
            "SiteKey"=>""
          ],
          Captcha\Dumb::class=>[]
        ],
    ],

/* 'translator' => [
    'locale' => 'ru_RU',
    'translation_file_patterns' => [
        [
            'type'     => 'gettext',
            'base_dir' => getcwd() .  '/data/language',
            'pattern'  => '%s.mo',
        ],
    ],
  ],*/
];