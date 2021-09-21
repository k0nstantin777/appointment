<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreClientRequest;
use App\Models\Client;
use App\Services\Entities\ClientService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClientsController extends Controller
{
    public function index() : View
    {
        return view('admin.pages.clients.index', [
            'collection' => Client::latest()
                ->with(['visits'])
                ->paginate(ADMIN_DATATABLES_DEFAULT_PER_PAGE),
            'title' => 'Клиенты'
        ]);
    }

    public function create() : View
    {
        return view('admin.pages.clients.form', [
            'title' => 'Создание клиента',
            'action' => route(ADMIN_CLIENTS_STORE_ROUTE),
        ]);
    }

    public function store(StoreClientRequest $request, ClientService $service): RedirectResponse
    {
        $service->store($request->getDto());

        return redirect()->route(ADMIN_CLIENTS_INDEX_ROUTE);
    }

    public function edit(int $id, ClientService $service) : View
    {
        $model = $service->getById($id);

        return view('admin.pages.clients.form', [
            'title' => 'Редактирование клиента',
            'model' => $model,
            'action' => route(ADMIN_CLIENTS_UPDATE_ROUTE, ['client' => $model->id]),
        ]);
    }

    public function update(int $id, StoreClientRequest $request, ClientService $service): RedirectResponse
    {
        $service->update($id, $request->getDto());

        return redirect()->route(ADMIN_CLIENTS_INDEX_ROUTE);
    }

    public function destroy(int $id, ClientService $service): RedirectResponse
    {
        $service->delete($id);

        return redirect()->route(ADMIN_CLIENTS_INDEX_ROUTE);
    }
}
