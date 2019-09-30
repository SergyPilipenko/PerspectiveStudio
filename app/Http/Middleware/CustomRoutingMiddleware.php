<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Frontend\PagesController;
use Closure;
use Illuminate\Support\Facades\URL;
use Illuminate\Cache\CacheManager;

class CustomRoutingMiddleware
{
    private $brands, $cache, $pagesController;

    public function __construct(CacheManager $cacheManager, PagesController $pagesController)
    {
        $this->cache = $cacheManager;
        $this->pagesController = $pagesController;
        if(!$this->cache->get('brands')) {
            $this->cache->rememberForever('brands', function () {
                $brands = array_reverse(\App\Models\ManufacturersUri::orderByRaw('CHAR_LENGTH(slug)')->get()->pluck('slug')->toArray());
                return $brands;
            });
        }

        $this->brands = $this->cache->get('brands');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $current_route = $this->getCurrentRoute($request->url());
//        dd($current_route);
        foreach ($this->brands as $brand) {
            if(preg_match("~$brand~", $current_route)) {
                $model = preg_replace("~$brand-~", '', $current_route);
                $this->pagesController->model($brand, $model);
            };
        }

        return $next($request);
    }

    public function getCurrentRoute($url)
    {
        $base_url = URL::to('/');
        return preg_replace("~$base_url\/~", '', $url);
    }
}
