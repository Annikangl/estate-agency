<?php

namespace App\Http\Services\Sms;

class ArraySender implements SmsSender
{
    private array $message = [];

    public function send($number, $text): void
    {
        $this->message[] = [
            'to' => trim($number,'+'),
            'text' => $text
        ];
    }

    public function getMessages(): array
    {
        return $this->message;
    }
}
