<?php

namespace Tests\Mocks;

use Telegram\Bot\Api;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

class TelegramBotApi extends Api
{
    protected array $responses = [];

//    protected ?Update $update = null;

    public function getWebhookUpdate($shouldEmitEvent = true): Update
    {
        return $this->getResponse('getWebhookUpdate', new Update([
           "update_id" => 217632305,
            "message" => [
                "message_id" => 442,
                "from" => [
                    "id" => 468431435,
                    "is_bot" => false,
                    "first_name" => "Test",
                    "username" => "K0ntantin777",
                ],
                "chat" => [
                    "id" => 468431435,
                    "first_name" => "Test",
                    "username" => "K0ntantin777",
                    "type" => "private"],
                "date" => 1633101759,
                "text" => "khk"]
        ]));
    }

    public function sendMessage(array $params) : Message
    {
        return new Message([]);
    }

    public function setResponses(array $responses)
    {
        return $this->responses = $responses;
    }

    private function getResponse(string $method, $default = [])
    {
        if (!isset($this->responses[$method])) {
            return $default;
        }

        if (is_callable($this->responses[$method])) {
            return $this->responses[$method]();
        }

        return $this->responses[$method];
    }
}
