<?php

namespace App\Http\Requests\Admin;

use App\DataTransferObjects\StoreVisitDto;
use App\Enums\VisitStatus;
use App\Rules\IsEmployeeHasFreeTime;
use App\Rules\IsWillWorkEmployee;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVisitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'visit_date' => ['required', 'date', 'after_or_equal:' . now()->toDateString()],
            'visit_start_at' => ['required', 'date_format:H:i'],
            'visit_end_at' => ['required', 'date_format:H:i', 'after:visit_start_at'],
            'employee_id' => [
                'bail',
                'required',
                'exists:employees,id',
                new IsWillWorkEmployee($this->get('visit_date')),
                new IsEmployeeHasFreeTime(
                    $this->get('visit_start_at'),
                    $this->get('visit_end_at'),
                    $this->get('visit_date'),
                )
            ],
            'service_id' => ['required', 'exists:services,id'],
            'client_id' => ['required', 'exists:clients,id'],
            'price' => ['required', 'numeric'],
            'status' => ['required', Rule::in(VisitStatus::getValues())],
        ];
    }

    public function getDto() : StoreVisitDto
    {
        return new StoreVisitDto(
            $this->get('visit_date'),
            $this->get('visit_start_at'),
            $this->get('visit_end_at'),
            $this->get('employee_id'),
            $this->get('service_id'),
            $this->get('client_id'),
            $this->get('price'),
        );
    }
}
