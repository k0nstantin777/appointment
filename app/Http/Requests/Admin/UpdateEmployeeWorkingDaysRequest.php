<?php

namespace App\Http\Requests\Admin;

use App\DataTransferObjects\UpdateEmployeeWorkingDaysDto;
use Illuminate\Foundation\Http\FormRequest;


class UpdateEmployeeWorkingDaysRequest extends FormRequest
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
            'year' => ['required', 'numeric', 'min:' . now()->year, 'max:' . now()->year + 1],
            'month' => ['required', 'numeric', 'min:1', 'max:12'],
            'start_days' => ['required', 'array'],
            'start_days.*' => ['nullable', 'date_format:H:i'],
            'end_days' => ['required', 'array'],
            'end_days.*' => ['nullable', 'date_format:H:i'],
            'day_offs' => ['required', 'array'],
            'day_offs.*' => ['nullable', 'numeric'],
        ];
    }

    public function getDto() : UpdateEmployeeWorkingDaysDto
    {
       return new UpdateEmployeeWorkingDaysDto(
            $this->get('month'),
            $this->get('year'),
            $this->get('start_days'),
            $this->get('end_days'),
            $this->get('day_offs'),
        );
    }
}
