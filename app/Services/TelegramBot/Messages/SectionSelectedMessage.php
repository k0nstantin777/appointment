<?php

namespace App\Services\TelegramBot\Messages;

use Telegram\Bot\Keyboard\Keyboard;

class SectionSelectedMessage implements SendableMessage
{
    public function __invoke(...$params) : array
    {
        [$section] = $params;

        return [
            'text' => 'Выбрано: ' . $section->name,
            'reply_markup' => Keyboard::remove(),
        ];
    }
}
