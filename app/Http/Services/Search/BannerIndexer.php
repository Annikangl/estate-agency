<?php


namespace App\Http\Services\Search;


use App\Models\Adverts\Advert\Advert;
use App\Models\Adverts\Advert\Value;
use App\Models\Banners\Banner;
use App\Models\Region;
use Elasticsearch\Client;

class BannerIndexer
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function clear(): void
    {
//        new stdClass - прост опустой объект {} для правильной сериализации в JSON
        $this->client->deleteByQuery([
            'index' => 'banners',
            'type' => 'banner',
            'body' => [
                'query' => [
                    'match_all' => new \stdClass()
                ]
            ]
        ]);
    }

    public function index(Banner $banner): void
    {
        $regions = [];

        if ($region = $banner->region) {
            $regions[] = [$banner->region->id];
            $childrenIds = $regions;
            while ($childrenIds = Region::whereIn('parent_id', $childrenIds)->pluck('id')->toArray()) {
                $regions = array_merge($regions, $childrenIds);
            }
        }

        $this->client->index([
            'index' => 'banners',
            'type' => 'banner',
            'id' => $banner->id,
            'body' => [
                'id' => $banner->id,
                'format' => $banner->format,
                'status' => $banner->status,
                'categories' => array_merge(
                    [$banner->category->id],
                    $banner->category->descendants()->pluck('id')->toArray()),
                'regions' => $regions,
            ]
        ]);
    }

    public function remove(Banner $banner)
    {
        $this->client->delete([
            'index' => 'banners',
            'type' => 'banner',
            'id' => $banner->id
        ]);
    }
}
