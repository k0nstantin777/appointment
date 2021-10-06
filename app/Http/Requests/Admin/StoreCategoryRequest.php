<?php

namespace App\Http\Requests\Admin;

use App\DataTransferObjects\StoreCategoryDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
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
                Rule::unique('categories', 'name')
                    ->ignore($this->route('category')),
            ],
            'description' => ['nullable', 'min:2', 'max:1000'],
            'parent_category_id' => ['nullable', 'exists:categories,id'],
            'section_ids' => ['array'],
            'section_ids.*' => ['required', 'exists:sections,id'],
        ];
    }

    public function getDto() : StoreCategoryDto
    {
        $dto = new StoreCategoryDto(
            $this->get('name'),
            $this->get('description') ?? '',
        );

        if ($this->get('parent_category_id')) {
            $dto->setParentId($this->get('parent_category_id'));
        }

        $dto->setSectionIds($this->get('section_ids'));

        return $dto;
    }
}
