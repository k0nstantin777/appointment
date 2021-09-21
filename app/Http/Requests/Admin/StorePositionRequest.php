<?php

namespace App\Http\Requests\Admin;

use App\DataTransferObjects\StorePositionDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePositionRequest extends FormRequest
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
            'name' => [
                'required',
                'min:2',
                'max:255',
                Rule::unique('positions', 'name')
                    ->ignore($this->route('position')),
            ],
            'description' => ['nullable', 'min:2', 'max:1000']
        ];
    }

    public function getDto() : StorePositionDto
    {
        return new StorePositionDto(
            $this->get('name'),
            $this->get('description'),
        );
    }
}
