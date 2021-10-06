<?php

namespace App\Rules;

use App\Services\Entities\VisitService;
use Carbon\Carbon;
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

        $visits = VisitService::getInstance()->getByEmployeeIdDateAndTimeDiapason(
            $value,
            $this->visitDate,
            $this->startTime,
            $this->endTime
        );

        return $visits->isEmpty() ||
            ($visits->count() === 1 && $visits->first()->id === $this->id) ||
            (
                $visits->first()->start_at->equalTo(Carbon::parse($this->endTime)) &&
                $visits->last()->end_at->equalTo(Carbon::parse($this->startTime))
            )
        ;
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
