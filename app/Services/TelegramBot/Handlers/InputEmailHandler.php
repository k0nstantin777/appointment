<?php

namespace App\Services\TelegramBot\Handlers;

use App\Services\TelegramBot\Messages\InputEmailMessage;
use Telegram\Bot\Objects\Update;

class InputEmailHandler extends AbstractHandler
{
    public function handle(Update $update): void
    {
        $appointment = $this->storage->get($update->getChat()->id);

        if (!$appointment ||
            $appointment->getEmail() ||
            $appointment->isTouched('email')
        ) {
            parent::handle($update);
            return;
        }

        $appointment->touchProperty('email');
        $this->storage->save($update->getChat()->id, $appointment);

        $message = new InputEmailMessage();
        $this->telegram->sendMessage(array_merge([
                'chat_id' => $update->getChat()->id,
            ], $message())
        );
    }
}
