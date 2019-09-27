<?php


namespace App\Search\Searchers;


use App\Models\Admin\Catalog\Product\ProductInterface;
use App\Models\Catalog\CategoryInterface;
use App\Models\Locale\LocaleInterface;
use Elasticsearch\ClientBuilder;

class CategoriesSearcher extends Searcher
{
    /**
     * @var LocaleInterface
     */
    private $locale;

    /**
     * ProductsSearcher constructor.
     * @param ClientBuilder $elastic
     * @param CategoryInterface $category
     * @param LocaleInterface $locale
     */
    public function __construct(ClientBuilder $elastic, CategoryInterface $category, LocaleInterface $locale)
    {
        $this->elastic = $elastic->create()->build();
        $this->category = $category;
        $this->locale = $locale;
    }

    public function search(string $searchQuery, $size = 6)
    {
        $fields = [];
        $fields = array_merge($this->locatedFields('category_title'), $fields);
        $query = [
            'multi_match' => [
                'query' => $searchQuery,
                'fields' => $fields,
            ],
        ];
        $parameters = [
            'index' => 'categories',
            'type' => 'categories',
            'body' => [
                'query' => $query,
                'from' => 0,
                'size' => $size,
                '_source' => ['id']
            ]
        ];

        $ids = $this->responseColumn($this->elastic->search($parameters), 'id');

        return $this->category->whereIn('id', $ids)->get();
    }

    /**
     * Принимает "category_title"
     * Возвращает ["category_title.ru", "category_title.ua"]
     *
     * @param string $field
     * @return array
     */
    public function locatedFields(string $field) : array
    {
        $locatedFields = [];
        $locales = $this->locale->get();

        if(!$locales->count()) return [$field];

        foreach ($locales as $locale)
        {
            $locatedFields[] = $field.'.'.$locale->code;
        }

        return $locatedFields;
    }
}
