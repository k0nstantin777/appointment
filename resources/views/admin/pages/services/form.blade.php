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
                    name="duration"
                    type="time"
                    label="Длительность"
                    value="{{ isset($model) ? $model->duration : ''}}"
                ></x-admin.form-fields.input>

                <x-admin.form-fields.input
                    name="price"
                    type="number"
                    label="Стоимость"
                    value="{{ isset($model) ? $model->price : ''}}"
                ></x-admin.form-fields.input>

                <x-admin.form-fields.textarea
                    name="description"
                    label="Описание"
                    value="{{ isset($model) ? $model->description : '' }}"
                ></x-admin.form-fields.textarea>

                <x-admin.form-fields.select-multiple
                    name="category_ids"
                    label="Связанные категории"
                    :selected="isset($model) ? $model->categories->pluck('id')->toArray() : []"
                    :options="$categories->pluck('name', 'id')->toArray()"
                ></x-admin.form-fields.select-multiple>

                <button class="btn btn-purple mt-3">
                   Сохранить
                </button>
            </form>
        </x-admin.page.card>
    </div>
@endsection
