<?php


namespace App\Http\Services\Advert;


use Illuminate\Contracts\Pagination\Paginator;

class SearchResult
{
    public $adverts;
    public array $regionsCount;
    public array $categoryCount;

    public function __construct(Paginator $adverts, array $regionsCount, array $categoryCount)
    {
        $this->adverts = $adverts;
        $this->regionsCount = $regionsCount;
        $this->categoryCount = $categoryCount;
    }
}
