<?php

namespace Database\Seeders;

use App\Models\Adverts\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdvertCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory(10)->create()->each(function (Category $category){
            $counts = [0, random_int(3,7)];
            $category->children()->saveMany(Category::factory($counts[array_rand($counts)])->create()->each(function (Category $category) {
                $counts = [0, random_int(3,7)];
                $category->children()->saveMany(Category::factory($counts[array_rand($counts)])->create());
            }));
        });
    }
}
