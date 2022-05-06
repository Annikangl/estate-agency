<?php

namespace App\Console\Commands\Banner;

use App\Http\Services\Advert\AdvertService;
use App\Http\Services\Banner\BannerService;
use App\Mail\Banner\ExpiredMail;
use App\Models\Adverts\Advert\Advert;
use App\Models\Banners\Banner;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\Mail;

class ExpiredBanner extends Command
{

    protected $signature = 'banners:expire';

    protected $description = 'Command description';


    public function handle()
    {
        $success = true;

        $expiredAdverts = Banner::active()->where(new Expression('`limit` - views'), '<', 100)
            ->with('users')->cursor();

        foreach (Banner::active()->where(new Expression('`limit` - views'), '<', 100)
                     ->with('users')->cursor() as $banner)
        {
            Mail::to($banner->user->email)->send(ExpiredMail::class);
        }

        return $success;
    }
}
