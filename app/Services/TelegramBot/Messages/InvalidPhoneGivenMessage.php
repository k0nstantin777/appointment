<?php

namespace App\Services\TelegramBot\Messages;

class InvalidPhoneGivenMessage implements SendableMessage
{
    public function __invoke(...$params) : array
    {
        return [
            'text' => 'Телефон некорректный, пожалуйста введите корректный телефон.',
        ];
    }
}
