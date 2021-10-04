<?php

namespace App\Services\TelegramBot\Handlers;

use App\Services\TelegramBot\Enums\AppointmentParam;
use App\Services\TelegramBot\Messages\SelectVisitTimeMessage;
use Telegram\Bot\Objects\Update;

class SelectVisitTimeHandler extends AbstractHandler
{
    public function handle(Update $update): void
    {
        $appointment = $this->storage->get($update->getChat()->id);

        if (!$appointment ||
            ($appointment->getStartTime() && $appointment->getEndTime()) ||
            ($update->callbackQuery && str_contains($update->callbackQuery->data, AppointmentParam::VISIT_TIME))
        ) {
            parent::handle($update);
            return;
        }

        $message = new SelectVisitTimeMessage();
        $this->telegram->sendMessage(array_merge([
                'chat_id' => $update->getChat()->id,
            ], $message($appointment))
        );
    }
}
