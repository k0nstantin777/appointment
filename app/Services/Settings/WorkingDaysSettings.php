<?php

namespace App\Services\Settings;

use Spatie\LaravelSettings\Settings;

class WorkingDaysSettings extends Settings
{
    public array $monday;
    public array $tuesday;
    public array $wednesday;
    public array $thursday;
    public array $friday;
    public array $saturday;
    public array $sunday;

    public static function group(): string
    {
        return 'working_days';
    }
}
