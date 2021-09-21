<?php

namespace App\Services\Entities;

use App\DataTransferObjects\StoreEmployeeDto;
use App\Models\Employee;;
use App\Services\BaseService;

class EmployeeService extends BaseService
{
    public function getById(int $id) : Employee
    {
        return Employee::findOrFail($id);
    }

    public function store(StoreEmployeeDto $dto) : Employee
    {
        $employee = Employee::create([
            'name' => $dto->getName(),
            'email' => $dto->getEmail(),
            'position_id' => $dto->getPositionId(),
        ]);

        if (!empty($dto->getServiceIds())){
            $employee->services()->sync($dto->getServiceIds());
        }
    }

    public function update(int $id, StoreEmployeeDto $dto) : Employee
    {
        $employee = tap($this->getById($id))->update([
            'name' => $dto->getName(),
            'email' => $dto->getEmail(),
            'position_id' => $dto->getPositionId(),
        ]);

        if (!empty($dto->getServiceIds())){
            $employee->services()->sync($dto->getServiceIds());
        }

        return $employee;
    }

    public function delete(int $id) : bool
    {
        return $this->getById($id)->delete();
    }
}
