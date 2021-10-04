<?php

namespace App\Services\Entities;

use App\DataTransferObjects\StoreCategoryDto;
use App\Models\Category;
use App\Services\BaseService;
use Illuminate\Support\Collection;

class CategoryService extends BaseService
{
    public function getById(int $id) : Category
    {
        return Category::findOrFail($id);
    }

    public function all() : Collection
    {
        return Category::all()->toBase();
    }

    public function getCollectionBySectionId(int $sectionId) : Collection
    {
        return Category::whereHas('sections', function ($query) use ($sectionId){
            $query->where('sections.id', $sectionId);
        })->get();
    }

    public function store(StoreCategoryDto $dto) : Category
    {
        $category = Category::create([
            'name' => $dto->getName(),
            'description' => $dto->getDescription(),
            'parent_id' => $dto->getParentId(),
        ]);

        if (!empty($dto->getSectionIds())){
            $category->sections()->sync($dto->getSectionIds());
        }
    }

    public function update(int $id, StoreCategoryDto $dto) : Category
    {
        $category = tap($this->getById($id))->update([
            'name' => $dto->getName(),
            'description' => $dto->getDescription(),
            'parent_id' => $dto->getParentId(),
        ]);

        if (!empty($dto->getSectionIds())){
            $category->sections()->sync($dto->getSectionIds());
        }

        return $category;
    }

    public function delete(int $id) : bool
    {
        return $this->getById($id)->delete();
    }
}
