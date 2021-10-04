<?php

namespace App\Services\TelegramBot\Handlers;

use App\Services\TelegramBot\Enums\AppointmentParam;
use App\Services\TelegramBot\Helpers\ButtonParamHelper;
use App\Services\TelegramBot\Messages\VisitTimeSelectedMessage;
use Telegram\Bot\Objects\Update;

class VisitTimeSelectedHandler extends AbstractHandler
{
    public function handle(Update $update): void
    {
        $appointment = $this->storage->get($update->getChat()->id);

        if (!$appointment ||
            ($appointment->getStartTime() && $appointment->getEndTime()) ||
            !$update->callbackQuery ||
            !str_contains($update->callbackQuery->data, AppointmentParam::VISIT_TIME)
        ) {
            parent::handle($update);
            return;
        }

        $decodedCallbackData = app(ButtonParamHelper::class)->decode($update->callbackQuery->data);
        $startTime = $decodedCallbackData[1] ?? null;
        $endTime = $decodedCallbackData[2] ?? null;

        if (!$startTime || !$endTime) {
            return;
        }

        $appointment->setStartTime($startTime);
        $appointment->setEndTime($endTime);
        $this->storage->save($update->getChat()->id, $appointment);

        $message = new VisitTimeSelectedMessage();

        $this->telegram->sendMessage(array_merge([
                'chat_id' => $update->getChat()->id,
            ], $message($startTime,$endTime))
        );

        parent::handle($update);
    }
}
