<?php

namespace App\Services\TelegramBot\Handlers;

use App\Services\TelegramBot\Enums\AppointmentParam;
use App\Services\TelegramBot\Messages\SelectCategoryMessage;
use Telegram\Bot\Objects\Update;

class SelectCategoryHandler extends AbstractHandler
{
    public function handle(Update $update): void
    {
        $appointment = $this->storage->get($update->getChat()->id);

        if (!$appointment ||
            $appointment->getCategoryId() ||
            ($update->callbackQuery && str_contains($update->callbackQuery->data, AppointmentParam::CATEGORY))
        ) {
            parent::handle($update);
            return;
        }

        $sectionId = $appointment->getSectionId();

        $message = new SelectCategoryMessage();
        $this->telegram->sendMessage(array_merge([
                'chat_id' => $update->getChat()->id,
            ], $message($sectionId))
        );
    }
}
