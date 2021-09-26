<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FilterEmployeeWorkingDaysRequest;
use App\Http\Requests\Admin\UpdateEmployeeWorkingDaysRequest;
use App\Models\Employee;
use App\Models\WorkingDay;
use App\Services\Entities\EmployeeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EmployeeWorkingDaysController extends Controller
{
    public function edit(int $id, FilterEmployeeWorkingDaysRequest $request) : View
    {
        $employee = Employee::find($id);
        $requestDate = now();
        $month = $request->get('filter-month') ?? $requestDate->month;
        $year = $request->get('filter-year') ?? $requestDate->year;

        $requestDate->setYear($year);
        $requestDate->setMonth($month);

        $workingDays = WorkingDay::whereMonth('calendar_date', $month)
            ->whereYear('calendar_date', $year)
            ->where('employee_id', $id)
            ->get();

        $months = [];
        $years = array_combine([$requestDate->year, $requestDate->year+1], [$requestDate->year, $requestDate->year+1]);
        for($i=1; $i <=12 ; $i++){
            $months[$i] = $requestDate->copy()->setMonth($i)->monthName;
        }

        return view('admin.pages.employees.working-days')
            ->with([
                'title' => 'График работы сотрудника ' . $employee->name,
                'employee' => $employee,
                'workingDays' => $workingDays,
                'requestDate' => $requestDate,
                'today' => now(),
                'months' => $months,
                'years' => $years,
            ]);
    }

    public function update(
        int $id,
        UpdateEmployeeWorkingDaysRequest $request,
        EmployeeService $service
    ) : RedirectResponse {

        $dto = $request->getDto();
        $service->updateWorkingDays($id, $dto);

        return redirect()->back();
    }
}
