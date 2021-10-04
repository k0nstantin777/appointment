<?php

namespace App\Services\TelegramBot\Messages;

use Telegram\Bot\Keyboard\Keyboard;

class VisitDateSelectedMessage implements SendableMessage
{
    public function __invoke(...$params) : array
    {
        [$date] = $params;

        return [
            'text' => 'Выбрано: ' . $date,
            'reply_markup' => Keyboard::remove(),
        ];
    }
}
