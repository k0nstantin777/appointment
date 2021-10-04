<?php

namespace App\Services\TelegramBot\Handlers;

use App\Services\TelegramBot\Messages\InvalidPhoneGivenMessage;
use App\Services\TelegramBot\Messages\PhoneGivenMessage;
use Telegram\Bot\Objects\Update;

class PhoneGivenHandler extends AbstractHandler
{
    public function handle(Update $update): void
    {
        $appointment = $this->storage->get($update->getChat()->id);

        if (!$appointment ||
            $appointment->getPhone() ||
            !$update->message
        ) {
            parent::handle($update);
            return;
        }

        $phone = $update->message->text;

        if (!$phone) {
            $phone = '-';
        }

        if (!preg_match('/^\+?[0-9-]+/', $phone)) {
            $message = new InvalidPhoneGivenMessage();
            $this->telegram->sendMessage(array_merge([
                    'chat_id' => $update->getChat()->id,
                ], $message())
            );
            return;
        }

        $message = new PhoneGivenMessage();
        $appointment->setPhone($phone);
        $this->storage->save($update->getChat()->id, $appointment);

        $this->telegram->sendMessage(array_merge([
                'chat_id' => $update->getChat()->id,
            ], $message($phone))
        );

        parent::handle($update);
    }
}
