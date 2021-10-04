<?php

namespace App\Services\TelegramBot\Handlers;

use App\Services\TelegramBot\Messages\AppointmentCompletedMessage;
use Telegram\Bot\Objects\Update;

class AppointmentCompletedHandler extends AbstractHandler
{
    public function handle(Update $update): void
    {
        $message = new AppointmentCompletedMessage();
        $this->telegram->sendMessage(array_merge([
                'chat_id' => $update->getChat()->id,
            ], $message())
        );

        parent::handle($update);
    }
}
