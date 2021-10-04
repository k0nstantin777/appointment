<?php

namespace App\Services\Entities;

use App\DataTransferObjects\StoreServiceDto;
use App\Models\Service;
use App\Services\BaseService;
use Illuminate\Support\Collection;

class ServiceService extends BaseService
{
    public function getById(int $id) : Service
    {
        return Service::findOrFail($id);
    }

    public function all() : Collection
    {
        return Service::all()->toBase();
    }

    public function getCollectionByCategoryId(int $categoryId) : Collection
    {
        return Service::whereHas('categories', function ($query) use ($categoryId){
            $query->where('categories.id', $categoryId);
        })->get();
    }

    public function store(StoreServiceDto $dto) : Service
    {
        $service = Service::create([
            'name' => $dto->getName(),
            'description' => $dto->getDescription(),
            'duration' => $dto->getDuration(),
            'price' => $dto->getPrice(),
        ]);

        if (!empty($dto->getCategoryIds())){
            $service->categories()->sync($dto->getCategoryIds());
        }
    }

    public function update(int $id, StoreServiceDto $dto) : Service
    {
        $service = tap($this->getById($id))->update([
            'name' => $dto->getName(),
            'description' => $dto->getDescription(),
            'duration' => $dto->getDuration(),
            'price' => $dto->getPrice(),
        ]);

        if (!empty($dto->getCategoryIds())){
            $service->categories()->sync($dto->getCategoryIds());
        }

        return $service;
    }

    public function delete(int $id) : bool
    {
        return $this->getById($id)->delete();
    }
}
