<?php

namespace Tests\Mocks;

use Telegram\Bot\Api;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

class TelegramBotApi extends Api
{
    protected array $responses = [];

    protected ?Update $update = null;
    protected array $sentMessage = [];

    public function getWebhookUpdate($shouldEmitEvent = true): Update
    {
        if (!$this->update) {
            $this->setMessageUpdate();
        }

        return $this->getResponse(
            'getWebhookUpdate',
            $this->update,
        );
    }

    public function sendMessage(array $params) : Message
    {
        $this->sentMessage = $params;

        return new Message([]);
    }

    public function getSentMessage() : array
    {
        return $this->sentMessage;
    }

    public function setResponses(array $responses): void
    {
        $this->responses = $responses;
    }

    public function setMessageUpdate(array $updateData = []) : void
    {
        $this->update = new Update(array_merge([
            "update_id" => 217632305,
            ], [
                'message' => array_replace_recursive($this->getDefaultUpdateMessageData(), $updateData)
            ],
        ));
    }

    public function setCallbackQueryUpdate(array $updateData = []) : void
    {
        $this->update = new Update(array_merge([
                "update_id" => 217632305,
            ], [
                'callback_query' => array_replace_recursive($this->getDefaultUpdateCallbacQuerykData(), $updateData)
            ]
        ));
    }

    private function getDefaultUpdateMessageData() : array
    {
        return [
            "message_id" => 442,
            "from" => [
                "id" => 468431435,
                "is_bot" => false,
                "first_name" => "Test",
                "username" => "TestUsername",
            ],
            "chat" => [
                "id" => 468431435,
                "first_name" => "Test",
                "username" => "TestUsername",
                "type" => "private"
            ],
            "date" => 1633101759,
            "text" => "test message"
        ];
    }

    private function getDefaultUpdateCallbacQuerykData() : array
    {
        return [
            "id" => "2011897697374352782",
            "from" => [
                "id" => 468431435,
                "is_bot" => false,
                "first_name" => "\u041a\u043e\u043d\u0441\u0442\u0430\u043d\u0442\u0438\u043d",
                "username" => "K0ntantin777",
                "language_code" => "en"
            ],
            "message" => [
                "message_id" => 451,
                "from" => [
                    "id" => 2034726561,
                    "is_bot" => true,
                    "first_name" => "Online_Appointment",
                    "username" => "online_appointment_bot",
                ],
                "chat" => [
                    "id" => 468431435,
                    "first_name" => "\u041a\u043e\u043d\u0441\u0442\u0430\u043d\u0442\u0438\u043d",
                    "username"=> "K0ntantin777",
                    "type" => "private",
                ],
                "date" => 1633102009,
                "text" => "\u0412\u044b\u0431\u0435\u0440\u0438\u0442\u0435 \u043d\u0430\u043f\u0440\u0430\u0432\u043b\u0435\u043d\u0438\u0435",
                "reply_markup" => [
                    "inline_keyboard"=> [
                        [
                            "text" => "\u041c\u0443\u0436\u0441\u043a\u043e\u0439 \u0437\u0430\u043b",
                            "callback_data" => "visit_section::1"
                        ],
                        [
                            "text" => "\u0416\u0435\u043d\u0441\u043a\u0438\u0439 \u0437\u0430\u043b",
                            "callback_data" => "visit_section::2"
                        ]
                    ]
                ],
            ],
            "chat_instance" => "-3045457940892878401",
            "data" => "visit_section::1"
        ];
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
