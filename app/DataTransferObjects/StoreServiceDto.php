<?php

namespace App\DataTransferObjects;

class StoreServiceDto
{
    private array $categoryIds = [];

    public function __construct(
        private string $name,
        private string $duration,
        private float $price,
        private string $description,
    )
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getDuration(): string
    {
        return $this->duration;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return array
     */
    public function getCategoryIds(): array
    {
        return $this->categoryIds;
    }

    /**
     * @param array $categoryIds
     */
    public function setCategoryIds(array $categoryIds): void
    {
        $this->categoryIds = $categoryIds;
    }

}
