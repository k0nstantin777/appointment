<?php

namespace App\Services\TelegramBot\Handlers;

use App\Services\Entities\ServiceService;
use App\Services\TelegramBot\Enums\AppointmentParam;
use App\Services\TelegramBot\Helpers\ButtonParamHelper;
use App\Services\TelegramBot\Messages\ServiceSelectedMessage;
use Telegram\Bot\Objects\Update;

class ServiceSelectedHandler extends AbstractHandler
{
    public function handle(Update $update): void
    {
        $appointment = $this->storage->get($update->getChat()->id);

        if (!$appointment ||
            $appointment->getServiceId() ||
            !$update->callbackQuery ||
            !str_contains($update->callbackQuery->data, AppointmentParam::SERVICE)
        ) {
            parent::handle($update);
            return;
        }

        $decodedCallbackData = app(ButtonParamHelper::class)->decode($update->callbackQuery->data);
        $serviceId = $decodedCallbackData[1] ?? null;

        if (!$serviceId) {
            return;
        }

        $service = ServiceService::getInstance()->getById($serviceId);

        $appointment->setServiceId($serviceId);
        $appointment->setPrice($service->price);
        $this->storage->save($update->getChat()->id, $appointment);

        $message = new ServiceSelectedMessage();

        $this->telegram->sendMessage(array_merge([
                'chat_id' => $update->getChat()->id,
            ], $message($service))
        );

        parent::handle($update);
    }
}
