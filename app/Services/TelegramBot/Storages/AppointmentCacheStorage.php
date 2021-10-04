<?php

namespace App\Services\TelegramBot\Storages;

use App\Services\Storages\CacheStorage;
use App\Services\TelegramBot\Models\Appointment;

class AppointmentCacheStorage implements AppointmentStorage
{
    public function __construct(protected CacheStorage $storage)
    {
        $this->storage->setPrefix('telegram_bot_appointments');
    }

    public function get(string $key) : ?Appointment
    {
        return $this->storage->get($key);
    }

    public function save(string $key, Appointment $visit): void
    {
        $this->storage->save($key, $visit);
    }

    public function remove(string $key): void
    {
        $this->storage->forget($key);
    }
}
