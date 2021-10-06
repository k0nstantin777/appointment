<?php

namespace App\Http\Requests\Admin;

use App\DataTransferObjects\StoreServiceDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServiceRequest extends FormRequest
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
                Rule::unique('services', 'name')->ignore( $this->route('service')),
            ],
            'duration' => ['required', 'date_format:H:i'],
            'price' => ['required', 'numeric'],
            'description' => ['nullable', 'min:2', 'max:1000'],
            'category_ids' => ['array'],
            'category_ids.*' => ['required', 'exists:categories,id'],
        ];
    }

    public function getDto() : StoreServiceDto
    {
        $dto = new StoreServiceDto(
            $this->get('name'),
            $this->get('duration'),
            $this->get('price'),
            $this->get('description') ?? '',
        );

        if ($this->get('category_ids')) {
            $dto->setCategoryIds($this->get('category_ids'));
        }

        return $dto;
    }
}
