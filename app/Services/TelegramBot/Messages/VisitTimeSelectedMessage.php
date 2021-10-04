<?php

namespace App\Services\TelegramBot\Messages;

use Telegram\Bot\Keyboard\Keyboard;

class VisitTimeSelectedMessage implements SendableMessage
{
    public function __invoke(...$params) : array
    {
        [$startTime, $endTime] = $params;

        return [
            'text' => 'Выбрано: ' . $startTime . ' - ' . $endTime,
            'reply_markup' => Keyboard::remove(),
        ];
    }
}
