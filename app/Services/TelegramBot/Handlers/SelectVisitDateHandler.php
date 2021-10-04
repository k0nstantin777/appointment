<?php

namespace App\Services\TelegramBot\Handlers;

use App\Services\TelegramBot\Enums\AppointmentParam;
use App\Services\TelegramBot\Messages\SelectVisitDateMessage;
use Telegram\Bot\Objects\Update;

class SelectVisitDateHandler extends AbstractHandler
{
    public function handle(Update $update): void
    {
        $appointment = $this->storage->get($update->getChat()->id);

        if (!$appointment ||
            $appointment->getVisitDate() ||
            ($update->callbackQuery && str_contains($update->callbackQuery->data, AppointmentParam::DATE))
        ) {
            parent::handle($update);
            return;
        }

        $message = new SelectVisitDateMessage();
        $this->telegram->sendMessage(array_merge([
                'chat_id' => $update->getChat()->id,
            ], $message())
        );
    }
}
