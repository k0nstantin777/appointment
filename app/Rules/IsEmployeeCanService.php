<?php

namespace App\Rules;

use App\Models\Employee;
use App\Services\Entities\ServiceService;
use Illuminate\Contracts\Validation\Rule;

class IsEmployeeCanService implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        private ?string $serviceId = null,

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
        if (null === $this->serviceId) {
            return true;
        }

        $service = ServiceService::getInstance()->getById($this->serviceId);

        return (bool) $service->employees->first(fn(Employee $employee) => $employee->id === (int) $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Данный сотрудник не оказывает выбранную услугу.';
    }
}
