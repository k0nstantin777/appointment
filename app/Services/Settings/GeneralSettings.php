<?php

namespace App\Services\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $company_name;
    public string $timezone;

    public static function group(): string
    {
        return 'general';
    }
}
