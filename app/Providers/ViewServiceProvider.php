<?php

namespace App\Providers;

use App\View\Composers\AccountSideBarComposer;
use App\View\Composers\Admin\HeaderComposer as AdminHeaderComposer;
use App\View\Composers\FooterComposer;
use App\View\Composers\HeaderComposer;
use Illuminate\Support\Facades\Blade;
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
        View::composer('parts.header', HeaderComposer::class);
        View::composer('parts.footer', FooterComposer::class);
        View::composer('parts.account.side-bar', AccountSideBarComposer::class);

        $this->loadViewsFrom(resource_path('views/livewire/admin/datatables/'), 'admin.datatables');

        Blade::if('prod', function () {
            return app()->environment() === 'production';
        });
    }
}
