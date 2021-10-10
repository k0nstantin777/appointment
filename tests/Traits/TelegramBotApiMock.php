<?php

namespace Tests\Traits;

use Telegram\Bot\Api;
use Tests\Mocks\TelegramBotApi;

trait TelegramBotApiMock
{
    public function setUpTelegramBotApiMock(array $responses = []): void
    {
        $api = new TelegramBotApi('token');
        $api->setResponses($responses);

        $this->instance(
            Api::class,
            $api
        );
    }
}
