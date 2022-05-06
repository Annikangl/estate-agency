<?php

namespace App\Console\Commands\Banner;

use App\Mail\Banner\ExpiredMail;
use App\Models\Banners\Banner;
use Illuminate\Console\Command;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\Mail;
use Predis\Client;

class ExpiredBanner extends Command
{

    protected $signature = 'banners:expire';
    protected $description = 'Command description';
    protected $client;

    public function __construct(Client $client)
    {
        parent::__construct();
        $this->client = $client;
    }


    public function handle()
    {
        $success = true;

        $expiredAdverts = Banner::active()->where(new Expression('`limit` - views'), '<', 100)
            ->with('users')->cursor();

        foreach (Banner::active()->where(new Expression('`limit` - views'), '<', 100)
                     ->with('users')->cursor() as $banner)
        {
            $key = 'banner_notify_' . $banner->id;
            if ($this->client->get($key)) continue;
            Mail::to($banner->user->email)->queue(new ExpiredMail($banner));
        }

        return $success;
    }
}
