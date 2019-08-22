<?php

namespace App\Classes\RoutesParser;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Cache;

class CarRoutesParser implements RoutesParserInterface
{
    const MODEL = 'model';
    public $router, $request, $brand, $model, $parameters;


    public function __construct(Router $router, Request $request)
    {
        $this->router = $router;
        $this->request = $request;
        $this->parameters = $this->request->route()->parameters();
    }

    public function getBrand(string $uri = null) : string
    {
        if(!$uri) $uri = $this->router->getCurrentRoute()->uri;

        if($this->routeParameterExists(self::MODEL)) {
            return preg_replace('/-{[a-z-A-Z0-9а-яА-Я]+}/', '', $this->router->getCurrentRoute()->uri);
        } else {
            foreach (Cache::get('brands') as $item) {
                if(preg_match("~$item~", $uri, $matches)) {
                    return array_shift($matches);
                }
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

    /**
     * Содержит ли строка роута параметр
     *
     * @param $parameter
     * @return bool
     */
    protected function routeParameterExists($parameter)
    {
        return array_key_exists($parameter, $this->parameters);
    }
}
