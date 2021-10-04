<?php

namespace App\Services\TelegramBot\Messages;

use Telegram\Bot\Objects\Update;

interface SendableMessage
{
    public function __invoke(...$params) : array;
}
