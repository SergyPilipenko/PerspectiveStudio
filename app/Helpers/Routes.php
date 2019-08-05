<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;

class Routes {

    /**
     * @param $name
     * @return string
     */
    public function getRoutesByName($name) : array
    {
        $routeCollection = Route::getRoutes();

        $routes = [];

        foreach($routeCollection as $route) {

            if(isset($route->action['as']) && preg_match("/$name/", $route->action['as'])) {

                $routes[$route->action['as']] = $route->uri;

            }

        }
        return $routes;
    }

}