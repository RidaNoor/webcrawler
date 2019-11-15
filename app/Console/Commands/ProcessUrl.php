<?php

namespace App\Console\Commands;
use App\Url;
use App\Jobs\WebCrawling;

use Illuminate\Console\Command;

class ProcessUrl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:processUrl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = Url::whereNull('completed_at')->oldest()->first();

        if($url){

            WebCrawling::dispatch($url);
        }
    }
}
