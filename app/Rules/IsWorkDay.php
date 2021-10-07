<?php

namespace App\Rules;

use App\Services\Entities\Settings\WorkingDaysSettingsService;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\Validation\Rule;

class IsWorkDay implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return  false === WorkingDaysSettingsService::getInstance()->isTodayDayOff(Carbon::parse($value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'В выбранную дату - выходной';
    }
}
