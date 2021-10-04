<?php

namespace App\Services\TelegramBot\Handlers;

use App\Services\Entities\EmployeeService;
use App\Services\TelegramBot\Enums\AppointmentParam;
use App\Services\TelegramBot\Helpers\ButtonParamHelper;
use App\Services\TelegramBot\Messages\EmployeeSelectedMessage;
use Telegram\Bot\Objects\Update;

class EmployeeSelectedHandler extends AbstractHandler
{
    public function handle(Update $update): void
    {
        $appointment = $this->storage->get($update->getChat()->id);

        if (!$appointment ||
            $appointment->getEmployeeId() ||
            !$update->callbackQuery ||
            !str_contains($update->callbackQuery->data, AppointmentParam::EMPLOYEE)
        ) {
            parent::handle($update);
            return;
        }

        $decodedCallbackData = app(ButtonParamHelper::class)->decode($update->callbackQuery->data);
        $employeeId = $decodedCallbackData[1] ?? null;

        if (!$employeeId) {
            return;
        }

        $employee = EmployeeService::getInstance()->getById($employeeId);

        $appointment->setEmployeeId($employeeId);
        $this->storage->save($update->getChat()->id, $appointment);

        $message = new EmployeeSelectedMessage();

        $this->telegram->sendMessage(array_merge([
                'chat_id' => $update->getChat()->id,
            ], $message($employee))
        );

        parent::handle($update);
    }
}
