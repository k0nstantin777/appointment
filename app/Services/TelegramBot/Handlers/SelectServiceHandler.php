<?php

namespace App\Services\TelegramBot\Handlers;

use App\Services\TelegramBot\Enums\AppointmentParam;
use App\Services\TelegramBot\Messages\SelectServiceMessage;
use Telegram\Bot\Objects\Update;

class SelectServiceHandler extends AbstractHandler
{
    public function handle(Update $update): void
    {
        $appointment = $this->storage->get($update->getChat()->id);

        if (!$appointment ||
            $appointment->getServiceId() ||
            ($update->callbackQuery && str_contains($update->callbackQuery->data, AppointmentParam::SERVICE))
        ) {
            parent::handle($update);
            return;
        }

        $categoryId = $appointment->getCategoryId();

        $message = new SelectServiceMessage();
        $this->telegram->sendMessage(array_merge([
                'chat_id' => $update->getChat()->id,
            ], $message($categoryId))
        );
    }
}
