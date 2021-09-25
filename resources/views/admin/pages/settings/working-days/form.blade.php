@extends('admin.layouts.app')

@section('admin.content')
    <div class="container px-6 mx-auto grid">
        <x-admin.page.head :text="$title"/>
        <x-admin.page.card>
            <form action="{{ $action }}" method="post">
                @csrf
                @method('put')

                @foreach($settings as $index => $value)
                    <label class="block text-sm mb-3">
                        <span class="text-gray-700 dark:text-gray-400">
                           {{ __('settings.' .$index) }}
                        </span>
                        <div class="flex items-center">
                            <input
                                class="block mt-1 text-sm dark:text-gray-300 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-red form-input
                                @if($errors->has($index . '.0'))
                                    border-red-600
                                @endif
                                "
                                type="time"
                                name="{{ $index }}[]"
                                value="{{ $value[0] ?? '' }}"
                            />

                            <span class="mx-3">-</span>
                            <input
                                class="block mt-1 text-sm dark:text-gray-300 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-red form-input
                                @if($errors->has($index . '.1'))
                                    border-red-600
                                @endif
                                "
                                type="time"
                                name="{{ $index }}[]"
                                value="{{ $value[1] ?? '' }}"
                            />
                        </div>
                        @if($errors->has($index))
                            <span class="text-xs text-red-600 dark:text-red-400">
                                {{ $errors->first($index) }}
                            </span>
                        @endif
                        @if($errors->has($index . '.0'))
                            <span class="text-xs text-red-600 dark:text-red-400">
                                {{ $errors->first($index . '.0') }}
                            </span>
                        @endif
                        @if($errors->has($index . '.1'))
                            <span class="text-xs text-red-600 dark:text-red-400">
                                {{ $errors->first($index . '.1') }}
                            </span>
                        @endif
                    </label>
                @endforeach

                <button class="btn btn-purple mt-3">
                   Сохранить
                </button>
            </form>
        </x-admin.page.card>
    </div>
@endsection
