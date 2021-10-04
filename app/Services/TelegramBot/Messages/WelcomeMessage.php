<?php

namespace App\Services\TelegramBot\Messages;

class WelcomeMessage implements SendableMessage
{
    public function __invoke(...$params): array
    {
        return [
            'text' => 'Добрый день! Спасибо за обращение. Следуйте инструкциям для создания визита.'
        ];
    }
}
