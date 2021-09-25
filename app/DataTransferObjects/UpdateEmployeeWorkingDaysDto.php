<?php

namespace App\DataTransferObjects;

class UpdateEmployeeWorkingDaysDto
{
    public function __construct(
        private string $month,
        private string $year,
        private array $startDays,
        private array $endDays,
    )
    {
    }

    /**
     * @return string
     */
    public function getMonth(): string
    {
        return $this->month;
    }

    /**
     * @return string
     */
    public function getYear(): string
    {
        return $this->year;
    }

    /**
     * @return array
     */
    public function getStartDays(): array
    {
        return $this->startDays;
    }

    /**
     * @return array
     */
    public function getEndDays(): array
    {
        return $this->endDays;
    }

}
