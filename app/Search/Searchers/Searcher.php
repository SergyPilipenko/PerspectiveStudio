<?php


namespace App\Search\Searchers;


abstract class Searcher
{
    /**
     * Возвращает массив, по определенному полю результатов поиска
     *
     * @param array $response
     * @param string $column
     * @return array
     */
    public function responseColumn(array $response, string $column) : array
    {
        $ids = [];

        if(isset($response['hits']['hits']) && count($response['hits']['hits']))
        {
            foreach ($response['hits']['hits'] as $item)
            {
                $ids[] = $item['_source'][$column];
            }
        }

        return $ids;
    }
}
