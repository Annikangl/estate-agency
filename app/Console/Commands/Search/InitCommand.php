<?php

namespace App\Console\Commands\Search;

use App\Models\Adverts\Advert\Advert;
use Elasticsearch\Client;
use Illuminate\Console\Command;

class InitCommand extends Command
{

    protected $signature = 'search:init';
    private $client;

    protected $description = 'Command description';


    public function __construct(Client $client)
    {
        parent::__construct();
        $this->client = $client;
    }

//    Удаляем индекс если существует и создаем новый
    public function handle()
    {
        try {
            $this->client->indices()->delete([
                'index' => 'adverts'
            ]);
        } catch (Missing404Exception $exception) {}

        $this->client->indices()->create([
            'index' => 'adverts',
            'body' => [
                'mappings' => [
                    'advert' => [
                        '_source' => [
                            'enabled' => true,
                        ],
                        'properties' => [
                            'id' => [
                                'type' => 'integer',
                            ],
                            'published_at' => [
                                'type' => 'date',
                            ],
                            'title' => [
                                'type' => 'text',
                            ],
                            'content' => [
                                'type' => 'text',
                            ],
                            'price' => [
                                'type' => 'integer',
                            ],
                            'status' => [
                                'type' => 'keyword',
                            ],
                            'categories' => [
                                'type' => 'integer',
                            ],
                            'regions' => [
                                'type' => 'integer',
                            ],
                        ],
                    ],
                ],
                'settings' => [
                    'analysis' => [
                        'char_filter' => [
                            'replace' => [
                                'type' => 'mapping',
                                'mappings' => [
                                    '&=> and '
                                ],
                            ],
                        ],
                        'filter' => [
                            'word_delimiter' => [
                                'type' => 'word_delimiter',
                                'split_on_numerics' => false,
                                'split_on_case_change' => true,
                                'generate_word_parts' => true,
                                'generate_number_parts' => true,
                                'catenate_all' => true,
                                'preserve_original' => true,
                                'catenate_numbers' => true,
                            ],
                            'trigrams' => [
                                'type' => 'ngram',
                                'min_gram' => 4,
                                'max_gram' => 6,
                            ],
                        ],
                        'analyzer' => [
                            'default' => [
                                'type' => 'custom',
                                'char_filter' => [
                                    'html_strip',
                                    'replace',
                                ],
                                'tokenizer' => 'whitespace',
                                'filter' => [
                                    'lowercase',
                                    'word_delimiter',
                                    'trigrams',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        foreach (Advert::active()->orderBy('id')->cursor() as $advert) {
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

        return true;
    }
}
