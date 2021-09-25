@extends('admin.layouts.app')

@section('admin.content')
    <div class="container px-6 mx-auto grid">
        <x-admin.page.head :text="$title"/>
        <x-admin.page.card>
            <form action="{{ $action }}" method="post">
                @csrf
                @method('put')

                @foreach($settings as $index => $value)
                    <x-admin.form-fields.input
                        name="{{ $index }}"
                        label="{{ __('settings.' .$index) }}"
                        value="{{ old($index) ?? $value }}"
                    ></x-admin.form-fields.input>
                @endforeach

                <button class="btn btn-purple mt-3">
                   Сохранить
                </button>
            </form>
        </x-admin.page.card>
    </div>
@endsection
