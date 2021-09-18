<?php


namespace App\View\Composers\Admin;

use Illuminate\Auth\AuthManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HeaderComposer
{
    public function compose(View $view)
    {
        $view->with('authUser', Auth::user());
    }
}
