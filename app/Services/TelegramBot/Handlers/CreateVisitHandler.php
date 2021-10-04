<?php

namespace App\Services\TelegramBot\Handlers;

use App\DataTransferObjects\StoreClientDto;
use App\DataTransferObjects\StoreVisitDto;
use App\Enums\VisitStatus;
use App\Models\Client;
use App\Models\Visit;
use App\Services\Entities\ClientService;
use App\Services\Entities\Visit\ValidateVisitService;
use App\Services\Entities\VisitService;
use App\Services\TelegramBot\Messages\VisitCreatedMessage;
use App\Services\TelegramBot\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Telegram\Bot\Objects\Update;

class CreateVisitHandler extends AbstractHandler
{
    public function handle(Update $update): void
    {
        $appointment = $this->storage->get($update->getChat()->id);

        if (!$appointment ||
            $appointment->getVisitId()
        ) {
            parent::handle($update);
            return;
        }

        $visitStoreData = [
            'visit_date' => Carbon::parse($appointment->getVisitDate())->toDateString(),
            'visit_start_at' => $appointment->getStartTime(),
            'visit_end_at' => $appointment->getEndTime(),
            'employee_id' => $appointment->getEmployeeId(),
            'service_id' => $appointment->getServiceId(),
            'client_id' => $this->getOrCreateClient($appointment)->id,
            'price' => $appointment->getPrice(),
            'status' => VisitStatus::NEW,
        ];

        $visitValidator = ValidateVisitService::getInstance()->getValidator($visitStoreData);

        if ($visitValidator->fails()) {
            throw new ValidationException($visitValidator);
        }

        $visit = $this->createVisit($visitValidator->validated());

        $appointment->setVisitId($visit->id);
        $this->storage->save($update->getChat()->id, $appointment);

        $message = new VisitCreatedMessage();
        $this->telegram->sendMessage(array_merge([
                'chat_id' => $update->getChat()->id,
            ], $message($visit))
        );

        parent::handle($update);
    }

    private function createVisit(array $data) : Visit
    {
        $dto = new StoreVisitDto(
            $data['visit_date'],
            $data['visit_start_at'],
            $data['visit_end_at'],
            $data['employee_id'],
            $data['service_id'],
            $data['client_id'],
            $data['price'],
        );

        $dto->setStatus($data['status']);

        return VisitService::getInstance()->store($dto);
    }

    private function getOrCreateClient(Appointment $appointment) : Client
    {
        $clientService = ClientService::getInstance();
        $client = $clientService->getByEmail($appointment->getEmail());

        if (null === $client) {
            $dto = new StoreClientDto(
                'New Client from telegram bot',
                $appointment->getEmail(),
                $appointment->getPhone(),
            );

            $client = $clientService->store($dto);
        }

        return $client;
    }
}
