<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreVisitRequest;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Visit;
use App\Services\Entities\VisitService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

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

    public function create() : View
    {
        return view('admin.pages.visits.form', [
            'title' => 'Создание визита',
            'action' => route(ADMIN_VISITS_STORE_ROUTE),
            'employees' => Employee::all(),
            'clients' => Client::all(),
            'services' => Service::all(),
        ]);
    }

    public function store(StoreVisitRequest $request, VisitService $service): RedirectResponse
    {
        $service->store($request->getDto());

        return redirect()->route(ADMIN_VISITS_INDEX_ROUTE);
    }

    public function edit(int $id, VisitService $service) : View
    {
        $model = $service->getById($id);

        return view('admin.pages.visits.form', [
            'title' => 'Редактирование визита',
            'model' => $model,
            'action' => route(ADMIN_VISITS_UPDATE_ROUTE, [$model->id]),
            'employees' => Employee::all(),
            'clients' => Client::all(),
            'services' => Service::all(),
        ]);
    }

    public function update(int $id, StoreVisitRequest $request, VisitService $service): RedirectResponse
    {
        $service->update($id, $request->getDto());

        return redirect()->route(ADMIN_VISITS_INDEX_ROUTE);
    }

    public function destroy(int $id, VisitService $service): RedirectResponse
    {
        $service->delete($id);

        return redirect()->route(ADMIN_VISITS_INDEX_ROUTE);
    }
}
