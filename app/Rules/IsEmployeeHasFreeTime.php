<?php

namespace App\Rules;

use App\Models\Visit;
use Illuminate\Contracts\Validation\Rule;

class IsEmployeeHasFreeTime implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        private ?string $startTime = null,
        private ?string $endTime = null,
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
        if (null === $this->visitDate || null === $this->startTime || null === $this->endTime) {
            return true;
        }

        $visit = Visit::whereDate('visit_date', $this->visitDate)
            ->where(function($query){
                $query->where(function ($query) {
                    $query->whereTime('start_at', '<=', $this->startTime)
                        ->whereTime('end_at', '>=', $this->endTime);
                })->orWhere(function($query){
                    $query->whereTime('start_at', '>=', $this->startTime)
                        ->whereTime('end_at', '<=', $this->endTime);
                })->orWhere(function($query){
                    $query->whereTime('start_at', '>=', $this->startTime)
                        ->whereTime('start_at', '<=', $this->endTime);
                })->orWhere(function($query){
                    $query->whereTime('end_at', '>=', $this->startTime)
                        ->whereTime('end_at', '<=', $this->endTime);
                });
            })
            ->where('employee_id', $value)
            ->first();

        return $visit === null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'У данного сотрудника выбранное время занято.';
    }
}
