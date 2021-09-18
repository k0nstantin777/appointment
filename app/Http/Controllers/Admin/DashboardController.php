<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Service;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index() : View {
        return view('admin.pages.dashboard', [
            'title' => 'Главная панель',
            'clients' => Client::all(),
            'employees' => Employee::all(),
            'services' => Service::all(),
            'categories' => Category::all(),
        ]);
    }
}
