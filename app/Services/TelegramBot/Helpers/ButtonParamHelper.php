<?php

namespace App\Services\TelegramBot\Helpers;

class ButtonParamHelper
{
    private const GLUE = '::';

    public function encode(array $params) : string
    {
        return implode(self::GLUE, $params);
    }

    public function decode(string $encodeString) : array
    {
        return explode(self::GLUE, $encodeString);
    }
}
