<?php
namespace Application\Service;

/*
сервис обработки прерывания GetControllersInfoAdmin simba.admin
нужен для генерации ссылок для подстановки в меню сайта или админки для визуализации выбора
ВНИМАНИЕ!
возвращаются и ссылки, и спец массив с данными MVC

*/
use Exception;

class GetControllersInfo 
{
	protected $Router;
	protected $options;
	protected $config;
	
    public function __construct($Router,$config,$options) 
    {
		
		$this->Router=$Router;
		$this->options=$options;
		$this->config=$config;
    }
    
    /**
    * получить все MVC адреса, разбитые по языкам
    */
    public function getMvc()
    {
		//данный модуль содержит только сайтовские описатели описатели
		if ($this->options["category"]!="frontend") {return ;}

		//Линейные таблицы
		$info["app"]["description"]="Приложение";
		$rez['name']=[];
		$rez['url']=[];
		$rez['mvc']=[];
		
        $info["app"]["urls"]=$rez;
		return $info;

        
    }

	
}
