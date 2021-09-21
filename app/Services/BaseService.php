<?php


namespace App\Services;

abstract class BaseService
{
    public static function getInstance() : static
    {
        return app()->make(static::class);
    }

    public function refresh() : self
    {
        return self::getInstance();
    }
}
