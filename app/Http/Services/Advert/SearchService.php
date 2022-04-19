<?php


namespace App\Http\Services\Advert;


use App\Http\Requests\Adverts\SearchRequest;
use App\Models\Adverts\Category;
use App\Models\Region;
use Elasticsearch\Client;

class SearchService
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function search(?Category $category, ?Region $region, SearchRequest $request, int $perPage, int $page)
    {
        $response = $this->client->search([
            'index' => 'agency',
            'type' => 'adverts',
            'body' => [
                '_source' => ['id'],
                'from' => ($page - 1) * $perPage,
                'size' => $perPage,
                'sort' => ['published_at' => ['order' => 'desc']],
                'query' => [
                    'bool' => [
                        'must' => array_filter([
                            $category ? ['term' => ['categories' => $category->id]] : false,
                            $region ? ['term' => ['regions' => $region->id]] : false,
                            !empty($request['text']) ? ['multi_match' => [
                                'query' => $request['text'],
                                'fields' => ['title^3', 'content']
                            ]] : false
                        ])
                    ]
                ]
            ]
        ]);
    }
}
