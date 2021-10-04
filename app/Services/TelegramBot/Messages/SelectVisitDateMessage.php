<?php

namespace App\Services\TelegramBot\Messages;

use App\Services\TelegramBot\Enums\AppointmentParam;
use App\Services\TelegramBot\Helpers\ButtonParamHelper;
use Telegram\Bot\Keyboard\Keyboard;

class SelectVisitDateMessage implements SendableMessage
{
    private const OPEN_DAYS = 14;
    private const BUTTON_ROWS = 5;

    public function __invoke(...$params) : array
    {
        $text = 'Выберите удобную дату';

        $keyboard = new Keyboard();

        $keyboard
            ->inline()
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true);

        $today = now();
        $lastAppointmentDay = $today->copy()->addDays(self::OPEN_DAYS);

        $dates = collect();

        while($today->lessThanOrEqualTo($lastAppointmentDay)) {
            $dates->push($today->format('d.m.Y'));
            $today->addDay();
        }

        foreach ($dates->split(self::BUTTON_ROWS) as $datesGroup) {
            $row = [];
            foreach ($datesGroup as $date) {
                $row[] = Keyboard::inlineButton([
                    'text' => $date,
                    'callback_data' => app(ButtonParamHelper::class)
                        ->encode([AppointmentParam::DATE, $date]),
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
