<?php

namespace App\Services\TelegramBot\Messages;

use App\Services\Entities\ServiceService;
use App\Services\TelegramBot\Enums\AppointmentParam;
use App\Services\TelegramBot\Helpers\ButtonParamHelper;
use Telegram\Bot\Keyboard\Keyboard;

class SelectServiceMessage implements SendableMessage
{
    private const BUTTON_ROWS = 3;

    public function __invoke(...$params) : array
    {
        $text = 'Выберите услугу';

        $keyboard = new Keyboard();

        $keyboard
            ->inline()
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true);

        [$categoryId] = $params;

        $serviceService = ServiceService::getInstance();

        if ($categoryId) {
            $services = $serviceService->getCollectionByCategoryId($categoryId);
        } else {
            $services = $serviceService->all();
        }

        foreach ($services->split(self::BUTTON_ROWS) as $serviceGroup) {
            $row = [];
            foreach ($serviceGroup as $service) {
                $row[] = Keyboard::inlineButton([
                    'text' => $service->name . ' - ' . $service->price . ' руб',
                    'callback_data' => app(ButtonParamHelper::class)
                        ->encode([AppointmentParam::SERVICE, $service->id]),
                ]);
            }
            $keyboard->row(...$row);
        }

        return [
            'text' => $text,
            'reply_markup' => $keyboard,
        ];
    }
}
