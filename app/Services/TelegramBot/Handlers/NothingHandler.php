<?php

namespace App\Services\TelegramBot\Handlers;

use Telegram\Bot\Objects\Update;

class NothingHandler extends AbstractHandler
{
    public function handle(Update $update): void
    {
        // do nothing, wait correct action from chat
    }
}
