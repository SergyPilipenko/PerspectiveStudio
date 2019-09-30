<?php

namespace App\Console\Commands\Search;

use App\Search\Indexers\ProductsIndexer;
use Elasticsearch\ClientBuilder;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Console\Command;

class InitCommand extends Command
{
    /**
     * На будущее
     *
     * @var string
     */
    protected $signature = 'elastic:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reindex all entities';
    /**
     * @var ClientBuilder
     */
    private $elastic;
    private $entitiesCommands;

    /**
     * Create a new command instance.
     *
     * @param ClientBuilder $elastic
     * @param ProductCommand $productCommand
     * @param CategoryCommand $categoryCommand
     */
    public function __construct(
        ClientBuilder $elastic,
        ProductCommand $productCommand,
        CategoryCommand $categoryCommand
    )
    {
        parent::__construct();
        $this->elastic = $elastic->create()->setHosts(config('elasticsearch.connections.default.hosts'))->build();
        $this->entitiesCommands[] = $productCommand;
        $this->entitiesCommands[] = $categoryCommand;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $this->elastic->indices()->delete([
                'index' => ['app', 'categories'],
            ]);
        } catch (Missing404Exception $exception) {};

        foreach ($this->entitiesCommands as $entitiesCommand)
        {
            $entitiesCommand->handle();
        }
    }
}
