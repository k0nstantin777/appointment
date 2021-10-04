<?php

namespace App\Services\TelegramBot\Messages;

use App\Services\Entities\SectionService;
use App\Services\TelegramBot\Enums\AppointmentParam;
use App\Services\TelegramBot\Helpers\ButtonParamHelper;
use Telegram\Bot\Keyboard\Keyboard;

class SelectSectionMessage implements SendableMessage
{
    public function __invoke(...$params) : array
    {
        $text = 'Выберите направление';

        $keyboard = new Keyboard();

        $keyboard
            ->inline()
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true);

        $sections = SectionService::getInstance()->all();

        foreach ($sections as $section) {
            $keyboard->row(Keyboard::inlineButton([
                'text' => $section->name,
                'callback_data' => app(ButtonParamHelper::class)
                    ->encode([AppointmentParam::SECTION, $section->id]),
            ]));
        }

        return [
            'text' => $text,
            'reply_markup' => $keyboard,
        ];
    }
}
