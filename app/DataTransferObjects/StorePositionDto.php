<?php

namespace App\DataTransferObjects;

class StorePositionDto
{
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

}
