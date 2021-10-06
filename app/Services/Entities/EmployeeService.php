<?php

namespace App\Services\Entities;

use App\DataTransferObjects\StoreEmployeeDto;
use App\DataTransferObjects\UpdateEmployeeWorkingDaysDto;
use App\Models\Employee;
use App\Services\BaseService;
use Illuminate\Support\Carbon;

class EmployeeService extends BaseService
{
    public function getById(int $id) : Employee
    {
        return Employee::findOrFail($id);
    }

    public function store(StoreEmployeeDto $dto) : Employee
    {
        $employee = Employee::create([
            'name' => $dto->getName(),
            'email' => $dto->getEmail(),
            'position_id' => $dto->getPositionId(),
        ]);

        if (!empty($dto->getServiceIds())){
            $employee->services()->sync($dto->getServiceIds());
        }

        return $employee;
    }

    public function update(int $id, StoreEmployeeDto $dto) : Employee
    {
        $employee = tap($this->getById($id))->update([
            'name' => $dto->getName(),
            'email' => $dto->getEmail(),
            'position_id' => $dto->getPositionId(),
        ]);

        if (!empty($dto->getServiceIds())){
            $employee->services()->sync($dto->getServiceIds());
        }

        return $employee;
    }

    public function delete(int $id) : bool
    {
        return $this->getById($id)->delete();
    }

    public function updateWorkingDays(int $id, UpdateEmployeeWorkingDaysDto $dto) : Employee
    {
        $employee = $this->getById($id);
        $startDays = $dto->getStartDays();
        $endDays = $dto->getEndDays();
        $dayOffs = $dto->getDayOffs();

        foreach ($startDays as $monthDay => $startTime) {
            $day = Carbon::create($dto->getYear(), $dto->getMonth(), $monthDay);
            $dayOff = $dayOffs[$monthDay] ?? '';

            if ($dayOff) {
                $employee->workingDays()
                    ->whereDate('calendar_date', $day->toDateString())
                    ->delete();
                continue;
            }

            $endTime = $endDays[$monthDay] ?? '';
            if (!$startTime || !$endTime) {
                continue;
            }

            $day = Carbon::create($dto->getYear(), $dto->getMonth(), $monthDay);
            $employee->workingDays()
                ->whereDate('calendar_date', $day->toDateString())
                ->updateOrCreate([
                    'calendar_date' => $day
                ], [
                    'start_at' => $startTime,
                    'end_at' => $endTime,
                ]);
        }

        return $employee->fresh();
    }
}
