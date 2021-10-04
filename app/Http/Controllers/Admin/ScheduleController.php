<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Visit;
use App\Services\Entities\Settings\WorkingDaysSettingsService;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    public function index(Request $request, WorkingDaysSettingsService $workingDaysSettingsService) : View
    {
        $request->validate([
            'date' => ['nullable', 'date']
        ]);

        $today = $request->has('date') ? Carbon::parse($request->get('date')) :  now();

        $timesNet = [];
        if (false === $workingDaysSettingsService->isTodayDayOff($today)) {
            $todayWorkingTimes = $workingDaysSettingsService->getTodayWorkingTimes($today);

            $startTimeObj = $todayWorkingTimes['start_time'];
            $endTimeObj = $todayWorkingTimes['end_time'];

            while($startTimeObj->lessThanOrEqualTo($endTimeObj)) {
                $timesNet[] = $startTimeObj->format('H:i');
                $startTimeObj->addMinutes(10);
            }
        }

        $visits = Visit::whereDate('visit_date', $today->toDateString())
            ->with(['employee', 'client', 'service'])
            ->get();

        return view('admin.pages.schedule', [
            'title' => 'Расписание на ' . $today->format('d/m/Y'),
            'employees' => Employee::with(['visits', 'visits.client', 'visits.service'])->get(),
            'timesNet' => $timesNet,
            'today' => $today,
            'visits' => $visits,
        ]);
    }
}
