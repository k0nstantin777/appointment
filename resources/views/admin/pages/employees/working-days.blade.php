@extends('admin.layouts.app')

@section('admin.content')
    <div class="container px-6 mx-auto">
        <x-admin.page.head :text="$title"/>

        <x-admin.page.card class="w-56" title="Фильтр">
            <form action="{{ route(ADMIN_EMPLOYEES_WORKING_DAYS_EDIT_ROUTE, [$employee->id]) }}" method="get">
                <x-admin.form-fields.select
                    name="filter-month"
                    label="Месяц"
                    selected="{{ $requestDate->month }}"
                    :options="$months"
                ></x-admin.form-fields.select>
                <x-admin.form-fields.select
                    name="filter-year"
                    label="Год"
                    selected="{{ $requestDate->year }}"
                    :options="$years"
                ></x-admin.form-fields.select>
                <button class="btn btn-purple mt-3">
                    Открыть
                </button>
            </form>
        </x-admin.page.card>

        <x-admin.page.card title="График на {{ $requestDate->monthName }}, {{ $requestDate->year }}">
            <form action="{{ route(ADMIN_EMPLOYEES_WORKING_DAYS_UPDATE_ROUTE, [$employee->id]) }}" method="post"  class="w-full overflow-hidden rounded-lg shadow-xs">
                @csrf
                @method('put')
                @foreach($errors->all() as $message)
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </span>
                    <br>
                @endforeach
                <input type="hidden" name="year" value="{{ $requestDate->year }}">
                <input type="hidden" name="month" value="{{ $requestDate->month }}">
                <div class="overflow-auto">
                    <table class="employee-schedule table-auto"  aria-label="employee-schedule">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-center text-gray-500 uppercase">
                                <th class="py-3 w-56 sticky left-0 bg-gray-300" rowspan="2" id="month-name">{{ $requestDate->monthName }}</th>
                                @for($i = 1; $i <= $requestDate->daysInMonth; $i++)
                                    <th class="py-3 {{ ($requestDate->month === $today->month && $i === $today->day) ? 'bg-purple-200' : '' }}">
                                        {{ $i }}
                                    </th>
                                @endfor
                            </tr>
                            <tr class="text-xs font-semibold text-center text-gray-500 uppercase">
                                @for($i = 1; $i <= $requestDate->daysInMonth; $i++)
                                    @php $weekDay = $requestDate->copy()->setDay($i) @endphp
                                    <th class="py-3 {{ ($weekDay->dayOfWeek > 5 || $weekDay->dayOfWeek === 0) ? 'text-red-600' : '' }}">
                                        {{ $weekDay->shortDayName }}
                                    </th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <tr class="text-xs font-semibold text-center text-gray-500 uppercase">
                                <td class="px-3 py-5 sticky left-0 w-56 bg-gray-300">Начало</td>
                                @for($i = 1; $i <= $requestDate->daysInMonth; $i++)
                                    @php
                                        $weekDay = $requestDate->copy()->setDay($i);
                                        $workingDay = $workingDays->first(fn($workingDay) => $workingDay->calendar_date->toDateString() === $weekDay->toDateString());
                                    @endphp
                                    <td class="px-3 py-5">
                                        <input type="time" name="start_days[]"
                                               value="{{ $workingDay ? $workingDay->start_at : '' }}"
                                               class="block w-25 mt-1 text-sm focus:border-purple-400 focus:outline-none focus:shadow-outline-red form-input"
                                        />
                                    </td>
                                @endfor
                            </tr>
                            <tr class="text-xs font-semibold text-center text-gray-500 uppercase">
                                <td class="px-3 py-5 sticky left-0 w-56 bg-gray-300">Окончание</td>
                                @for($i = 1; $i <= $requestDate->daysInMonth; $i++)
                                    @php
                                        $weekDay = $requestDate->copy()->setDay($i);
                                        $workingDay = $workingDays->first(fn($workingDay) => $workingDay->calendar_date->toDateString() === $weekDay->toDateString());
                                    @endphp
                                    <td class="px-3 py-5">
                                        <input type="time" value="{{ $workingDay ? $workingDay->end_at : '' }}"
                                               name="end_days[]"
                                               class="block w-25 mt-1 text-sm dark:text-gray-300 dark:bg-gray-700
                                                      focus:border-purple-400 focus:outline-none focus:shadow-outline-red form-input"
                                        />
                                    </td>
                                @endfor
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button class="btn btn-purple mt-3">
                    Сохранить
                </button>
            </form>
        </x-admin.page.card>
    </div>
@endsection
