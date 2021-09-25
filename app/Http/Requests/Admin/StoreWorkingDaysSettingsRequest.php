<?php

namespace App\Http\Requests\Admin;

use App\DataTransferObjects\StoreGeneralSettingsDto;
use App\DataTransferObjects\StoreWorkingDaysSettingsDto;
use Illuminate\Foundation\Http\FormRequest;

class StoreWorkingDaysSettingsRequest extends FormRequest
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
            'monday' => ['required', 'array'],
            'monday.*' => ['nullable', 'date_format:H:i'],
            'tuesday' => ['required', 'array'],
            'tuesday.*' => ['nullable', 'date_format:H:i'],
            'wednesday' => ['required', 'array'],
            'wednesday.*' => ['nullable', 'date_format:H:i'],
            'thursday' => ['required', 'array'],
            'thursday.*' => ['nullable', 'date_format:H:i'],
            'friday' => ['required', 'array'],
            'friday.*' => ['nullable', 'date_format:H:i'],
            'saturday' => ['required', 'array'],
            'saturday.*' => ['nullable', 'date_format:H:i'],
            'sunday' => ['required', 'array'],
            'sunday.*' => ['nullable', 'date_format:H:i'],
        ];
    }

    public function getDto() : StoreWorkingDaysSettingsDto
    {
        return new StoreWorkingDaysSettingsDto(
            $this->get('monday'),
            $this->get('tuesday'),
            $this->get('wednesday'),
            $this->get('thursday'),
            $this->get('friday'),
            $this->get('saturday'),
            $this->get('sunday'),
        );
    }
}
