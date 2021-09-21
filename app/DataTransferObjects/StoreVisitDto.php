<?php

namespace App\DataTransferObjects;

class StoreVisitDto
{
    public function __construct(
        private string $date,
        private int $employeeId,
        private int $serviceId,
        private int $clientId,
        private float $price,
    )
    {
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getEmployeeId(): int
    {
        return $this->employeeId;
    }

    /**
     * @return int
     */
    public function getServiceId(): int
    {
        return $this->serviceId;
    }

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return $this->clientId;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

}
