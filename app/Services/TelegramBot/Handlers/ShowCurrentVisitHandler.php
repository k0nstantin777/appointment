<?php

namespace App\Services\TelegramBot\Handlers;

use App\Services\TelegramBot\Messages\EmptyCurrentVisitMessage;
use App\Services\TelegramBot\Messages\ShowCurrentVisitMessage;
use Telegram\Bot\Objects\Update;

class ShowCurrentVisitHandler extends AbstractHandler
{
    public function handle(Update $update): void
    {
        $appointment = $this->storage->get($update->getChat()->id);

        if (!$appointment || (!$appointment->getSectionId() && !$appointment->getCategoryId())) {
            $message = new EmptyCurrentVisitMessage();
        } else {
            $message = new ShowCurrentVisitMessage();
        }

        $this->telegram->sendMessage(array_merge([
                'chat_id' => $update->getChat()->id,
            ], $message($appointment))
        );

        parent::handle($update);
    }
}
