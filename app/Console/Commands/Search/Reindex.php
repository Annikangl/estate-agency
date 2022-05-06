<?php

namespace App\Console\Commands\Search;

use App\Http\Services\Search\AdvertIndexer;
use App\Http\Services\Search\BannerIndexer;
use App\Models\Adverts\Advert\Advert;
use App\Models\Banners\Banner;
use Illuminate\Console\Command;

class Reindex extends Command
{
    protected $signature = 'search:reindex';
    private $advertIndexer;
    private $bannerIndexer;

    public function __construct(AdvertIndexer $advertIndexer, BannerIndexer $bannerIndexer)
    {
        parent::__construct();
        $this->advertIndexer = $advertIndexer;
        $this->bannerIndexer = $bannerIndexer;
    }

    protected $description = 'Command description';


    public function handle()
    {
        $this->advertIndexer->clear();

        foreach (Advert::active()->orderBy('id')->cursor() as $advert) {
            $this->advertIndexer->index($advert);
        }

        $this->bannerIndexer->clear();

        foreach (Banner::active()->orderBy('id')->cursor() as $banner) {
            $this->bannerIndexer->index($banner);
        }

        return 0;
    }
}
