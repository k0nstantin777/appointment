<?php

namespace App\Services\TelegramBot\Handlers;

use App\Services\TelegramBot\Enums\AppointmentParam;
use App\Services\TelegramBot\Messages\SelectEmployeeMessage;
use Telegram\Bot\Objects\Update;

class SelectEmployeeHandler extends AbstractHandler
{
    public function handle(Update $update): void
    {
        $appointment = $this->storage->get($update->getChat()->id);

        if (!$appointment ||
            $appointment->getEmployeeId() ||
            ($update->callbackQuery && str_contains($update->callbackQuery->data, AppointmentParam::EMPLOYEE))
        ) {
            parent::handle($update);
            return;
        }

        $message = new SelectEmployeeMessage();
        $this->telegram->sendMessage(array_merge([
                'chat_id' => $update->getChat()->id,
            ], $message($appointment))
        );
    }
}
