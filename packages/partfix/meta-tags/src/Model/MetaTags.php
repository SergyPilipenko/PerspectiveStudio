<?php


namespace Partfix\MetaTags\Model;

use App\Models\Catalog\Category as ProductCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Routing\Route;
use Partfix\MetaTags\Contracts\MetaTagsInterface;
use Illuminate\Http\Request;

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
    /**
     * @var Request
     */
    private $request;

    public function __construct(Route $route, Request $request)
    {
        $this->route = $route;
        $this->routeName = preg_replace('/\./', self::LANG_KEY_DELIMITER, $this->route->getName());
        $this->request = $request;
    }

    public function __call($name, array $arguments = null)
    {
        if(!$this->isGetter($name)) return;

        $search = $this->getSearchName($name);
        array_shift($arguments);
        if($arguments) {
            return __('meta-tags::meta.' . $this->routeName . '.' . $search, array_shift($arguments));
        } return __('meta-tags::meta.' . $this->routeName . '.' . $search);
    }

    private function isGetter(string $name)
    {
        return preg_match($this->getterPattern, $name);
    }

    public function getMetaTag(string $key, array $vars = [])
    {
        return $this->format(__($key, $vars));
    }

    private function getSearchName(string $name)
    {
        return lcfirst(preg_replace($this->getterPattern, '', $name));
    }

    private function format(string $meta)
    {
        return preg_replace('/ {2,}/',' ', trim($meta));
    }

    public function getTitleFilterableOptions(ProductCategory $category) : ?string
    {
        $optionsDelimiter = '. ';
        $titleFilterableOptions = null;
        if(!$category->filterableAttributes->count()) return null;
        $options = $this->getFilters($category);

        $comma = false;
        if(array_key_exists('manufacturer', $options)) {
            $titleFilterableOptions .= ' ' . $options['manufacturer'];
            $comma = true;
        }
        foreach ($options as $key => $option) {
            if($key == 'manufacturer') continue;
            if($comma) $titleFilterableOptions .= $optionsDelimiter;
            $titleFilterableOptions .= $category->filterableAttributes->where('code', $key)->first()->title . ' - ' . $option;
            $comma = true;
        }

        return $titleFilterableOptions;
    }

    private function getFilters(ProductCategory $category)
    {
        return $this->request->only($category->filterableAttributes->pluck('code')->toArray());
    }
}
