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

                <x-admin.form-fields.textarea
                    name="description"
                    label="Описание"
                    value="{{ isset($model) ? $model->description : '' }}"
                ></x-admin.form-fields.textarea>

                <x-admin.form-fields.select
                    name="parent_category_id"
                    label="Родительская категория"
                    selected="{{ isset($model) ? $model->parent_id : '' }}"
                    :options="$categories->pluck('name', 'id')->toArray()"
                    placeholder="Выберите один из вариантов или оставьте пустым"
                ></x-admin.form-fields.select>

                <x-admin.form-fields.select-multiple
                    name="section_ids"
                    label="Связанные разделы"
                    :selected="isset($model) ? $model->sections->pluck('id')->toArray() : []"
                    :options="$sections->pluck('name', 'id')->toArray()"
                ></x-admin.form-fields.select-multiple>

                <button class="btn btn-purple mt-3">
                   Сохранить
                </button>
            </form>
        </x-admin.page.card>
    </div>
@endsection
