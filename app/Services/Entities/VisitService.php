<?php

namespace App\Services\Entities;

use App\DataTransferObjects\StoreVisitDto;
use App\Enums\VisitStatus;
use App\Events\Visit\Created;
use App\Models\Visit;
use App\Services\BaseService;
use App\Services\Entities\Settings\WorkingDaysSettingsService;
use Illuminate\Support\Collection;

class VisitService extends BaseService
{
    public function __construct(private WorkingDaysSettingsService $workingDaysSettingsService)
    {
    }

    public function getById(int $id) : Visit
    {
        return Visit::findOrFail($id);
    }

    public function getByEmployeeIdDateAndTimeDiapason(
        int $employeeId,
        string $visitDate,
        string $startTime,
        string $endTime
    ) : Collection {

        return Visit::whereDate('visit_date', $visitDate)
            ->where(function($query) use ($startTime, $endTime) {
                $query->where(function ($query) use ($startTime, $endTime) {
                    $query->whereTime('start_at', '<=', $startTime)
                        ->whereTime('end_at', '>=', $endTime);
                })->orWhere(function($query) use ($startTime, $endTime){
                    $query->whereTime('start_at', '>=', $startTime)
                        ->whereTime('end_at', '<=', $endTime);
                })->orWhere(function($query) use ($startTime, $endTime){
                    $query->whereTime('start_at', '>=', $startTime)
                        ->whereTime('start_at', '<=', $endTime);
                })->orWhere(function($query) use ($startTime, $endTime){
                    $query->whereTime('end_at', '>=', $startTime)
                        ->whereTime('end_at', '<=', $endTime);
                });
            })
            ->orderBy('end_at', 'desc')
            ->where('employee_id', $employeeId)
            ->get()->toBase();
    }

    public function store(StoreVisitDto $dto) : Visit
    {
        $visit = Visit::create($this->fillData($dto));

        event(new Created($visit));

        return $visit;
    }

    public function update(int $id, StoreVisitDto $dto) : Visit
    {
        return tap($this->getById($id))->update($this->fillData($dto));
    }

    public function delete(int $id) : bool
    {
        return $this->getById($id)->delete();
    }

    public function makeDefault(array $attributes = []) : Visit
    {
        $workingDaySettings = $this->workingDaysSettingsService->getTodayWorkingTimes();
        $startTime = $workingDaySettings['start_time'];

        return Visit::make(array_merge([
            'visit_date' => now(),
            'start_at' => $startTime->format('H:i'),
            'end_at' => $startTime->copy()->addMinutes(90)->format('H:i'),
            'employee_id' => '',
            'client_id' => '',
            'service_id' => '',
            'price' => 0,
            'status' => VisitStatus::NEW,
        ], $attributes));
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
            'status' => $dto->getStatus(),
        ];
    }
}
