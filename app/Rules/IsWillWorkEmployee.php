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
    public function __construct(private ?string $date = null)
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
        if ($this->date === null) {
            return true;
        }

        $workingDay = WorkingDay::where('employee_id', $value)
            ->where('calendar_date', $this->date)
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
        return 'В выбранную дату данный сотрудник не работает';
    }
}
