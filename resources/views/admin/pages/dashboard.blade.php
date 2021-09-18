@extends('admin.layouts.app')

@section('admin.content')
    <div class="container px-6 mx-auto grid">
        <x-admin.page.head :text="$title"/>
        <!-- Cards -->
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
            <!-- Card -->
            <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
            >
                <div
                    class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500"
                >
                    <x-heroicon-o-users class="w-5 h-5"/>
                </div>
                <div>
                    <p
                        class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                    >
                        Клиентов
                    </p>
                    <p
                        class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                    >
                        {{ $clients->count() }}
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
            >
                <div
                    class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500"
                >
                    <x-heroicon-o-currency-dollar class="w-5 h-5"/>
                </div>
                <div>
                    <p
                        class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                    >
                        Сотрудников
                    </p>
                    <p
                        class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                    >
                        {{ $employees->count() }}
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
            >
                <div
                    class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500"
                >
                    <x-heroicon-o-switch-horizontal class="w-5 h-5"/>
                </div>
                <div>
                    <p
                        class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                    >
                        Категорий услуг
                    </p>
                    <p
                        class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                    >
                        {{ $categories->count() }}
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
            >
                <div
                    class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500"
                >
                    <x-heroicon-o-refresh class="w-5 h-5"/>
                </div>
                <div>
                    <p
                        class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                    >
                        Услуг
                    </p>
                    <p
                        class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                    >
                        {{ $services->count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
