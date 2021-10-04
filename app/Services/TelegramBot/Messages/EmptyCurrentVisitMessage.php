<?php

namespace App\Services\TelegramBot\Messages;

class EmptyCurrentVisitMessage implements SendableMessage
{
    public function __invoke(...$params): array
    {
        return [
            'text' => 'Пока оформление визита не начато, пожалуйста воспользуйтесь подсказками для начала оформления визита.'
        ];
    }
}
