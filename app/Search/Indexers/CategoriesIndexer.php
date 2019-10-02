<?php


namespace App\Search\Indexers;


use App\Models\Catalog\CategoryInterface;
use Elasticsearch\ClientBuilder;
use Elasticsearch\Common\Exceptions\Missing404Exception;

class CategoriesIndexer
{
    private $elastic;

    public function __construct(ClientBuilder $elastic)
    {
        $this->elastic = $elastic->create()->setHosts(config('elasticsearch.connections.default.hosts'))->build();
    }
    public function clear() : void
    {
        $this->elastic->deleteByQuery([
            'index' => 'categories',
            'type' => 'categories',
            'body' => [
                'query' => [
                    'match_all' => new \stdClass()
                ]
            ]
        ]);
    }

    public function index(CategoryInterface $category) : void
    {
        $this->elastic->index([
            'id' => $category->id,
            'index' => 'categories',
            'type' => 'categories',
            'body' => $category->toArray()
        ]);
    }

    public function reindex(CategoryInterface $category) : void
    {
        $this->remove($category);
        $this->index($category);
    }

    public function remove(CategoryInterface $category) : void
    {
        try {
            $this->elastic->delete([
                'id' => $category->id,
                'index' => 'categories',
                'type' => 'categories',
            ]);
        } catch (Missing404Exception $exception) {};
    }
}
