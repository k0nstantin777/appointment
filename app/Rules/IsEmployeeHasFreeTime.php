<?php

namespace App\Rules;

use App\Services\Entities\VisitService;
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
        private ?int $id = null,
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

        $visit = VisitService::getInstance()->getByEmployeeIdDateAndTimeDiapason(
            $value,
            $this->visitDate,
            $this->startTime,
            $this->endTime
        )->first();

        return $visit === null || $visit->id === $this->id;
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
