<?php


namespace App\Http\Services\Search;


use App\Models\Adverts\Advert\Advert;
use Elasticsearch\Client;

class AdvertIndexer
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
            'index' => 'agency',
            'type' => 'adverts',
            'body' => [
                'query' => [
                    'match_all' => new \stdClass()
                ]
            ]
        ]);
    }

    public function index(Advert $advert): void
    {
        $regions = [];

        if ($region = $advert->region) {
            do {
                $regions[] = $region->id;
            } while ($region = $region->parent);
        }

        $this->client->index([
            'index' => 'agency',
            'type' => 'adverts',
            'id' => $advert->id,
            'body' => [
                'id' => $advert->id,
                'published_at' => $advert->published_at ? $advert->published_at->format(DATE_ATOM) : null,
                'title' => $advert->title,
                'content' => $advert->content,
                'price' => $advert->price,
                'status' => $advert->status,
                'categories' => array_merge(
                    [$advert->category->id],
                    $advert->category->descendants()->pluck('id')->toArray()),
                'regions' => $regions
            ]
        ]);
    }

    public function remove(Advert $advert)
    {
        $this->client->delete([
            'index' => 'agency',
            'type' => 'adverts',
            'id' => $advert->id
        ]);
    }
}
