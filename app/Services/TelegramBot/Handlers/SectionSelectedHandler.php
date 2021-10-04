<?php

namespace App\Services\TelegramBot\Handlers;

use App\Services\Entities\SectionService;
use App\Services\TelegramBot\Enums\AppointmentParam;
use App\Services\TelegramBot\Helpers\ButtonParamHelper;
use App\Services\TelegramBot\Messages\SectionSelectedMessage;
use Telegram\Bot\Objects\Update;

class SectionSelectedHandler extends AbstractHandler
{
    public function handle(Update $update): void
    {
        $appointment = $this->storage->get($update->getChat()->id);

        if (!$appointment ||
            !$update->callbackQuery ||
            $appointment->getSectionId() ||
            !str_contains($update->callbackQuery->data, AppointmentParam::SECTION)
        ) {
            parent::handle($update);
            return;
        }

        $decodedCallbackData = app(ButtonParamHelper::class)->decode($update->callbackQuery->data);
        $sectionId = $decodedCallbackData[1] ?? null;

        if (!$sectionId) {
            return;
        }

        $section = SectionService::getInstance()->getById($sectionId);

        if (!$section) {
            return;
        }

        $appointment->setSectionId($sectionId);
        $this->storage->save($update->getChat()->id, $appointment);

        $selectedMessage = new SectionSelectedMessage;

        $this->telegram->sendMessage(array_merge([
                'chat_id' => $update->getChat()->id,
            ], $selectedMessage($section))
        );

        parent::handle($update);
    }
}
