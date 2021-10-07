<?php

namespace App\Services\TelegramBot\Handlers;

use App\Services\TelegramBot\Messages\EmailGivenMessage;
use App\Services\TelegramBot\Messages\InvalidEmailGivenMessage;
use Telegram\Bot\Objects\Update;

class EmailGivenHandler extends AbstractHandler
{
    public function handle(Update $update): void
    {
        $appointment = $this->storage->get($update->getChat()->id);

        if (!$appointment ||
            $appointment->getEmail() ||
            !$update->message ||
            !$update->message->text
        ) {
            parent::handle($update);
            return;
        }

        $email = $update->message->text;

        if (false === $this->isValidEmail($email)) {
            $message = new InvalidEmailGivenMessage();
            $this->telegram->sendMessage(array_merge([
                    'chat_id' => $update->getChat()->id,
                ], $message($email))
            );
            return;
        }

        $message = new EmailGivenMessage();
        $appointment->setEmail($email);
        $this->storage->save($update->getChat()->id, $appointment);


        $this->telegram->sendMessage(array_merge([
                'chat_id' => $update->getChat()->id,
            ], $message($email))
        );

        parent::handle($update);
    }

    private function isValidEmail(string $email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
