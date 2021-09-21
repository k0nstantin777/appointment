<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEmployeeRequest;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Service;
use App\Services\Entities\EmployeeService;
use App\Services\Entities\SectionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EmployeesController extends Controller
{
    public function index() : View
    {
        return view('admin.pages.employees.index', [
            'collection' => Employee::latest()
                ->with(['position','services'])
                ->paginate(ADMIN_DATATABLES_DEFAULT_PER_PAGE),
            'title' => 'Сотрудники'
        ]);
    }

    public function create() : View
    {
        return view('admin.pages.employees.form', [
            'title' => 'Создание сотрудника',
            'action' => route(ADMIN_EMPLOYEES_STORE_ROUTE),
            'positions' => Position::all(),
            'services' => Service::all(),
        ]);
    }

    public function store(StoreEmployeeRequest $request, EmployeeService $service): RedirectResponse
    {
        $service->store($request->getDto());

        return redirect()->route(ADMIN_EMPLOYEES_INDEX_ROUTE);
    }

    public function edit(int $id, EmployeeService $service) : View
    {
        $model = $service->getById($id);

        return view('admin.pages.employees.form', [
            'title' => 'Редактирование сотрудника',
            'model' => $model,
            'action' => route(ADMIN_EMPLOYEES_UPDATE_ROUTE, [$model->id]),
            'positions' => Position::all(),
            'services' => Service::all(),
        ]);
    }

    public function update(int $id, StoreEmployeeRequest $request, EmployeeService $service): RedirectResponse
    {
        $service->update($id, $request->getDto());

        return redirect()->route(ADMIN_EMPLOYEES_INDEX_ROUTE);
    }

    public function destroy(int $id, EmployeeService $service): RedirectResponse
    {
        $service->delete($id);

        return redirect()->route(ADMIN_EMPLOYEES_INDEX_ROUTE);
    }
}
