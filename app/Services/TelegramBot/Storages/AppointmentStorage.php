<?php

namespace App\Services\TelegramBot\Storages;

use App\Services\TelegramBot\Models\Appointment;

interface AppointmentStorage
{
    public function get(string $key) : ?Appointment;

    public function save(string $key, Appointment $visit): void;

    public function remove(string $key) : void;
}
