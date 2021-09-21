<?php

namespace App\Services\Entities;

use App\DataTransferObjects\StoreSectionDto;
use App\Models\Section;
use App\Services\BaseService;

class SectionService extends BaseService
{
    public function getById(int $id) : Section
    {
        return Section::findOrFail($id);
    }

    public function store(StoreSectionDto $dto) : Section
    {
        return Section::create([
            'name' => $dto->getName(),
            'description' => $dto->getDescription(),
        ]);
    }

    public function update(int $id, StoreSectionDto $dto) : Section
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
