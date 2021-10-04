<?php

namespace App\Services\TelegramBot\Handlers;

use App\Services\TelegramBot\Messages\WelcomeMessage;
use App\Services\TelegramBot\Models\Appointment;
use Telegram\Bot\Objects\Update;

class NewVisitHandler extends AbstractHandler
{
    public function handle(Update $update): void
    {
        $this->storage->save($update->getChat()->id, new Appointment());

        $message = new WelcomeMessage();
        $this->telegram->sendMessage(array_merge([
                'chat_id' => $update->getChat()->id,
            ], $message())
        );

        parent::handle($update);
    }
}
