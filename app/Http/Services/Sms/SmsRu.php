<?php


namespace App\Http\Services\Sms;

use GuzzleHttp\Client;
use http\Exception\InvalidArgumentException;


class SmsRu implements SmsSender
{
    private string $appId;
    private string $url;
    private $client;

    public function __construct($appId, $url='https://sms.ru/sms/send')
    {
        if (empty($appId)) {
            throw new InvalidArgumentException('Sms appId must be set');
        }

        $this->appId = $appId;
        $this->url = $url;
        $this->client = new Client();
    }

    public function send($number, $text): void
    {
        $this->client->post($this->url, [
            'form_params' => [
                'api_id' => $this->appId,
                'to' => '+' . trim($number),
                'text' => $text
            ]
        ]);
    }
}
