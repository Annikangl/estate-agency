<?php


namespace App\Http\Services\Search;


use App\Models\Adverts\Advert\Advert;
use App\Models\Adverts\Advert\Value;
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
            'index' => 'adverts',
            'type' => 'advert',
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
            'index' => 'adverts',
            'type' => 'advert',
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
                    $advert->category->ancestors()->pluck('id')->toArray()),
                'regions' => $regions ?: [0],
                'values' => array_map(function (Value $value) {
                    return [
                        'attribute' => $value->attribute_id,
                        'value_string' => (string)$value->value,
                        'value_int' => (int)$value->value,
                    ];
                }, $advert->values()->getModels()),
            ]
        ]);
    }

    public function remove(Advert $advert)
    {
        $this->client->delete([
            'index' => 'adverts',
            'type' => 'advert',
            'id' => $advert->id
        ]);
    }
}
