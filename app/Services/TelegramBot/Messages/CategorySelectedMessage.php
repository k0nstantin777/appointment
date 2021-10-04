<?php

namespace App\Services\TelegramBot\Messages;

use Telegram\Bot\Keyboard\Keyboard;

class CategorySelectedMessage implements SendableMessage
{
    public function __invoke(...$params) : array
    {
        [$category] = $params;

        return [
            'text' => 'Выбрано: ' . $category->name,
            'reply_markup' => Keyboard::remove(),
        ];
    }
}
