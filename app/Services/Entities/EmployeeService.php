<?php

namespace App\Services\Entities;

use App\DataTransferObjects\StoreEmployeeDto;
use App\DataTransferObjects\UpdateEmployeeWorkingDaysDto;
use App\Models\Employee;
use App\Services\BaseService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class EmployeeService extends BaseService
{
    public function __construct(private VisitService $visitService)
    {
    }

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

    public function getFreeTimesByIdDateAndDuration(int $id, string $visitDate, string $durationInMinutes) : Collection
    {
        $freeTimes = collect();
        $employee = $this->getById($id);

        $workingDay = $employee->getWorkingDayByDate(Carbon::parse($visitDate));

        if (null === $workingDay) {
            return $freeTimes;
        }

        $startTime = $workingDay->start_at;
        $endTime = $startTime->copy()->addMinutes($durationInMinutes);
        $endWorkingDayTime = $workingDay->end_at;

        while($startTime->lessThan($endWorkingDayTime) && $endTime->lessThan($endWorkingDayTime)) {
            $visits = $this->visitService->getByEmployeeIdDateAndTimeDiapason(
                $id,
                $visitDate,
                $startTime->format('H:i'),
                $endTime->format('H:i'),
            );

            if ($visits->isEmpty() || $visits->first()->start_at->equalTo($endTime)) {
                $freeTimes->push([$startTime->copy(), $endTime->copy()]);
                $startTime->addMinutes($durationInMinutes);
                $endTime = $startTime->copy()->addMinutes($durationInMinutes);
                continue;
            }

            $visitEndTime = $visits->first()->end_at;
            $visitEndTime->ceilUnit('minute', 10);
            if ($visitEndTime->greaterThan($endWorkingDayTime)) {
                $visitEndTime = $endWorkingDayTime->copy();
            }

            $startTime->setTime($visitEndTime->hour, $visitEndTime->minute);
            $endTime = $startTime->copy()->addMinutes($durationInMinutes);
        }

        return $freeTimes;
    }
}
