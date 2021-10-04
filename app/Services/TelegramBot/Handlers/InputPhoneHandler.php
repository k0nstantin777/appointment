<?php

namespace App\Services\TelegramBot\Handlers;

use App\Services\TelegramBot\Messages\InputPhoneMessage;
use Telegram\Bot\Objects\Update;

class InputPhoneHandler extends AbstractHandler
{
    public function handle(Update $update): void
    {
        $appointment = $this->storage->get($update->getChat()->id);

        if (!$appointment ||
            $appointment->getPhone() ||
            $appointment->isTouched('phone')
        ) {
            parent::handle($update);
            return;
        }

        $appointment->touchProperty('phone');
        $this->storage->save($update->getChat()->id, $appointment);

        $message = new InputPhoneMessage();
        $this->telegram->sendMessage(array_merge([
                'chat_id' => $update->getChat()->id,
            ], $message())
        );
    }
}
