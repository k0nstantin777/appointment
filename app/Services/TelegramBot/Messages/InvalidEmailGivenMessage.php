<?php

namespace App\Services\TelegramBot\Messages;

class InvalidEmailGivenMessage implements SendableMessage
{
    public function __invoke(...$params) : array
    {
        return [
            'text' => 'Email некорректный, пожалуйста отправьте корректный Email.',
        ];
    }
}
