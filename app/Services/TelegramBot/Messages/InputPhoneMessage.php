<?php

namespace App\Services\TelegramBot\Messages;

class InputPhoneMessage implements SendableMessage
{
    public function __invoke(...$params) : array
    {
        return [
            'text' => 'Введите Ваш телефон (что бы пропустить введите минус (-) и нажмите Enter)',
        ];
    }
}
