<?php

namespace App\Listeners;

use App\Events\ProductUpdatedEvent;
use App\Search\Indexers\ProductsIndexer;

class ProductSearchReindex
{
    /**
     * @var ProductsIndexer
     */
    private $productsIndexer;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ProductsIndexer $productsIndexer)
    {
        $this->productsIndexer = $productsIndexer;
    }

    /**
     * Handle the event.
     *
     * @param ProductUpdatedEvent $event
     * @return void
     */
    public function handle(ProductUpdatedEvent $event)
    {
        $this->productsIndexer->reindex($event->product);
    }
}
