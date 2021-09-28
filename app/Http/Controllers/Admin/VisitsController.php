<?php

namespace App\Http\Controllers\Admin;

use App\Enums\VisitStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreVisitRequest;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Visit;
use App\Services\Entities\VisitService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VisitsController extends Controller
{
    public function index() : View
    {
        return view('admin.pages.visits.index', [
            'collection' => Visit::orderBy('visit_date', 'desc')
                ->with(['service', 'client', 'employee'])
                ->paginate(ADMIN_DATATABLES_DEFAULT_PER_PAGE),
            'title' => 'Визиты'
        ]);
    }

    public function create(VisitService $service, Request $request) : View
    {
        return view('admin.pages.visits.form', array_merge([
                'title' => 'Создание визита',
                'action' => route(ADMIN_VISITS_STORE_ROUTE),
                'model' => $service->makeDefault([
                    'client_id' => $request->get('client_id', ''),
                    'employee_id' => $request->get('employee_id', ''),
                    'service_id' => $request->get('service_id', ''),
                    'visit_date' => $request->get('visit_date', '')
                ]),
            ], $this->getFormData()
        ));
    }

    public function store(StoreVisitRequest $request, VisitService $service): RedirectResponse
    {
        $service->store($request->getDto());

        return redirect()->back();
    }

    public function edit(int $id, VisitService $service) : View
    {
        $model = $service->getById($id);

        return view('admin.pages.visits.form', array_merge([
                'title' => 'Редактирование визита',
                'model' => $model,
                'action' => route(ADMIN_VISITS_UPDATE_ROUTE, [$model->id])
            ], $this->getFormData()
        ));
    }

    private function getFormData() : array
    {
        return [
            'employees' => Employee::all(),
            'clients' => Client::all(),
            'services' => Service::all(),
            'statuses' => array_combine(VisitStatus::getValues(),
                array_map(
                    static fn($item) => VisitStatus::getDescription($item),
                    VisitStatus::getValues(),
                ),
            )
        ];
    }

    public function update(int $id, StoreVisitRequest $request, VisitService $service): RedirectResponse
    {
        $service->update($id, $request->getDto());

        return redirect()->back();
    }

    public function destroy(int $id, VisitService $service): RedirectResponse
    {
        $service->delete($id);

        return redirect()->back();
    }
}
