<?php

namespace App\DataTransferObjects;

class StoreWorkingDaysSettingsDto
{
    public function __construct(
        private array $monday,
        private array $tuesday,
        private array $wednesday,
        private array $thursday,
        private array $friday,
        private array $saturday,
        private array $sunday,
    )
    {
    }

    /**
     * @return array
     */
    public function getMonday(): array
    {
        return $this->monday;
    }

    /**
     * @param array $monday
     */
    public function setMonday(array $monday): void
    {
        $this->monday = $monday;
    }

    /**
     * @return array
     */
    public function getTuesday(): array
    {
        return $this->tuesday;
    }

    /**
     * @param array $tuesday
     */
    public function setTuesday(array $tuesday): void
    {
        $this->tuesday = $tuesday;
    }

    /**
     * @return array
     */
    public function getWednesday(): array
    {
        return $this->wednesday;
    }

    /**
     * @param array $wednesday
     */
    public function setWednesday(array $wednesday): void
    {
        $this->wednesday = $wednesday;
    }

    /**
     * @return array
     */
    public function getThursday(): array
    {
        return $this->thursday;
    }

    /**
     * @param array $thursday
     */
    public function setThursday(array $thursday): void
    {
        $this->thursday = $thursday;
    }

    /**
     * @return array
     */
    public function getFriday(): array
    {
        return $this->friday;
    }

    /**
     * @param array $friday
     */
    public function setFriday(array $friday): void
    {
        $this->friday = $friday;
    }

    /**
     * @return array
     */
    public function getSaturday(): array
    {
        return $this->saturday;
    }

    /**
     * @param array $saturday
     */
    public function setSaturday(array $saturday): void
    {
        $this->saturday = $saturday;
    }

    /**
     * @return array
     */
    public function getSunday(): array
    {
        return $this->sunday;
    }

    /**
     * @param array $sunday
     */
    public function setSunday(array $sunday): void
    {
        $this->sunday = $sunday;
    }

}
