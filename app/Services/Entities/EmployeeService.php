<?php

namespace App\Services\Entities;

use App\DataTransferObjects\StoreEmployeeDto;
use App\DataTransferObjects\UpdateEmployeeWorkingDaysDto;
use App\Models\Employee;;
use App\Services\BaseService;
use Carbon\Carbon;

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

        foreach ($startDays as $index => $startTime) {
            $endTime = $endDays[$index] ?? '';
            if (!$startTime || !$endTime) {
                continue;
            }
            $day = Carbon::create($dto->getYear(), $dto->getMonth(), $index + 1);
            $employee->workingDays()
                ->whereMonth('date', $day->month)
                ->whereYear('date', $day->year)
                ->whereDay('date', $day->day)
                ->updateOrCreate([
                    'date' => $day
                ], [
                    'start_at' => $startTime,
                    'end_at' => $endTime,
                ]);
        }

        return $employee->fresh();
    }
}
