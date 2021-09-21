<?php

namespace App\Services\Entities;

use App\DataTransferObjects\StorePositionDto;
use App\Models\Position;
use App\Services\BaseService;

class PositionService extends BaseService
{
    public function getById(int $id) : Position
    {
        return Position::findOrFail($id);
    }

    public function store(StorePositionDto $dto) : Position
    {
        return Position::create([
            'name' => $dto->getName(),
            'description' => $dto->getDescription(),
        ]);
    }

    public function update(int $id, StorePositionDto $dto) : Position
    {
        return tap($this->getById($id))->update([
            'name' => $dto->getName(),
            'description' => $dto->getDescription(),
        ]);

    }

    public function delete(int $id) : bool
    {
        return $this->getById($id)->delete();
    }
}
