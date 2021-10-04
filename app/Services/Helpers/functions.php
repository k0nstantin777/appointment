<?php

if (!function_exists('viewEmptyData')) {
    function viewEmptyData($value) : string
    {
        if (is_null($value) || $value === '') {
            return 'Нет данных для просмотра';
        }

        return $value;
    }
}

if (!function_exists('escapeBotChars')) {
    function escapeBotChars($string) : string
    {
        return addcslashes($string, '_*[]()~>#+-=|{}.!');
    }
}
