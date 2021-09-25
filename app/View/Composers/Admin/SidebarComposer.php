<?php


namespace App\View\Composers\Admin;

use App\Services\Settings\GeneralSettings;
use Illuminate\View\View;

class SidebarComposer
{
    public function compose(View $view)
    {
        $view->with('generalSettings', new GeneralSettings());
    }
}
