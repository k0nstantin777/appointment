<?php

namespace App\DataTransferObjects;

class StoreEmployeeDto
{
    private array $serviceIds = [];

    public function __construct(
        private string $name,
        private string $email,
        private int $positionId,
    )
    {
    }

    /**
     * @return array
     */
    public function getServiceIds(): array
    {
        return $this->serviceIds;
    }

    /**
     * @param array $serviceIds
     */
    public function setServiceIds(array $serviceIds): void
    {
        $this->serviceIds = $serviceIds;
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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getPositionId(): int
    {
        return $this->positionId;
    }


}
