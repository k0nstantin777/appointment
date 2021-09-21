<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        return view('admin.pages.services.index', [
            'collection' => Service::latest()
                ->with(['categories'])
                ->paginate(ADMIN_DATATABLES_DEFAULT_PER_PAGE),
            'title' => 'Услуги'
        ]);
    }
}
