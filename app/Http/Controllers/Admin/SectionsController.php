<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSectionRequest;
use App\Models\Section;
use App\Services\Entities\SectionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SectionsController extends Controller
{
    public function index()
    {
        return view('admin.pages.sections.index', [
            'collection' => Section::paginate(ADMIN_DATATABLES_DEFAULT_PER_PAGE),
            'title' => 'Разделы'
        ]);
    }

    public function create() : View
    {
        return view('admin.pages.sections.form', [
            'title' => 'Создание раздела',
            'action' => route(ADMIN_SECTIONS_STORE_ROUTE),
        ]);
    }

    public function store(StoreSectionRequest $request, SectionService $service): RedirectResponse
    {
        $service->store($request->getDto());

        return redirect()->route(ADMIN_SECTIONS_INDEX_ROUTE);
    }

    public function edit(int $id, SectionService $service) : View
    {
        $model = $service->getById($id);

        return view('admin.pages.sections.form', [
            'title' => 'Редактирование раздела',
            'model' => $model,
            'action' => route(ADMIN_SECTIONS_UPDATE_ROUTE, [$model->id]),
        ]);
    }

    public function update(int $id, StoreSectionRequest $request, SectionService $service): RedirectResponse
    {
        $service->update($id, $request->getDto());

        return redirect()->route(ADMIN_SECTIONS_INDEX_ROUTE);
    }

    public function destroy(int $id, SectionService $service): RedirectResponse
    {
        $service->delete($id);

        return redirect()->route(ADMIN_SECTIONS_INDEX_ROUTE);
    }
}
