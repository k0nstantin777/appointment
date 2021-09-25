<?php

namespace App\Providers;

use App\View\Composers\Admin\HeaderComposer as AdminHeaderComposer;
use App\View\Composers\Admin\SidebarComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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
     */
    public function boot()
    {
        View::composer('admin.parts.header', AdminHeaderComposer::class);
        View::composer('admin.parts.sidebar', SidebarComposer::class);

    }
}
