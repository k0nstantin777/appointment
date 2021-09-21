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
            'date' => ['required', 'date'],
            'employee_id' => ['required', 'exists:employees,id'],
            'service_id' => ['required', 'exists:services,id'],
            'client_id' => ['required', 'exists:clients,id'],
            'price' => ['required', 'numeric'],
        ];
    }

    public function getDto() : StoreVisitDto
    {
        return new StoreVisitDto(
            $this->get('date'),
            $this->get('employee_id'),
            $this->get('service_id'),
            $this->get('client_id'),
            $this->get('price'),
        );
    }
}
