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
