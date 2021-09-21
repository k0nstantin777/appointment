<?php

namespace App\DataTransferObjects;

class StoreCategoryDto
{
    private ?int $parentId = null;
    private array $sectionIds = [];

    public function __construct(
        private string $name,
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
     * @return int|null
     */
    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    /**
     * @param int $parentId
     */
    public function setParentId(int $parentId): void
    {
        $this->parentId = $parentId;
    }

    /**
     * @return array
     */
    public function getSectionIds(): array
    {
        return $this->sectionIds;
    }

    /**
     * @param array $sectionIds
     */
    public function setSectionIds(array $sectionIds): void
    {
        $this->sectionIds = $sectionIds;
    }

}
