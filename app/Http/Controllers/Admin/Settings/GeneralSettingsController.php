<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGeneralSettingsRequest;
use App\Services\Entities\Settings\GeneralSettingsService;
use App\Services\Settings\GeneralSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GeneralSettingsController extends Controller
{
    use RefreshDatabase;

    public function edit(GeneralSettings $settings) : View
    {
        return view('admin.pages.settings.general.form', [
            'settings' => $settings->toCollection(),
            'title' => 'Настройки приложения',
            'action' => route(ADMIN_SETTINGS_GENERAL_UPDATE_ROUTE)
        ]);
    }

    public function update(
        StoreGeneralSettingsRequest $request,
        GeneralSettingsService $service
    ) : RedirectResponse {

        $service->update($request->getDto());

        return redirect()->back();
    }
}
