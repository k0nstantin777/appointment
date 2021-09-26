<?php

namespace App\DataTransferObjects;

class StoreVisitDto
{
    public function __construct(
        private string $visitDate,
        private string $startAt,
        private string $endAt,
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
    public function getVisitDate(): string
    {
        return $this->visitDate;
    }

    /**
     * @return string
     */
    public function getStartAt(): string
    {
        return $this->startAt;
    }

    /**
     * @return string
     */
    public function getEndAt(): string
    {
        return $this->endAt;
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
