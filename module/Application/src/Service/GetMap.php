<?php
namespace Application\Service;

/*
* сервис обработки прерывания GetMap simba.sitemap
* обрабатывает ВСЕ запросы для генерации карты сайта, в том числе от других модулей, поэтому 
* для уменьшения сложности нужно проверить, принадлежит ли запрос данному модулю, если нет, вернуть пустой массив
*/
use Exception;

class GetMap 
{
    protected $connection;
	protected $Router;
	protected $type="sitemapindex";
    protected $locale="ru_RU";
    protected $name;

	
    public function __construct($Router, array $options,$connection) 
    {
        $this->connection=$connection;
		$this->Router=$Router;
		if(isset($options["type"])){
            $this->type=$options["type"];
        }
		if(isset($options["locale"])){
            $this->locale=$options["locale"];
        }
		if(isset($options["name"])){
            $this->name=$options["name"];
        }
    }
    
	/**
    * сам обработчик
    * пример из модуля STREAM
    */
	public function GetMap()
	{
        if ($this->type=="sitemapindex"){
            /*получить информацию для генерации sitemapindex*/
            return ["name"=>"home","lastmod"=>null];
        }
        /*получение списка всех страниц и генерация URL*/
        if ($this->type=="sitemap"){
            if ($this->name!="home"){
                /*если запрос не принадлежит этому модулю то выход*/
                return [];
            }
            $rez=[];
            foreach ($items as $item){
                $rez[]=[
                    "uri"=>$this->Router->assemble(["stream"=>$item->getCategory(),"url"=>$item->getUrl()], ['name' => 'stream_detal_ru_RU']),
                    "lastmod"=>$item->getLastmod(),
                    "changefreq"=>"weekly"
                ];
            }
            return $rez;
        }
        throw new  Exception("Недопустимый тип sitemap");
	}
	
}
