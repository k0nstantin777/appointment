<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePositionRequest;
use App\Models\Position;
use App\Services\Entities\PositionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PositionsController extends Controller
{
    public function index()
    {
        return view('admin.pages.positions.index', [
            'collection' => Position::latest()
                ->with('employees')
                ->paginate(ADMIN_DATATABLES_DEFAULT_PER_PAGE),
            'title' => 'Должности'
        ]);
    }

    public function create() : View
    {
        return view('admin.pages.positions.form', [
            'title' => 'Создание должности',
            'action' => route(ADMIN_POSITIONS_STORE_ROUTE),
        ]);
    }

    public function store(StorePositionRequest $request, PositionService $service): RedirectResponse
    {
        $service->store($request->getDto());

        return redirect()->route(ADMIN_POSITIONS_INDEX_ROUTE);
    }

    public function edit(int $id, PositionService $service) : View
    {
        $model = $service->getById($id);

        return view('admin.pages.positions.form', [
            'title' => 'Редактирование должности',
            'model' => $model,
            'action' => route(ADMIN_POSITIONS_UPDATE_ROUTE, [$model->id]),
        ]);
    }

    public function update(int $id, StorePositionRequest $request, PositionService $service): RedirectResponse
    {
        $service->update($id, $request->getDto());

        return redirect()->route(ADMIN_POSITIONS_INDEX_ROUTE);
    }

    public function destroy(int $id, PositionService $service): RedirectResponse
    {
        $service->delete($id);

        return redirect()->route(ADMIN_POSITIONS_INDEX_ROUTE);
    }
}
