<?php

namespace App\Search\Indexers;

use App\Models\Admin\Catalog\Product\ProductInterface;
use Elasticsearch\ClientBuilder;
use Elasticsearch\Common\Exceptions\Missing404Exception;

class ProductsIndexer
{
    private $elastic;

    public function __construct(ClientBuilder $elastic)
    {
        $this->elastic = $elastic->create()->setHosts(config('elasticsearch.connections.default.hosts'))->build();
    }

    public function clear() : void
    {
        $this->elastic->deleteByQuery([
            'index' => 'app',
            'type' => 'products',
            'body' => [
                'query' => [
                    'match_all' => new \stdClass()
                ]
            ]
        ]);
    }

    public function index(ProductInterface $product) : void
    {
        if(!$product->canBeDisplayed()) return;

        $attributes = $product->getProductAttributes();

        if(isset($product->depends_quantity))
        {
            $product->depends_quantity = (int) $product->depends_quantity;
        }

        foreach ($attributes as $key => $attribute) {
            $product->$key = $attribute;
        }

        $this->elastic->index([
            'id' => $product->id,
            'index' => 'app',
            'type' => 'products',
            'body' => $product->toArray()
        ]);
    }

    public function reindex(ProductInterface $product) : void
    {
        $this->remove($product);
        $this->index($product);
    }


    public function remove(ProductInterface $product) : void
    {
        try {
            $this->elastic->delete([
                'id' => $product->id,
                'index' => 'app',
                'type' => 'products',
            ]);
        } catch (Missing404Exception $exception) {};
    }
}
