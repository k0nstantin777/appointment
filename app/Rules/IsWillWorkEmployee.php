<?php

namespace App\Rules;

use App\Models\WorkingDay;
use Illuminate\Contracts\Validation\Rule;

class IsWillWorkEmployee implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        private ?string $visitDate = null,
        private ?string $startTime = null,
        private ?string $endTime = null
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
        if (null === $this->visitDate || null === $this->startTime || null === $this->endTime) {
            return true;
        }

        $workingDay = WorkingDay::where('employee_id', $value)
            ->whereDate('calendar_date', $this->visitDate)
            ->whereTime('start_at', '<=' ,$this->startTime)
            ->whereTime('end_at', '>=' ,$this->endTime)
            ->first();

        return $workingDay !== null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'В выбранную дату и время данный сотрудник не работает';
    }
}
