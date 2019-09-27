<?php

namespace App\Console\Commands\Search;

use App\Models\Catalog\CategoryInterface;
use App\Search\Indexers\CategoriesIndexer;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Console\Command;

class CategoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:reindex:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reindex categories';
    /**
     * @var CategoryInterface
     */
    private $category;
    /**
     * @var CategoriesIndexer
     */
    private $categoriesIndexer;

    /**
     * Create a new command instance.
     *
     * @param CategoryInterface $category
     * @param CategoriesIndexer $categoriesIndexer
     */
    public function __construct(CategoryInterface $category, CategoriesIndexer $categoriesIndexer)
    {
        parent::__construct();
        $this->category = $category;
        $this->categoriesIndexer = $categoriesIndexer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $this->categoriesIndexer->clear();
        } catch (Missing404Exception $exception) {};

        foreach ($this->category->cursor() as $category)
        {
            $this->categoriesIndexer->index($category);
        }
    }
}
