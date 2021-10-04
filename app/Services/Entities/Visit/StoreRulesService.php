<?php

namespace App\Services\Entities\Visit;

use App\Enums\VisitStatus;
use App\Rules\IsEmployeeCanService;
use App\Rules\IsEmployeeHasFreeTime;
use App\Rules\IsWillWorkEmployee;
use App\Rules\IsWorkDay;
use App\Rules\IsWorkTime;
use App\Services\BaseService;
use Illuminate\Validation\Rule;

class StoreRulesService extends BaseService
{
    public function get(array $request) : array
    {
        return [
            'visit_date' => [
                'bail',
                'required',
                'date',
                'after_or_equal:' . now()->toDateString(),
                new IsWorkDay()
            ],
            'visit_start_at' => [
                'bail',
                'required',
                'date_format:H:i',
                new IsWorkTime($request['visit_date'] ?? null)
            ],
            'visit_end_at' => [
                'bail',
                'required',
                'date_format:H:i',
                'after:visit_start_at',
                new IsWorkTime($request['visit_date'] ?? null)
            ],
            'employee_id' => [
                'bail',
                'required',
                'exists:employees,id',
                new IsWillWorkEmployee($request['visit_date'] ?? null),
                new IsEmployeeCanService($request['service_id'] ?? null),
                new IsEmployeeHasFreeTime(
                    $request['visit_start_at'] ?? null,
                    $request['visit_end_at'] ?? null,
                    $request['visit_date'] ?? null,
                    $request['id'] ?? null,
                )
            ],
            'service_id' => ['required', 'exists:services,id'],
            'client_id' => ['required', 'exists:clients,id'],
            'price' => ['required', 'numeric'],
            'status' => ['required', Rule::in(VisitStatus::getValues())],
        ];
    }
}
