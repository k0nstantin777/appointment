<?php

namespace App\Services\TelegramBot\Messages;

class AppointmentCompletedMessage implements SendableMessage
{
    public function __invoke(...$params) : array
    {
        return [
            'text' => escapeBotChars('Визит оформлен. На указанный Email придет подтверждение. Ждем Вас!' . "\n"
                . 'Что бы оформить новый визит воспользуйтесь подсказками бота')
            ,
            'parse_mode' => 'MarkdownV2'
        ];
    }
}
