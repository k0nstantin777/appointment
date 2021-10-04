<?php

namespace App\Services\TelegramBot\Handlers;

use App\Services\TelegramBot\Messages\ErrorMessage;
use Telegram\Bot\Objects\Update;

class ErrorHandler extends AbstractHandler
{
    public function handle(Update $update): void
    {
        $message = new ErrorMessage();
        $this->telegram->sendMessage(array_merge([
                'chat_id' => $update->getChat()->id,
            ], $message())
        );
    }
}
