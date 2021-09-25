<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreWorkingDaysSettingsRequest;
use App\Services\Entities\Settings\WorkingDaysSettingsService;
use App\Services\Settings\WorkingDaysSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WorkingDaysSettingsController extends Controller
{
    public function edit(WorkingDaysSettings $settings) : View
    {
        return view('admin.pages.settings.working-days.form', [
            'settings' => $settings->toCollection(),
            'title' => 'График работы',
            'action' => route(ADMIN_SETTINGS_WORKING_DAYS_UPDATE_ROUTE)
        ]);
    }

    public function update(
        StoreWorkingDaysSettingsRequest $request,
        WorkingDaysSettingsService $service
    ) : RedirectResponse {

        $service->update($request->getDto());

        return redirect()->back();
    }
}
