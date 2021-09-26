@extends('admin.layouts.app')

@section('admin.content')
    <div class="container px-6 mx-auto grid">
        <x-admin.page.head :text="$title"/>
        <x-admin.page.card>
            <form action="{{ $action }}" method="post">
                @csrf
                @isset($model)
                    @method('put')
                @endisset

                <x-admin.form-fields.input
                    name="visit_date"
                    label="Дата визита"
                    value="{{ isset($model) ? $model->visit_date->toDateString() : ''}}"
                    type="date"
                ></x-admin.form-fields.input>

                <x-admin.form-fields.input
                    name="visit_start_at"
                    label="Начало визита"
                    value="{{ isset($model) ? $model->start_at->format('H:i') : ''}}"
                    type="time"
                ></x-admin.form-fields.input>


                <x-admin.form-fields.input
                    name="visit_end_at"
                    label="Окончание визита"
                    value="{{ isset($model) ? $model->end_at->format('H:i') : ''}}"
                    type="time"
                ></x-admin.form-fields.input>

                <x-admin.form-fields.select
                    name="client_id"
                    label="Клиент"
                    selected="{{ isset($model) ? $model->client_id : '' }}"
                    :options="$clients->pluck('name', 'id')->toArray()"
                ></x-admin.form-fields.select>

                <x-admin.form-fields.select
                    name="employee_id"
                    label="Сотрудник"
                    selected="{{ isset($model) ? $model->employee_id : '' }}"
                    :options="$employees->pluck('name', 'id')->toArray()"
                ></x-admin.form-fields.select>

                <x-admin.form-fields.select
                    name="service_id"
                    label="Услуга"
                    selected="{{ isset($model) ? $model->service_id : '' }}"
                    :options="$services->pluck('name', 'id')->toArray()"
                ></x-admin.form-fields.select>

                <x-admin.form-fields.input
                    name="price"
                    type="number"
                    label="Стоимость"
                    value="{{ isset($model) ? $model->price : ''}}"
                ></x-admin.form-fields.input>

                <button class="btn btn-purple mt-3">
                   Сохранить
                </button>
            </form>
        </x-admin.page.card>
    </div>
@endsection
