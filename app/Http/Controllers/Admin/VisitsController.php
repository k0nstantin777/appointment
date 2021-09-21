<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Http\Request;

class VisitsController extends Controller
{
    public function index()
    {
        return view('admin.pages.visits.index', [
            'collection' => Visit::orderBy('date', 'desc')
                ->with(['service', 'client', 'employee'])
                ->paginate(ADMIN_DATATABLES_DEFAULT_PER_PAGE),
            'title' => 'Визиты'
        ]);
    }
}
