<?php

namespace App\Services\TelegramBot\Messages;

class PhoneGivenMessage implements SendableMessage
{
    public function __invoke(...$params) : array
    {
        [$phone] = $params;

        return [
            'text' => 'Введено: ' . $phone,
        ];
    }
}
