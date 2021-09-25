<?php

namespace App\Services\Entities\Settings;

use App\DataTransferObjects\StoreGeneralSettingsDto;
use App\Services\BaseService;
use App\Services\Settings\GeneralSettings;

class GeneralSettingsService extends BaseService
{
    public function __construct(private GeneralSettings $settings)
    {
    }

    public function update(StoreGeneralSettingsDto $dto): void
    {
        $this->settings->company_name = $dto->getCompanyName();
        $this->settings->timezone = $dto->getTimezone();

        $this->settings->save();
    }
}
