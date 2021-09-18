@extends('admin.layouts.base')

@section('bodyContent')
    <div
        class="flex h-screen bg-gray-50 dark:bg-gray-900"
        :class="{ 'overflow-hidden': isSideMenuOpen }"
    >
        <!-- Desktop sidebar -->
        <aside
            class="z-20 hidden sidebar overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0"
            aria-label="default"
        > @include('admin.parts.sidebar')
        </aside>
        <!-- Backdrop -->
        <div
            x-show="isSideMenuOpen"
            x-transition:enter="transition ease-in-out duration-150"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in-out duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
        ></div>
        <!-- Mobile sidebar -->
        <aside
            class="fixed inset-y-0 z-20 flex-shrink-0 sidebar mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden"
            x-show="isSideMenuOpen"
            x-transition:enter="transition ease-in-out duration-150"
            x-transition:enter-start="opacity-0 transform -translate-x-20"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in-out duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0 transform -translate-x-20"
            @click.away="closeSideMenu"
            @keydown.escape="closeSideMenu"
            aria-label="mobile"
        >
            @include('admin.parts.sidebar')
        </aside>
        <div class="flex flex-col flex-1 main">
            @include('admin.parts.header')
            <main class="h-full overflow-y-auto">
                @include('admin.parts.breadcrumbs')
                @yield('admin.content')
            </main>
        </div>
    </div>
@endsection

@push('admin.scripts')
    <script src="{{ url(mix('/js/admin/app.js')) }}"></script>
@endpush
