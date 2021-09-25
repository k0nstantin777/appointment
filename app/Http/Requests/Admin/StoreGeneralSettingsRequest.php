<?php

namespace App\Http\Requests\Admin;

use App\DataTransferObjects\StoreGeneralSettingsDto;
use Illuminate\Foundation\Http\FormRequest;

class StoreGeneralSettingsRequest extends FormRequest
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
            'company_name' => ['required', 'string', 'min:2', 'max:50'],
            'timezone' => ['required', 'timezone'],
        ];
    }

    public function getDto() : StoreGeneralSettingsDto
    {
        return new StoreGeneralSettingsDto(
            $this->get('company_name'),
            $this->get('timezone'),
        );
    }
}
