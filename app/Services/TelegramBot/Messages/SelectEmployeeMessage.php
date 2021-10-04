<?php

namespace App\Services\TelegramBot\Messages;

use App\Services\Entities\EmployeeService;
use App\Services\Entities\ServiceService;
use App\Services\TelegramBot\Enums\AppointmentParam;
use App\Services\TelegramBot\Helpers\ButtonParamHelper;
use App\Services\TelegramBot\Models\Appointment;
use Carbon\Carbon;
use Telegram\Bot\Keyboard\Keyboard;

class SelectEmployeeMessage implements SendableMessage
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

        $service = ServiceService::getInstance()->getById($appointment->getServiceId());
        $visitDate = $appointment->getVisitDate();

        $employees = $service->employees;
        $freeEmployees = collect();


        $employeeService = EmployeeService::getInstance();
        foreach ($employees as $employee) {
            $freeTimes = $employeeService->getFreeTimesByIdDateAndDuration(
                $employee->id,
                Carbon::parse($visitDate)->toDateString(),
                $service->duration_in_minutes,
            );

            if ($freeTimes->isNotEmpty()) {
               $freeEmployees->push($employee);
            }
        }

        if ($freeEmployees->isEmpty()) {
            $text = 'Свободных мастеров на данную дату нет. Попробуйте создать визит заново и выбрать другую дату';
        } else {
            $text = 'Выберите мастера';
            foreach ($freeEmployees as $employee) {
                $keyboard->row(Keyboard::inlineButton([
                    'text' => $employee->name,
                    'callback_data' => app(ButtonParamHelper::class)
                        ->encode([AppointmentParam::EMPLOYEE, $employee->id]),
                ]));
            }
        }

        return [
            'text' => $text,
            'reply_markup' => $keyboard,
        ];
    }
}
