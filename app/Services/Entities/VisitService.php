<?php

namespace App\Services\Entities;

use App\DataTransferObjects\StoreVisitDto;
use App\Enums\VisitStatus;
use App\Models\Visit;
use App\Services\BaseService;
use App\Services\Entities\Settings\WorkingDaysSettingsService;

class VisitService extends BaseService
{
    public function __construct(private WorkingDaysSettingsService $workingDaysSettingsService)
    {
    }

    public function getById(int $id) : Visit
    {
        return Visit::findOrFail($id);
    }

    public function store(StoreVisitDto $dto) : Visit
    {
        return Visit::create($this->fillData($dto));
    }

    public function update(int $id, StoreVisitDto $dto) : Visit
    {
        return tap($this->getById($id))->update($this->fillData($dto));
    }

    public function delete(int $id) : bool
    {
        return $this->getById($id)->delete();
    }

    public function makeDefault() : Visit
    {
        $workingDaySettings = $this->workingDaysSettingsService->getTodayWorkingTimes();
        $startTime = $workingDaySettings['start_time'];

        return Visit::make([
            'visit_date' => now(),
            'start_at' => $startTime->format('H:i'),
            'end_at' => $startTime->copy()->addMinutes(90)->format('H:i'),
            'employee_id' => '',
            'client_id' => '',
            'service_id' => '',
            'price' => 0,
            'status' => VisitStatus::NEW,
        ]);
    }

    private function fillData(StoreVisitDto $dto) : array
    {
        return [
            'visit_date' => $dto->getVisitDate(),
            'start_at' => $dto->getStartAt(),
            'end_at' => $dto->getEndAt(),
            'employee_id' => $dto->getEmployeeId(),
            'client_id' => $dto->getClientId(),
            'service_id' => $dto->getServiceId(),
            'price' => $dto->getPrice(),
        ];
    }
}
