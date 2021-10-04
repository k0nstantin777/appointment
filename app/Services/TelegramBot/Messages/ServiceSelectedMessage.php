<?php

namespace App\Services\TelegramBot\Messages;

use Telegram\Bot\Keyboard\Keyboard;

class ServiceSelectedMessage implements SendableMessage
{
    public function __invoke(...$params) : array
    {
        [$service] = $params;

        return [
            'text' => 'Выбрано: ' . $service->name,
            'reply_markup' => Keyboard::remove(),
        ];
    }
}
