<?php

namespace App\Console\Commands\Search;

use App\Search\Indexers\ProductsIndexer;
use App\Models\Admin\Catalog\Product\ProductInterface;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Console\Command;

class ProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:reindex:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reindex products';
    /**
     * @var ProductInterface
     */
    private $product;
    /**
     * @var ProductsIndexer
     */
    private $productsIndexer;

    /**
     * Create a new command instance.
     *
     * @param ProductInterface $product
     * @param ProductsIndexer $productsIndexer
     */
    public function __construct(ProductInterface $product, ProductsIndexer $productsIndexer)
    {
        parent::__construct();
        $this->product = $product;
        $this->productsIndexer = $productsIndexer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $this->productsIndexer->clear();
        } catch (Missing404Exception $exception) {};

        foreach ($this->product->cursor() as $product)
        {
            $this->productsIndexer->index($product);
        }
    }
}
