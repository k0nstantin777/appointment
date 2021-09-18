<div class="py-4 text-gray-500 dark:text-gray-400">
    <a
        class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200"
        href="#"
    >
        {{ config('app.name') }}
    </a>
    <ul>
        <x-admin.sidebar.item :name="'Главная панель'" :route="route(ADMIN_DASHBOARD_ROUTE)"
            :is-active="request()->routeIs(ADMIN_DASHBOARD_ROUTE)"
        >
            <x-slot name="icon">
                <x-heroicon-o-home class="w-5 h-5"/>
            </x-slot>
        </x-admin.sidebar.item>
    </ul>
</div>
