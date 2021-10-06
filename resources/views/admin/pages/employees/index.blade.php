@extends('admin.layouts.app')

@section('admin.content')
    <div class="container px-6 mx-auto grid mb-6">
        <x-admin.page.head :text="$title"/>
        <div class="flex mb-3">
            <a class="btn btn-purple" href="{{ route(ADMIN_EMPLOYEES_CRETE_ROUTE) }}">
                <x-heroicon-o-plus class="w-5 h-5"/>
                Создать сотрудника
            </a>
        </div>
        <x-admin.datatable :collection="$collection">
            <x-slot name="thead">
                <tr
                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                >
                    <th class="px-4 py-3">Имя</th>
                    <th class="px-4 py-3">Должность</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Оказываемые услуги</th>
                    <th class="px-4 py-3 w-40">Действия</th>
                </tr>
            </x-slot>
            <x-slot name="tbody">
                @foreach($component->collection as $item)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <div>
                                    <p class="font-semibold">{{ $item->name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $item->position->name }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $item->email }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            @foreach($item->services as $service)
                                {{ $service->name }} <br>
                            @endforeach
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-4 text-sm">
                                <a href="{{ route(ADMIN_EMPLOYEES_EDIT_ROUTE, [$item->id]) }}"
                                    class="flex items-center justify-between px-1 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                    aria-label="Edit"
                                    title="Редактировать"
                                >
                                    <x-heroicon-o-pencil class="w-5 h-5"/>
                                </a>
                                <a href="{{ route(ADMIN_EMPLOYEES_WORKING_DAYS_EDIT_ROUTE, [$item->id]) }}"
                                   class="flex items-center justify-between px-1 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                   aria-label="Edit"
                                   title="Редактировать график"
                                >
                                    <x-heroicon-o-calendar class="w-5 h-5"/>
                                </a>
                                <a href="{{ route(ADMIN_VISITS_CREATE_ROUTE, ['employee_id' => $item->id]) }}"
                                   class="flex items-center justify-between px-1 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                   aria-label="Edit"
                                   title="Создать визит"
                                >
                                    <x-heroicon-o-plus-circle class="w-5 h-5"/>
                                </a>
                                <form action="{{ route(ADMIN_EMPLOYEES_DELETE_ROUTE,  [$item->id]) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit"
                                        class="flex items-center justify-between px-1 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                        aria-label="Delete"
                                        title="Удалить"
                                    >
                                        <x-heroicon-o-trash class="w-5 h-5"/>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-admin.datatable>
    </div>
@endsection
