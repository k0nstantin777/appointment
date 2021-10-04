<?php


namespace App\Services;

abstract class BaseService
{
    public static function getInstance(...$params) : static
    {
        return app()->make(static::class, $params);
    }

    public function refresh() : self
    {
        return self::getInstance();
    }
}
