<?php

namespace App\Services\TelegramBot\Messages;

class ErrorMessage implements SendableMessage
{
    public function __invoke(...$params) : array
    {
        return [
            'text' => escapeBotChars('Упссс..., кажется что-то пошло не так. ' . "\n" .
                'Попробуйте заново создать визит, если ошибка повторится, свяжитесь с нами.'
            ),
            'parse_mode' => 'MarkdownV2'
        ];
    }
}
