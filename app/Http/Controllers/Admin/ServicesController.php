<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreServiceRequest;
use App\Models\Category;
use App\Models\Service;
use App\Services\Entities\ServiceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServicesController extends Controller
{
    public function index() : View
    {
        return view('admin.pages.services.index', [
            'collection' => Service::latest()
                ->with(['categories'])
                ->paginate(ADMIN_DATATABLES_DEFAULT_PER_PAGE),
            'title' => 'Услуги'
        ]);
    }

    public function create() : View
    {
        return view('admin.pages.services.form', [
            'title' => 'Создание услуги',
            'action' => route(ADMIN_SERVICES_STORE_ROUTE),
            'categories' => Category::all(),
        ]);
    }

    public function store(StoreServiceRequest $request, ServiceService $service): RedirectResponse
    {
        $service->store($request->getDto());

        return redirect()->route(ADMIN_SERVICES_INDEX_ROUTE);
    }

    public function edit(int $id, ServiceService $service) : View
    {
        $model = $service->getById($id);

        return view('admin.pages.services.form', [
            'title' => 'Редактирование услуги',
            'model' => $model,
            'action' => route(ADMIN_SERVICES_UPDATE_ROUTE, [$model->id]),
            'categories' => Category::all(),
        ]);
    }

    public function update(int $id, StoreServiceRequest $request, ServiceService $service): RedirectResponse
    {
        $service->update($id, $request->getDto());

        return redirect()->route(ADMIN_SERVICES_INDEX_ROUTE);
    }

    public function destroy(int $id, ServiceService $service): RedirectResponse
    {
        $service->delete($id);

        return redirect()->route(ADMIN_SERVICES_INDEX_ROUTE);
    }
}
