<?php

namespace App\Services\TelegramBot\Handlers;

use App\Services\TelegramBot\Enums\AppointmentParam;
use App\Services\TelegramBot\Helpers\ButtonParamHelper;
use App\Services\TelegramBot\Messages\VisitDateSelectedMessage;
use Telegram\Bot\Objects\Update;

class DateSelectedHandler extends AbstractHandler
{
    public function handle(Update $update): void
    {
        $appointment = $this->storage->get($update->getChat()->id);

        if (!$appointment ||
            $appointment->getVisitDate() ||
            !$update->callbackQuery ||
            !str_contains($update->callbackQuery->data, AppointmentParam::DATE)
        ) {
            parent::handle($update);
            return;
        }

        $decodedCallbackData = app(ButtonParamHelper::class)->decode($update->callbackQuery->data);
        $date = $decodedCallbackData[1] ?? null;

        if (!$date) {
            return;
        }

        $appointment->setVisitDate($date);
        $this->storage->save($update->getChat()->id, $appointment);

        $message = new VisitDateSelectedMessage();

        $this->telegram->sendMessage(array_merge([
                'chat_id' => $update->getChat()->id,
            ], $message($date))
        );

        parent::handle($update);
    }
}
