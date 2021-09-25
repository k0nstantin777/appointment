<?php

namespace App\DataTransferObjects;

class StoreGeneralSettingsDto
{
    public function __construct(
        private string $companyName,
        private string $timezone,
    )
    {
    }

    /**
     * @return string
     */
    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    /**
     * @return string
     */
    public function getTimezone(): string
    {
        return $this->timezone;
    }


}
