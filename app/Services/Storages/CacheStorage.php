<?php

namespace App\Services\Storages;

use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Cache;

class CacheStorage
{
    protected string $prefix = 'cache_storage';
    protected int $ttl = 24*60*60; // 1 day;

    public function get(string $key)
    {
        return $this->getStorage()->get($this->getKey($key));
    }

    public function save(string $key, $data): void
    {
        $this->getStorage()->put(
            $this->getKey($key),
            $data,
            $this->ttl,
        );
    }

    public function forget(string $key): void
    {
        $this->getStorage()->forget($this->getKey($key));
    }

    public function setPrefix(string $value): static
    {
        $this->prefix = $value;

        return $this;
    }

    public function setTtl(string $value): static
    {
        $this->ttl = $value;

        return $this;
    }

    protected function getStorage(): Store
    {
        return Cache::getStore();
    }

    protected function getKey(string $key): string
    {
        return $this->prefix . $key;
    }
}
