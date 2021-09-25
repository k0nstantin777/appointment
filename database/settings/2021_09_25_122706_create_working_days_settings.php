<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateWorkingDaysSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('working_days.monday', ['08:00', '18:00']);
        $this->migrator->add('working_days.tuesday', ['08:00', '18:00']);
        $this->migrator->add('working_days.wednesday', ['08:00', '18:00']);
        $this->migrator->add('working_days.thursday', ['08:00', '18:00']);
        $this->migrator->add('working_days.friday', ['08:00', '18:00']);
        $this->migrator->add('working_days.saturday', ['10:00', '16:00']);
        $this->migrator->add('working_days.sunday', ['10:00', '16:00']);
    }
}
