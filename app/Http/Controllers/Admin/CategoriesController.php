<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Models\Category;
use App\Models\Section;
use App\Services\Entities\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoriesController extends Controller
{
    public function index() : View
    {
        return view('admin.pages.categories.index', [
            'collection' => Category::latest()
                ->with(['sections', 'services'])
                ->paginate(ADMIN_DATATABLES_DEFAULT_PER_PAGE),
            'title' => 'Категории'
        ]);
    }

    public function create() : View
    {
        return view('admin.pages.categories.form', [
            'title' => 'Создание категории',
            'action' => route(ADMIN_CATEGORIES_STORE_ROUTE),
            'categories' => Category::all(),
            'sections' => Section::all(),
        ]);
    }

    public function store(StoreCategoryRequest $request, CategoryService $service): RedirectResponse
    {
        $service->store($request->getDto());

        return redirect()->route(ADMIN_CATEGORIES_INDEX_ROUTE);
    }

    public function edit(int $id, CategoryService $service) : View
    {
        $model = $service->getById($id);

        return view('admin.pages.categories.form', [
            'title' => 'Редактирование категории',
            'model' => $model,
            'action' => route(ADMIN_CATEGORIES_UPDATE_ROUTE, [$model->id]),
            'categories' => Category::where('id', '!=', $id)->get(),
            'sections' => Section::all(),
        ]);
    }

    public function update(int $id, StoreCategoryRequest $request, CategoryService $service): RedirectResponse
    {
        $service->update($id, $request->getDto());

        return redirect()->route(ADMIN_CATEGORIES_INDEX_ROUTE);
    }

    public function destroy(int $id, CategoryService $service): RedirectResponse
    {
        $service->delete($id);

        return redirect()->route(ADMIN_CATEGORIES_INDEX_ROUTE);
    }
}
