<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.company_name', env('APP_NAME'));
        $this->migrator->add('general.timezone', 'Europe/Moscow');
    }
}
