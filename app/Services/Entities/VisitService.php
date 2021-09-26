<?php

namespace App\Services\Entities;

use App\DataTransferObjects\StoreVisitDto;
use App\Models\Visit;
use App\Services\BaseService;

class VisitService extends BaseService
{
    public function getById(int $id) : Visit
    {
        return Visit::findOrFail($id);
    }

    public function store(StoreVisitDto $dto) : Visit
    {
        return Visit::create($this->fillData($dto));
    }

    public function update(int $id, StoreVisitDto $dto) : Visit
    {
        return tap($this->getById($id))->update($this->fillData($dto));
    }

    public function delete(int $id) : bool
    {
        return $this->getById($id)->delete();
    }

    private function fillData(StoreVisitDto $dto) : array
    {
        return [
            'visit_date' => $dto->getVisitDate(),
            'start_at' => $dto->getStartAt(),
            'end_at' => $dto->getEndAt(),
            'employee_id' => $dto->getEmployeeId(),
            'client_id' => $dto->getClientId(),
            'service_id' => $dto->getServiceId(),
            'price' => $dto->getPrice(),
        ];
    }
}
