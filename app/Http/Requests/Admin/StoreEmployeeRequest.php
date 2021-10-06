<?php

namespace App\Http\Requests\Admin;

use App\DataTransferObjects\StoreEmployeeDto;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class StoreEmployeeRequest extends FormRequest
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
            'name' => ['required', 'min:2', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('employees', 'email')
                    ->ignore($this->route('employee')),
            ],
            'position_id' => ['required', 'exists:positions,id'],
            'service_ids' => ['nullable', 'array'],
            'service_ids.*' => ['required', 'exists:services,id'],
        ];
    }

    public function getDto() : StoreEmployeeDto
    {
        $dto = new StoreEmployeeDto(
            $this->get('name'),
            $this->get('email'),
            $this->get('position_id'),
        );

        $dto->setServiceIds($this->get('service_ids'));

        return $dto;
    }
}
