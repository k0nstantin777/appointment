<?php

namespace App\Services\TelegramBot\Handlers;

use App\Services\Entities\CategoryService;
use App\Services\TelegramBot\Enums\AppointmentParam;
use App\Services\TelegramBot\Helpers\ButtonParamHelper;
use App\Services\TelegramBot\Messages\CategorySelectedMessage;
use Telegram\Bot\Objects\Update;

class CategorySelectedHandler extends AbstractHandler
{
    public function handle(Update $update): void
    {
        $appointment = $this->storage->get($update->getChat()->id);

        if (!$appointment ||
            $appointment->getCategoryId() ||
            !$update->callbackQuery ||
            !str_contains($update->callbackQuery->data, AppointmentParam::CATEGORY)
        ) {
            parent::handle($update);
            return;
        }

        $decodedCallbackData = app(ButtonParamHelper::class)->decode($update->callbackQuery->data);
        $categoryId = $decodedCallbackData[1] ?? null;

        if (!$categoryId) {
            return;
        }

        $category = CategoryService::getInstance()->getById($categoryId);

        $appointment->setCategoryId($categoryId);
        $this->storage->save($update->getChat()->id, $appointment);

        $message = new CategorySelectedMessage();

        $this->telegram->sendMessage(array_merge([
                'chat_id' => $update->getChat()->id,
            ], $message($category))
        );

        parent::handle($update);
    }
}
