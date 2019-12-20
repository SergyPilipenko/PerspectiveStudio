<?php

namespace Partfix\Parser;

use Illuminate\Support\ServiceProvider;
use Partfix\Parser\Contracts\ParserInterface;
use Partfix\Parser\Model\Parser;

class ParserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ParserInterface::class, Parser::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
