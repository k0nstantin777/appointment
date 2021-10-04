<?php

namespace App\Services\TelegramBot\Messages;

use App\Models\Category;
use App\Models\Employee;
use App\Models\Section;
use App\Models\Service;
use App\Services\TelegramBot\Models\Appointment;

class ShowCurrentVisitMessage implements SendableMessage
{
    public function __invoke(...$params): array
    {
        /* @var Appointment $appointment */
        [$appointment] = $params;

        $text = "Текущий визит:\n";

        if ($appointment->getSectionId()) {
            $section = Section::find($appointment->getSectionId());
            $text.= '*Направление*: ' . escapeBotChars($section->name) . "\n";
        }

        if ($appointment->getCategoryId()) {
            $category = Category::find($appointment->getCategoryId());
            $text.= '*Категория*: ' . escapeBotChars($category->name) . "\n";
        }

        if ($appointment->getServiceId()) {
            $service = Service::find($appointment->getServiceId());
            $text.= '*Услуга*: ' . escapeBotChars($service->name) . "\n";
            $text.= '*Стоимость*: ' . escapeBotChars($appointment->getPrice() . ' руб.')  . "\n";
        }

        if ($appointment->getVisitDate()) {
            $text.= '*Дата*: ' . escapeBotChars($appointment->getVisitDate()) . "\n";
        }

        if ($appointment->getStartTime() && $appointment->getEndTime()) {
            $text.= '*Время*: ' . escapeBotChars($appointment->getStartTime() . ' - '. $appointment->getEndTime()) . "\n";
        }

        if ($appointment->getEmployeeId()) {
            $employee = Employee::find($appointment->getEmployeeId());
            $text.= '*Мастер*: ' . escapeBotChars($employee->name) . "\n";
        }

        if ($appointment->getEmail()) {
            $text.= '*Ваш Email*: ' . escapeBotChars($appointment->getEmail()) . "\n";
        }

        if ($appointment->getPhone()) {
            $text.= '*Ваш Телефон*: ' . escapeBotChars($appointment->getPhone()) . "\n";
        }

        return [
            'text' => $text,
            'parse_mode' => 'MarkdownV2'
        ];
    }
}
