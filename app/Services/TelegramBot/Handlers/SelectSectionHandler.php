<?php

namespace App\Services\TelegramBot\Handlers;

use App\Models\Section;
use App\Services\TelegramBot\Messages\SelectSectionMessage;
use Telegram\Bot\Objects\Update;

class SelectSectionHandler extends AbstractHandler
{
    public function handle(Update $update): void
    {
        $appointment = $this->storage->get($update->getChat()->id);

        if (!$appointment ||
            $appointment->getSectionId() ||
            $update->callbackQuery ||
            !Section::first()
        ) {
            parent::handle($update);
            return;
        }

        $message = new SelectSectionMessage;
        $this->telegram->sendMessage(array_merge([
                'chat_id' => $update->getChat()->id,
            ], $message())
        );
    }
}
