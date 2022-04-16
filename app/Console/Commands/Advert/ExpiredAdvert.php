<?php

namespace App\Console\Commands\advert;

use App\Http\Services\Advert\AdvertService;
use App\Models\Adverts\Advert\Advert;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpiredAdvert extends Command
{

    protected $signature = 'advert:expire';

    protected $description = 'Command description';

    private AdvertService $advertService;


    public function __construct(AdvertService $advertService)
    {
        parent::__construct();
        $this->advertService = $advertService;
    }

    public function handle()
    {
        $success = true;

        $expiredAdverts = Advert::active()->where('expired_at','<', Carbon::now())->cursor();

        foreach ($expiredAdverts as $advert) {
            try {
                $this->advertService->expire($advert->id);
            } catch (\DomainException $exception) {
                $this->error($exception->getMessage());
                $success = false;
            }
        }

        return $success;
    }
}
