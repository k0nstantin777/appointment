<?php

namespace App\Providers;

use App\Services\Admin\Breadcrumbs\AdminBreadcrumbs;
use App\Services\Breadcrumbs\BreadcrumbsService;
use Illuminate\Support\ServiceProvider;

class BreadcrumbsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     * @throws \Throwable
     */
    public function boot()
    {
        if (request()->isAdminRequest()) {
            rescue(static function () {
                BreadcrumbsService::getInstance()->register( (new AdminBreadcrumbs())());
            });
        }
    }
}
