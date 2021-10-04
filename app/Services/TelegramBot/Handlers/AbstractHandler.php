<?php

namespace App\Services\TelegramBot\Handlers;

use App\Services\TelegramBot\Storages\AppointmentStorage;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

abstract class AbstractHandler implements Handler
{
    private ?Handler $nextHandler = null;

    public function __construct(
        protected Api $telegram,
        protected AppointmentStorage $storage
    ) {

    }

    public function setNext(Handler $handler): Handler
    {
        $this->nextHandler = $handler;

        return $handler;
    }

    public function handle(Update $update): void
    {
        if ($this->nextHandler) {
            $this->nextHandler->handle($update);
        }
    }
}
