<?php

namespace App\Services\TelegramBot\Messages;

class VisitCreatedMessage implements SendableMessage
{
    public function __invoke(...$params) : array
    {
        [$visit] = $params;

        return [
            'text' => 'Визит создан. Номер визита: ' . $visit->id,
        ];
    }
}
