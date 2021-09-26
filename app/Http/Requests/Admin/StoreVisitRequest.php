<?php

namespace App\Http\Requests\Admin;

use App\DataTransferObjects\StoreVisitDto;
use Illuminate\Foundation\Http\FormRequest;

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
            'visit_date' => ['required', 'date'],
            'visit_start_at' => ['required', 'date_format:H:i'],
            'visit_end_at' => ['required', 'date_format:H:i'],
            'employee_id' => ['required', 'exists:employees,id'],
            'service_id' => ['required', 'exists:services,id'],
            'client_id' => ['required', 'exists:clients,id'],
            'price' => ['required', 'numeric'],
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
