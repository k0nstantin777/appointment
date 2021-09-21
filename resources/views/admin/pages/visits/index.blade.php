@extends('admin.layouts.app')

@section('admin.content')
    <div class="container px-6 mx-auto grid">
        <x-admin.page.head :text="$title"/>
        <x-admin.datatable :collection="$collection">
            <x-slot name="thead">
                <tr
                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                >
                    <th class="px-4 py-3">Дата</th>
                    <th class="px-4 py-3">Клиент</th>
                    <th class="px-4 py-3">Услуга</th>
                    <th class="px-4 py-3">Сотрудник</th>
                    <th class="px-4 py-3 w-40">Цена</th>
                </tr>
            </x-slot>
            <x-slot name="tbody">
                @foreach($component->collection as $item)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <div>
                                    <p class="font-semibold">{{ $item->date->toDateTimeString() }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $item->client->name }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $item->service->name }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $item->employee->name }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $item->price }} руб.
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-4 text-sm">
                                <button
                                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                    aria-label="Edit"
                                >
                                    <x-heroicon-o-pencil class="w-5 h-5"/>
                                </button>
                                <button
                                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                    aria-label="Delete"
                                >
                                    <x-heroicon-o-trash class="w-5 h-5"/>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-admin.datatable>
    </div>
@endsection
