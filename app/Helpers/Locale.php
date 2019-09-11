<?php


namespace App\Helpers;
use Illuminate\Support\Facades\App;

class Locale
{

    public $app;

    public function __construct()
    {
        $this->app = app();
    }

    public function locatedInputName($input_name)
    {
        return $this->app->getLocale() . '[' . $input_name . ']';
    }

    public function getLocale()
    {
        return $this->app->getLocale();
    }

    public function getFallbackInputName($input_name)
    {
        return config('app.fallback_locale') . '[' . $input_name . ']';
    }
}
