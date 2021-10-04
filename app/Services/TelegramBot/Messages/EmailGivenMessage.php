<?php

namespace App\Services\TelegramBot\Messages;

class EmailGivenMessage implements SendableMessage
{
    public function __invoke(...$params) : array
    {
        [$email] = $params;

        return [
            'text' => 'Введено: ' . $email,
        ];
    }
}
