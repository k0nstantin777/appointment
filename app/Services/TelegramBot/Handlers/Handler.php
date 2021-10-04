<?php

namespace App\Services\TelegramBot\Handlers;

use Telegram\Bot\Objects\Update;

interface Handler
{
    public function setNext(Handler $handler): Handler;

    public function handle(Update $update): void;
}
