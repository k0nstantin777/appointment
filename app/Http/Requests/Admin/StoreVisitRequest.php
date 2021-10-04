<?php

namespace App\Http\Requests\Admin;

use App\DataTransferObjects\StoreVisitDto;
use App\Services\Entities\Visit\StoreRulesService;
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
        return StoreRulesService::getInstance()->get(
            array_merge($this->all(), [
                'id' => $this->route('visit'),
            ])
        );
    }

    public function getDto() : StoreVisitDto
    {
        $dto = new StoreVisitDto(
            $this->get('visit_date'),
            $this->get('visit_start_at'),
            $this->get('visit_end_at'),
            $this->get('employee_id'),
            $this->get('service_id'),
            $this->get('client_id'),
            $this->get('price'),
        );

        $dto->setStatus($this->get('status'));

        return $dto;
    }
}
