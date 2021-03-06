<?php

namespace App\Services\TelegramBot\Messages;

use App\Services\Entities\Employee\EmployeeFreeTimeService;
use App\Services\Entities\ServiceService;
use App\Services\TelegramBot\Enums\AppointmentParam;
use App\Services\TelegramBot\Helpers\ButtonParamHelper;
use App\Services\TelegramBot\Models\Appointment;
use Illuminate\Support\Carbon;
use Telegram\Bot\Keyboard\Keyboard;

class SelectVisitTimeMessage implements SendableMessage
{

    public function __invoke(...$params) : array
    {
        $keyboard = new Keyboard();

        $keyboard
            ->inline()
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true);

        /* @var Appointment $appointment */
        [$appointment] = $params;

        $visitDate = $appointment->getVisitDate();

        $employeeFreeTimeService = EmployeeFreeTimeService::getInstance();
        $service = ServiceService::getInstance()->getById($appointment->getServiceId());

        $freeTimes = $employeeFreeTimeService->getByDateAndDuration(
            $appointment->getEmployeeId(),
            Carbon::parse($visitDate)->toDateString(),
            $service->duration_in_minutes,
        );

        if ($freeTimes->isEmpty()) {
            $text = 'У выбранного мастера на данную дату нет свободного времени. Попробуйте создать визит заново и выбрать другую дату';
        } else {
            $text = 'Выберите время';
            foreach ($freeTimes as $freeTime) {
                $startTime = $freeTime[0]->format('H:i');
                $endTime =  $freeTime[1]->format('H:i');
                $keyboard->row(Keyboard::inlineButton([
                    'text' => $startTime . ' - ' . $endTime,
                    'callback_data' => app(ButtonParamHelper::class)
                        ->encode([AppointmentParam::VISIT_TIME, $startTime, $endTime]),
                ]));
            }
        }

        return [
            'text' => $text,
            'reply_markup' => $keyboard,
        ];
    }
}
