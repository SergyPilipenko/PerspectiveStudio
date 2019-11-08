<?php


namespace Partfix\MetaTags\Model;

use Illuminate\Routing\Route;
use Partfix\MetaTags\Contracts\MetaTagsInterface;

/**
 * Выбирает мета-теги из lang файлов по route name. Приходится точки в ключах менять на LANG_KEY_DELIMITER
 * т.к ларавел не работает с вложенными массивами у которых ключи с точками.
 *
 * 'frontend.product.categories.show' => [
 *  'title' => ':title'
 *  ]
 * __('frontend.product.categories.show.title') <-- Это не сработает
 *
 * Class MetaTags
 * @package Partfix\MetaTags\Model
 */
class MetaTags implements MetaTagsInterface
{
    private $route;
    private $routeName;
    private $getterPattern = '/^get/';
    const LANG_KEY_DELIMITER = '-';

    public function __construct(Route $route)
    {
        $this->route = $route;
        $this->routeName = preg_replace('/\./', self::LANG_KEY_DELIMITER, $this->route->getName());
    }

    public function __call($name, array $arguments = null)
    {
        if(!$this->isGetter($name)) return;

        $search = $this->getSearchName($name);

        return __($this->routeName . '.' . $search, array_shift($arguments));
    }

    private function isGetter(string $name)
    {
        return preg_match($this->getterPattern, $name);
    }

    private function getSearchName(string $name)
    {
        return lcfirst(preg_replace($this->getterPattern, '', $name));
    }
}
