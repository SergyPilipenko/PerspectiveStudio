<?php

namespace App\Console\Commands\SiteMap;

use Illuminate\Console\Command;
use Partfix\SiteMap\model\SiteMaper;

class SiteMap extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'site-mapper:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var SiteMaper
     */
    private $siteMaper;

    /**
     * Create a new command instance.
     *
     * @param SiteMaper $siteMaper
     */
    public function __construct(SiteMaper $siteMaper)
    {
        $this->siteMaper = $siteMaper;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

       app(SiteMaper::class)->createFile();


    }
}
