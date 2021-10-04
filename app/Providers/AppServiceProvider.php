<?php

namespace App\Providers;

use App\Services\TelegramBot\Storages\AppointmentCacheStorage;
use App\Services\TelegramBot\Storages\AppointmentStorage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Telegram\Bot\Api;
use Telegram\Bot\BotsManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Request::macro('isAdminRequest', function () {
            return str_starts_with($this->getPathInfo(), '/' . config('app.admin_prefix'));
        });

        $this->app->singleton(Api::class, static function ($app) {
            return $app[BotsManager::class]->bot();
        });

        $this->app->singleton(AppointmentStorage::class, static function ($app) {
            return $app[AppointmentCacheStorage::class];
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));
    }
}
