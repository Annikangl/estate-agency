<?php


namespace App\Http\Services\Sms;


interface SmsSender
{
    public function send($number, $text): void;
}
