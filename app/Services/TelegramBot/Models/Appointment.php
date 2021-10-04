<?php

namespace App\Services\TelegramBot\Models;

class Appointment
{
    private ?int $sectionId = null;
    private ?int $categoryId = null;
    private ?int $serviceId = null;
    private ?int $employeeId = null;
    private ?string $visitDate = null;
    private ?string $startTime = null;
    private ?string $endTime = null;
    private ?string $price = null;
    private ?string $email = null;
    private ?string $phone = null;
    private ?int $visitId = null;
    private array $touched = [];

    public function getSectionId(): ?int
    {
        return $this->sectionId;
    }

    public function setSectionId(int $sectionId): void
    {
        $this->sectionId = $sectionId;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function setCategoryId(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function getServiceId():  ?int
    {
        return $this->serviceId;
    }

    public function setServiceId(int $serviceId): void
    {
        $this->serviceId = $serviceId;
    }

    public function getEmployeeId():  ?int
    {
        return $this->employeeId;
    }

    public function setEmployeeId(int $employeeId): void
    {
        $this->employeeId = $employeeId;
    }

    public function getStartTime(): ?string
    {
        return $this->startTime;
    }

    public function setStartTime(string $startTime): void
    {
        $this->startTime = $startTime;
    }

    public function getEndTime(): ?string
    {
        return $this->endTime;
    }

    public function setEndTime(string $endTime): void
    {
        $this->endTime = $endTime;
    }

    /**
     * @return string|null
     */
    public function getVisitDate(): ?string
    {
        return $this->visitDate;
    }

    /**
     * @param string|null $visitDate
     */
    public function setVisitDate(?string $visitDate): void
    {
        $this->visitDate = $visitDate;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string|null
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * @param string|null $price
     */
    public function setPrice(?string $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int|null
     */
    public function getVisitId(): ?int
    {
        return $this->visitId;
    }

    /**
     * @param int|null $visitId
     */
    public function setVisitId(?int $visitId): void
    {
        $this->visitId = $visitId;
    }

    /**
     * @return array
     */
    public function getTouched(): array
    {
        return $this->touched;
    }

    /**
     * @param array $touched
     */
    public function setTouched(array $touched): void
    {
        $this->touched = $touched;
    }

    public function touchProperty(string $property): void
    {
        if ($this->isTouched($property)) {
            return;
        }

        $this->touched[] = $property;
    }

    public function isTouched(string $property) : bool
    {
        return in_array($property, $this->touched, true);
    }
}
