<?php

namespace App\Services\Entities\Employee;

use App\Models\WorkingDay;
use App\Services\BaseService;
use App\Services\Entities\EmployeeService;
use App\Services\Entities\VisitService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class EmployeeFreeTimeService extends BaseService
{
    private const TODAY_OFFSET_START_TIME_IN_MINUTES = 30;
    private const MINUTES_CEIL = 10;

    public function __construct(
        private EmployeeService $employeeService,
        private VisitService $visitService,
    )
    {
    }

    public function getByDateAndDuration(int $employeeId, string $visitDate, string $durationInMinutes) : Collection
    {
        $freeTimes = collect();
        $employee = $this->employeeService->getById($employeeId);
        $visitDateObj = Carbon::parse($visitDate);

        $workingDay = $employee->getWorkingDayByDate($visitDateObj);

        if (null === $workingDay) {
            return $freeTimes;
        }

        $startTime = $this->getStartTime($workingDay, $visitDateObj);

        $endTime = $startTime->copy()->addMinutes($durationInMinutes);
        $endWorkingDayTime = $workingDay->end_at;

        while($startTime->lessThan($endWorkingDayTime) && $endTime->lessThan($endWorkingDayTime)) {
            $visits = $this->visitService->getByEmployeeIdDateAndTimeDiapason(
                $employeeId,
                $visitDate,
                $startTime->format('H:i'),
                $endTime->format('H:i'),
            );

            if ($this->isFreeTime($visits, $startTime, $endTime)) {
                $freeTimes->push([$startTime->copy(), $endTime->copy()]);
                $startTime->addMinutes($durationInMinutes);
                $endTime = $startTime->copy()->addMinutes($durationInMinutes);
                continue;
            }

            $visitEndTime = $visits->first()->end_at;
            $visitEndTime->ceilUnit('minute', self::MINUTES_CEIL);
            if ($visitEndTime->greaterThan($endWorkingDayTime)) {
                $visitEndTime = $endWorkingDayTime->copy();
            }

            $startTime->setTime($visitEndTime->hour, $visitEndTime->minute);
            $endTime = $startTime->copy()->addMinutes($durationInMinutes);
        }

        return $freeTimes;
    }

    private function isFreeTime(Collection $visits, Carbon $startTime, Carbon $endTime) : bool
    {
        if ($visits->isEmpty()) {
            return true;
        }

        if ($visits->count() > 1) {
            return false;
        }

        return $visits->first()->start_at->equalTo($endTime) || $visits->first()->end_at->equalTo($startTime);
    }

    private function getStartTime(WorkingDay $workingDay, Carbon $visitDate) : Carbon
    {
        if ($visitDate->toDateString() === now()->toDateString()) {
            return now()->addMinutes(self::TODAY_OFFSET_START_TIME_IN_MINUTES);
        }

        return $workingDay->start_at;
    }
}
