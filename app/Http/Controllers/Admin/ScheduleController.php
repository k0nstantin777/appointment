<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Visit;
use App\Services\Settings\WorkingDaysSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    public function index(Request $request, WorkingDaysSettings $settings) : View
    {
        $now = $request->has('date') ? Carbon::parse($request->get('date')) :  now();
        [$startTime, $endTime] = $settings->{strtolower($now->englishDayOfWeek)};

        $startTimeObj = Carbon::parse($startTime);
        $endTimeObj =  Carbon::parse($endTime);

        $timesNet = [];

        while($startTimeObj->lessThanOrEqualTo($endTimeObj)) {
            $timesNet[] = $startTimeObj->format('H:i');
            $startTimeObj->addMinutes(10);
        }

        $visits = Visit::whereDate('visit_date', $now->toDateString())
            ->with(['employee', 'client', 'service'])
            ->get();

        return view('admin.pages.schedule', [
            'title' => 'Расписание на ' . $now->format('d/m/Y'),
            'employees' => Employee::with(['visits', 'visits.client', 'visits.service'])->get(),
            'timesNet' => $timesNet,
            'today' => $now,
            'visits' => $visits,
        ]);
    }
}
