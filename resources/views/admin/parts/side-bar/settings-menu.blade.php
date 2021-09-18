<template x-if="isOpen">
    <ul x-transition:enter="transition-all ease-in-out duration-300" x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl" x-transition:leave="transition-all ease-in-out duration-300" x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0 max-h-0" class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900" aria-label="submenu">
        <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
            <a class="w-full" href="{{ route(ADMIN_GENERAL_SETTINGS_ROUTE, ['group' => 'common']) }}">{{ __('Common Settings') }}</a>
        </li>
        <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
            <a class="w-full" href="{{ route(ADMIN_GENERAL_SETTINGS_ROUTE, ['group' => 'operator_schedule']) }}">{{ __('Operator schedule settings') }}</a>
        </li>
{{--        <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">--}}
{{--            <a class="w-full" href="{{ route(ADMIN_GENERAL_SETTINGS_ROUTE, ['group' => 'customer']) }}">{{ __('Customer settings') }}</a>--}}
{{--        </li>--}}
        <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
            <a class="w-full" href="{{ route(ADMIN_GENERAL_SETTINGS_ROUTE, ['group' => 'bonus_system']) }}">{{ __('Bonus system settings') }}</a>
        </li>
        <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
            <a class="w-full" href="{{ route(ADMIN_GENERAL_SETTINGS_ROUTE, ['group' => 'referral_program']) }}">{{ __('Referral program settings') }}</a>
        </li>
        <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
            <a class="w-full" href="{{ route(ADMIN_GENERAL_SETTINGS_ROUTE, ['group' => 'exchange_process']) }}">{{ __('Exchange process settings') }}</a>
        </li>
{{--        <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">--}}
{{--            <a class="w-full" href="{{ route(ADMIN_GENERAL_SETTINGS_ROUTE, ['group' => 'public_api']) }}">{{ __('Public API settings') }}</a>--}}
{{--        </li>--}}
        <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
            <a class="w-full" href="{{ route(ADMIN_GENERAL_SETTINGS_ROUTE, ['group' => 'email_settings']) }}">{{ __('Email settings') }}</a>
        </li>
        <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
            <a class="w-full" href="{{ route(ADMIN_GENERAL_SETTINGS_ROUTE, ['group' => 'social_media']) }}">{{ __('Social media settings') }}</a>
        </li>
    </ul>
</template>
