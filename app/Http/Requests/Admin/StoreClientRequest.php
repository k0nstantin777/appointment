<?php

namespace App\Http\Requests\Admin;

use App\DataTransferObjects\StoreClientDto;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class StoreClientRequest extends FormRequest
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
                Rule::unique('clients', 'email')
                    ->ignore($this->route('client')),
            ],
            'phone' => ['required', 'min:2', 'max:255']
        ];
    }

    public function getDto() : StoreClientDto
    {
        return new StoreClientDto(
            $this->get('name'),
            $this->get('email'),
            $this->get('phone'),
        );
    }
}
