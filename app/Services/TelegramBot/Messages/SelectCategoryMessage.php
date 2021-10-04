<?php

namespace App\Services\TelegramBot\Messages;

use App\Services\Entities\CategoryService;
use App\Services\TelegramBot\Enums\AppointmentParam;
use App\Services\TelegramBot\Helpers\ButtonParamHelper;
use Telegram\Bot\Keyboard\Keyboard;

class SelectCategoryMessage implements SendableMessage
{
    public function __invoke(...$params) : array
    {
        $text = 'Выберите категорию';

        $keyboard = new Keyboard();

        $keyboard
            ->inline()
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true);

        [$sectionId] = $params;

        $categoryService = CategoryService::getInstance();

        if ($sectionId) {
            $categories = $categoryService->getCollectionBySectionId($sectionId);
        } else {
            $categories = $categoryService->all();
        }

        foreach ($categories as $category) {
            $keyboard->row(Keyboard::inlineButton([
                'text' => $category->name,
                'callback_data' => app(ButtonParamHelper::class)
                    ->encode([AppointmentParam::CATEGORY, $category->id]),
            ]));
        }

        return [
            'text' => $text,
            'reply_markup' => $keyboard,
        ];
    }
}
