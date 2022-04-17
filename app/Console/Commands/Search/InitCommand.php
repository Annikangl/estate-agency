<?php

namespace App\Console\Commands\Search;

use Elastic\Elasticsearch\Client;
use Illuminate\Console\Command;

class InitCommand extends Command
{

    protected $signature = 'search:init';
    private $client;

    protected $description = 'Command description';


    public function __construct(Client $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    public function handle()
    {
//        try {
//            $this->client->indices()->delete([
//                'index' => 'agency'
//            ]);
//        } catch () {
//
//        }
    }
}
