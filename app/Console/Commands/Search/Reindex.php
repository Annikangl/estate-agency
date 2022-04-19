<?php

namespace App\Console\Commands\Search;

use App\Http\Services\Search\AdvertIndexer;
use App\Models\Adverts\Advert\Advert;
use Illuminate\Console\Command;

class Reindex extends Command
{

    protected $signature = 'search:reindex';
    private $indexer;

    public function __construct(AdvertIndexer $advertIndexer)
    {
        parent::__construct();
        $this->indexer = $advertIndexer;
    }

    protected $description = 'Command description';


    public function handle()
    {
        $this->indexer->clear();

        foreach (Advert::active()->orderBy('id')->cursor() as $advert) {
            $this->indexer->index($advert);
        }

        return 0;
    }
}
