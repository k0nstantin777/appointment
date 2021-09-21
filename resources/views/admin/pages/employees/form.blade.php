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
                    name="name"
                    label="Имя"
                    value="{{ isset($model) ? $model->name : ''}}"
                ></x-admin.form-fields.input>

                <x-admin.form-fields.input
                    name="email"
                    label="Email"
                    value="{{ isset($model) ? $model->email : '' }}"
                ></x-admin.form-fields.input>

                <x-admin.form-fields.select
                    name="position_id"
                    label="Должность"
                    selected="{{ isset($model) ? $model->position_id : '' }}"
                    :options="$positions->pluck('name', 'id')->toArray()"
                ></x-admin.form-fields.select>

                <x-admin.form-fields.select-multiple
                    name="service_ids"
                    label="Оказываемые услуги"
                    :selected="isset($model) ? $model->services->pluck('id')->toArray() : []"
                    :options="$services->pluck('name', 'id')->toArray()"
                ></x-admin.form-fields.select-multiple>

                <button class="btn btn-purple mt-3">
                   Сохранить
                </button>
            </form>
        </x-admin.page.card>
    </div>
@endsection
