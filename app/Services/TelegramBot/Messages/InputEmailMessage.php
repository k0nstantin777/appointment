<?php

namespace App\Services\TelegramBot\Messages;

class InputEmailMessage implements SendableMessage
{
    public function __invoke(...$params) : array
    {
        return [
            'text' => 'Введите Ваш email, мы отправим на него детали визита',
        ];
    }
}
