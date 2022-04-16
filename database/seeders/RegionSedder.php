<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Region::factory(10)->create()->each(function (Region $region) {
            $region->children()->saveMany(Region::factory(random_int(3,10))->create()->each(function (Region $region) {
                $region->children()->saveMany(Region::factory(random_int(3,10))->make());
            }));
        });
    }
}
