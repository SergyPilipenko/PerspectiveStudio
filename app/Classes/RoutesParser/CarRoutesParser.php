<?php

namespace App\Classes\RoutesParser;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Cache;

class CarRoutesParser implements RoutesParserInterface
{
    public $router, $brand, $model;


    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getBrand(string $uri = null) : string
    {
        if(!$uri) $uri = $this->router->getCurrentRoute()->uri;
        foreach (Cache::get('brands') as $item) {
//            dd($item);
            if(preg_match("~$item~", $uri, $matches)) {
                return array_shift($matches);
            }
        }
//        if(isset($uri)) {
//            return preg_replace('/-{[a-z-A-Z0-9а-яА-Я]+}/', '', $this->router->getCurrentRoute()->uri);
//        };
    }

    public function getModel(string $uri = null)
    {
        if(!$uri) $uri = $this->router->getCurrentRoute()->uri;
        foreach (Cache::get('brands') as $item) {
            if(preg_match("/$item/", $uri, $matches)) {
                return preg_replace("/$item-/", '', $uri);
            }
        }
    }
}
