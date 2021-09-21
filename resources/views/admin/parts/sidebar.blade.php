<div class="py-4 text-gray-500 dark:text-gray-400">
    <a
        class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200"
        href="#"
    >
        {{ config('app.name') }}
    </a>
    <ul class="mt-6">
        <x-admin.sidebar.item :name="'Главная панель'" :route="route(ADMIN_DASHBOARD_ROUTE)"
            :is-active="request()->routeIs(ADMIN_DASHBOARD_ROUTE)"
        >
            <x-slot name="icon">
                <x-heroicon-o-home class="w-5 h-5"/>
            </x-slot>
        </x-admin.sidebar.item>
        <x-admin.sidebar.item :name="'Должности'" :route="route(ADMIN_POSITIONS_INDEX_ROUTE)"
                              :is-active="request()->routeIs('admin.positions.*')"
        >
            <x-slot name="icon">
                <x-heroicon-o-identification class="w-5 h-5"/>
            </x-slot>
        </x-admin.sidebar.item>
        <x-admin.sidebar.item :name="'Сотрудники'" :route="route(ADMIN_EMPLOYEES_INDEX_ROUTE)"
                              :is-active="request()->routeIs('admin.employees.*')"
        >
            <x-slot name="icon">
                <x-heroicon-o-user-group class="w-5 h-5"/>
            </x-slot>
        </x-admin.sidebar.item>
        <x-admin.sidebar.item :name="'Разделы'" :route="route(ADMIN_SECTIONS_INDEX_ROUTE)"
                              :is-active="request()->routeIs('admin.sections.*')"
        >
            <x-slot name="icon">
                <x-heroicon-o-rss class="w-5 h-5"/>
            </x-slot>
        </x-admin.sidebar.item>
        <x-admin.sidebar.item :name="'Категории'" :route="route(ADMIN_CATEGORIES_INDEX_ROUTE)"
                              :is-active="request()->routeIs('admin.categories.*')"
        >
            <x-slot name="icon">
                <x-heroicon-o-view-list class="w-5 h-5"/>
            </x-slot>
        </x-admin.sidebar.item>
        <x-admin.sidebar.item :name="'Услуги'" :route="route(ADMIN_SERVICES_INDEX_ROUTE)"
                              :is-active="request()->routeIs('admin.services.*')"
        >
            <x-slot name="icon">
                <x-heroicon-o-shopping-cart class="w-5 h-5"/>
            </x-slot>
        </x-admin.sidebar.item>
        <x-admin.sidebar.item :name="'Клиенты'" :route="route(ADMIN_CLIENTS_INDEX_ROUTE)"
                              :is-active="request()->routeIs('admin.clients.*')"
        >
            <x-slot name="icon">
                <x-heroicon-o-users class="w-5 h-5"/>
            </x-slot>
        </x-admin.sidebar.item>
        <x-admin.sidebar.item :name="'График'" :route="route(ADMIN_WORKING_DAYS_INDEX_ROUTE)"
                              :is-active="request()->routeIs('admin.working_days.*')"
        >
            <x-slot name="icon">
                <x-heroicon-o-calendar
                    class="w-5 h-5"/>
            </x-slot>
        </x-admin.sidebar.item>
        <x-admin.sidebar.item :name="'Визиты'" :route="route(ADMIN_VISITS_INDEX_ROUTE)"
                              :is-active="request()->routeIs('admin.visits.*')"
        >
            <x-slot name="icon">
                <x-heroicon-o-clipboard-check
                    class="w-5 h-5"/>
            </x-slot>
        </x-admin.sidebar.item>
    </ul>
</div>
