<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\App;

class Frontend
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        App::singleton('App\Repositories\Cart\CartRepositoryInterface', 'App\Repositories\Cart\CartRepository');
        App::singleton('App\Repositories\Cart\CartItemRepositoryInterface', 'App\Repositories\Cart\CartItemRepository');
        App::singleton('App\Models\Cart\CartInterface', 'App\Models\Cart\Cart');
        App::singleton('App\Models\Cart\CartItemInterface', 'App\Models\Cart\CartItem');
        App::singleton('App\Models\Admin\Catalog\Product\ProductInterface', 'App\Models\Admin\Catalog\Product\Product');
        App::singleton('App\Http\Requests\RequestInterface', 'App\Http\Requests\CartRequest');
        return $next($request);
    }
}
