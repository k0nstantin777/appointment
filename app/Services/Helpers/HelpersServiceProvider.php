<?php

namespace App\Services\Helpers;

use Illuminate\Support\ServiceProvider;

class HelpersServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        require_once(__DIR__ . '/constants.php');
        require_once(__DIR__ . '/functions.php');
    }
}
