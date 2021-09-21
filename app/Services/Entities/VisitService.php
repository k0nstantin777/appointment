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
        return Visit::create([
            'date' => $dto->getDate(),
            'employee_id' => $dto->getEmployeeId(),
            'client_id' => $dto->getClientId(),
            'service_id' => $dto->getServiceId(),
            'price' => $dto->getPrice(),
        ]);
    }

    public function update(int $id, StoreVisitDto $dto) : Visit
    {
        return tap($this->getById($id))->update([
            'date' => $dto->getDate(),
            'employee_id' => $dto->getEmployeeId(),
            'client_id' => $dto->getClientId(),
            'service_id' => $dto->getServiceId(),
            'price' => $dto->getPrice(),
        ]);
    }

    public function delete(int $id) : bool
    {
        return $this->getById($id)->delete();
    }
}
