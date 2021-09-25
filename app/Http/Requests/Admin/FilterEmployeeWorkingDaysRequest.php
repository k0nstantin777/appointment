<?php

namespace App\Http\Requests\Admin;

use App\DataTransferObjects\StoreClientDto;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class FilterEmployeeWorkingDaysRequest extends FormRequest
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
            'filter-year' => ['nullable', 'numeric', 'min:' . now()->year, 'max:' . now()->year + 1],
            'filter-month' => ['nullable', 'numeric', 'min:1', 'max:12'],
        ];
    }
}
