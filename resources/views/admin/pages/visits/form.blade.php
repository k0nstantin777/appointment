@extends('admin.layouts.app')

@section('admin.content')
    <div class="container px-6 mx-auto grid">
        <x-admin.page.head :text="$title"/>
        <x-admin.page.card>
            <form action="{{ $action }}" method="post">
                @csrf
                @isset($model->id)
                    @method('put')
                @endisset

                <x-admin.form-fields.input
                    name="visit_date"
                    label="Дата визита"
                    value="{{ old('visit_date') ?? $model->visit_date->toDateString() }}"
                    type="date"
                ></x-admin.form-fields.input>

                <x-admin.form-fields.input
                    name="visit_start_at"
                    label="Начало визита"
                    value="{{ old('visit_start_at') ?? $model->start_at->format('H:i') }}"
                    type="time"
                ></x-admin.form-fields.input>


                <x-admin.form-fields.input
                    name="visit_end_at"
                    label="Окончание визита"
                    value="{{ old('visit_end_at') ?? $model->end_at->format('H:i') }}"
                    type="time"
                ></x-admin.form-fields.input>

                <x-admin.form-fields.select
                    name="client_id"
                    label="Клиент"
                    selected="{{ old('client_id') ??  $model->client_id }}"
                    :options="$clients->pluck('name', 'id')->toArray()"
                ></x-admin.form-fields.select>

                <x-admin.form-fields.select
                    name="employee_id"
                    label="Сотрудник"
                    selected="{{ old('employee_id') ?? $model->employee_id }}"
                    :options="$employees->pluck('name', 'id')->toArray()"
                ></x-admin.form-fields.select>

                <x-admin.form-fields.select
                    name="service_id"
                    label="Услуга"
                    selected="{{ old('service_id') ?? $model->service_id }}"
                    :options="$services->pluck('name', 'id')->toArray()"
                ></x-admin.form-fields.select>

                <x-admin.form-fields.input
                    name="price"
                    type="number"
                    label="Стоимость"
                    value="{{ old('price') ?? $model->price }}"
                ></x-admin.form-fields.input>

                <x-admin.form-fields.select
                    name="status"
                    label="Статус"
                    selected="{{ isset($model) ? $model->status : \App\Enums\VisitStatus::NEW }}"
                    :options="$statuses"
                ></x-admin.form-fields.select>

                <button class="btn btn-purple mt-3">
                   Сохранить
                </button>
            </form>
        </x-admin.page.card>
    </div>
@endsection
