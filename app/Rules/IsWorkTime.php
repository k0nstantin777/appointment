<?php

namespace App\Rules;

use App\Services\Entities\Settings\WorkingDaysSettingsService;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class IsWorkTime implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        private ?string $visitDate = null,
    )
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (null === $this->visitDate) {
            return true;
        }

        $workingDaysSettingsService = WorkingDaysSettingsService::getInstance();
        $today = Carbon::parse($this->visitDate);

        if ($workingDaysSettingsService->isTodayDayOff($today)) {
            return false;
        }

        $workingTimes = $workingDaysSettingsService->getTodayWorkingTimes($today);

        $time = Carbon::parse($value);

        return $time->greaterThanOrEqualTo($workingTimes['start_time']) &&
            $time->lessThanOrEqualTo($workingTimes['end_time']);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'В данное время компания не работает';
    }
}
