<?php

namespace App\Search\Searchers;

use App\Models\Admin\Catalog\Product\ProductInterface;
use Elasticsearch\ClientBuilder;
use Illuminate\Database\Eloquent\Collection;

class ProductsSearcher extends Searcher
{
    /**
     * @var ClientBuilder
     */
    private $elastic;
    /**
     * @var ProductInterface
     */
    private $product;

    /**
     * ProductsSearcher constructor.
     * @param ClientBuilder $elastic
     * @param ProductInterface $product
     */
    public function __construct(ClientBuilder $elastic, ProductInterface $product)
    {
        $this->elastic = $elastic->create()->build();
        $this->product = $product;
    }

    public function search(string $searchQuery, $size = 6)
    {
        $query = [
            'multi_match' => [
                'query' => $searchQuery,
                'fields' => ['manufacturer^3', 'name','article^4'],
            ],
        ];
        $parameters = [
            'index' => 'app',
            'type' => 'products',
            'body' => [
                'query' => $query,
                'from' => 0,
                'size' => $size,
                '_source' => ['id']
            ]
        ];

        $ids = $this->responseColumn($this->elastic->search($parameters), 'id');

        return $this->product->getProducts($ids);
    }


}
