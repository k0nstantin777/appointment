@extends('admin.layouts.app')

@section('admin.content')
    <div class="container px-6 mx-auto grid">
        <x-admin.page.head :text="$title"/>
        <x-admin.page.card>
            <form action="{{ route(ADMIN_SCHEDULE_INDEX_ROUTE) }}" method="get" class="flex items-center">
                <x-admin.form-fields.input
                    name="date"
                    label="Дата"
                    type="date"
                    value="{{ $today->toDateString() }}"
                ></x-admin.form-fields.input>
                <button class="btn btn-purple ml-3 mt-3">
                    Открыть
                </button>
                <a href="{{ route(ADMIN_VISITS_CREATE_ROUTE, ['visit_date' => $today->toDateString()]) }}" class="btn btn-purple ml-3 mt-3">
                    Создать визит
                </a>
            </form>
        </x-admin.page.card>
        <x-admin.page.card>
            @if(count($timesNet) === 0)
                <div>
                    Выходной, визитов нет.
                </div>
            @else
                <div class="overflow-auto">
                    <div class="schedule" aria-labelledby="schedule-heading" style="max-height: {{ count($timesNet)*10 + 30 }}px">
                        @foreach($employees as $index => $employee)
                            <span class="track-slot"
                                  aria-hidden="true"
                                  style="grid-column: track-{{ $employee->id }}; grid-row: tracks;"
                            > {{ $employee->name }}</span>
                        @endforeach

                        @foreach($timesNet as $time)
                            <h2 class="time-slot" style="grid-row: time-{{str_replace(':', '', $time) }};">{{$time}}</h2>
                            @foreach($employees as $index => $employee)
                                @php
                                    $workingDay = $employee->getWorkingDayByDate($today);
                                    [$hours, $minutes] = explode(':', $time);
                                    $currentTime = now()->copy()->setTime($hours, $minutes);
                                @endphp
                                <span
                                    style="
                                        border-top: 1px solid #ccc;
                                        border-left: 1px solid #ccc;
                                        grid-row: time-{{str_replace(':', '', $time) }};
                                        grid-column: track-{{ $employee->id }};
                                        @if(!$workingDay || $workingDay->start_at->greaterThan($currentTime) || $workingDay->end_at->lessThan($currentTime))
                                            background-color: #888888;
                                        @else
                                            background-color: #bbbbbb;
                                        @endif
                                        "
                                ></span>
                            @endforeach
                            @foreach($visits as $visit)
                                <div class="session session-1 track-{{ $visit->employee_id }} visit {{ $visit->status }}"
                                     style="grid-column: track-{{ $visit->employee_id }};
                                         grid-row: time-{{ $visit->start_at->ceilUnit('minute', 10)->format('Hi') }} / time-{{ $visit->end_at->ceilUnit('minute', 10)->format('Hi') }};
                                         z-index: {{ $visit->start_at->ceilUnit('minute', 10)->format('Hi') }};
                                         "
                                >
                                    <h3 class="session-title">
                                        <a href="{{ route(ADMIN_CLIENTS_EDIT_ROUTE, [$visit->client->id]) }}">{{ $visit->client->name }}</a>
                                    </h3>
                                    <span class="session-time">
                                        <a href="{{ route(ADMIN_VISITS_EDIT_ROUTE, [$visit->id]) }}">
                                            {{ $visit->start_at->ceilUnit('minute', 10)->format('H:i') }} - {{ $visit->end_at->ceilUnit('minute', 10)->format('H:i') }}
                                        </a>
                                    </span>
                                    <span class="session-track">{{ $visit->price }} руб.</span>
                                    <span class="session-presenter">
                                        <a href="{{ route(ADMIN_SERVICES_EDIT_ROUTE, [$visit->service->id]) }}">
                                            {{ $visit->service->name }}
                                        </a>
                                    </span>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            @endif
        </x-admin.page.card>
    </div>
@endsection

@push('admin.styles')
    <style>
        @media screen and (min-width:700px) {
            .schedule {
                display: grid;
                grid-template-rows:
                [tracks] auto
                 @foreach($timesNet as $time)
                   [time-{{ str_replace(':', '', $time) }}] 1fr
                 @endforeach
                ;

                grid-template-columns:
                [times] 4em
                @foreach($employees as $index => $employee)
                    @if($loop->first)
                        [track-{{$employee->id}}-start] 1fr
                        @php $previous = $employee @endphp
                        @continue
                    @endif
                    [track-{{$previous->id}}-end track-{{$employee->id}}-start] 1fr
                    @if($loop->last)
                        [track-{{$employee->id}}-end];
                    @endif
                        @php $previous = $employee @endphp
                @endforeach
            }
        }
    </style>
@endpush

