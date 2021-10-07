<?php

namespace App\Services\Entities\Settings;

use App\DataTransferObjects\StoreWorkingDaysSettingsDto;
use App\Services\BaseService;
use App\Services\Settings\WorkingDaysSettings;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;

class WorkingDaysSettingsService extends BaseService
{
    public function __construct(private WorkingDaysSettings $settings)
    {
    }

    public function update(StoreWorkingDaysSettingsDto $dto): void
    {
        $this->settings->monday = $dto->getMonday();
        $this->settings->tuesday = $dto->getTuesday();
        $this->settings->wednesday = $dto->getWednesday();
        $this->settings->thursday = $dto->getThursday();
        $this->settings->friday = $dto->getFriday();
        $this->settings->saturday = $dto->getSaturday();
        $this->settings->sunday = $dto->getSunday();

        $this->settings->save();
    }


    #[ArrayShape(['start_time' => Carbon::class, 'end_time' => Carbon::class])]
    public function getTodayWorkingTimes(Carbon $today = null) : array
    {
        if (null === $today) {
            $today = now();
        }

        [$startTime, $endTime] = $this->settings->{strtolower($today->englishDayOfWeek)};

        return [
            'start_time' => Carbon::parse($startTime),
            'end_time' => Carbon::parse($endTime),
        ];
    }

    public function isTodayDayOff(Carbon $today = null) : bool
    {
        $todayWorkingTimes = $this->getTodayWorkingTimes($today);

        $startTimeObj = $todayWorkingTimes['start_time'];
        $endTimeObj = $todayWorkingTimes['end_time'];

        return $startTimeObj->format('H:i') ===  $endTimeObj->format('H:i');
    }
}
