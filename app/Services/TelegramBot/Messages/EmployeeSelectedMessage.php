<?php

namespace App\Services\TelegramBot\Messages;

use Telegram\Bot\Keyboard\Keyboard;

class EmployeeSelectedMessage implements SendableMessage
{
    public function __invoke(...$params) : array
    {
        [$employee] = $params;

        return [
            'text' => 'Выбрано: ' . $employee->name,
            'reply_markup' => Keyboard::remove(),
        ];
    }
}
