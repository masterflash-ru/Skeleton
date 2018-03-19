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
    
	
	public function GetDescriptors()
	{
		//список для админки стандартной, ничего - выход
		if ($this->options["name"]) {return [];}
		if (empty($this->options["locale"])) {$this->options["locale"]=$this->config["locale_default"];}

        /*для меню сайта*/
        $info["stream"]["description"]="ОПИСАНИЕ ";
		$rez['name']=[]; /*массив имен элементов в выпадающем списке*/
		$rez['url']=[];  /*массив URL для перехода*/
		$rez['mvc']=[];  /*массив сериализованных элементов MVC для перехода*/

		$info["stream"]["urls"]=$rez;
		return $info;
	}
	
}
