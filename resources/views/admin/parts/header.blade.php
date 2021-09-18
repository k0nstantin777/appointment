<header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
    <div
        class="flex items-center justify-between h-full px-6 mx-auto text-purple-600 dark:text-purple-300"
    >
        <!-- Mobile hamburger -->
        <button
            class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple"
            @click="toggleSideMenu"
            aria-label="Menu"
        >
            <x-heroicon-s-menu class="w-6 h-6"/>
        </button>
        <!-- Search input -->
        <div class="flex justify-center flex-1 lg:mr-32">
            <div
                class="relative w-full max-w-xl mr-6 focus-within:text-purple-500"
            >
            </div>
        </div>
        <ul class="flex items-center flex-shrink-0 space-x-6">
            <!-- Profile menu -->
            <li class="relative">
                <button
                    class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none"
                    @click.stop="toggleProfileMenu"
                    @keydown.escape="closeProfileMenu"
                    aria-label="Account"
                    aria-haspopup="true"
                >
                    <x-heroicon-s-user-circle class="w-8 h-8"/>
                </button>
                <template x-if="isProfileMenuOpen">
                    <ul
                        @click.away="closeProfileMenu"
                        class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"
                        aria-label="submenu"
                    >
                        <li class="flex border-b">
                            <span
                                class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors
                                duration-150 rounded-md text-purple-600"
                            >
                                {{ $authUser->name }}
                            </span>
                        </li>
                        <li class="flex">
                            <a
                                class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                href="#"
                            >
                                <x-heroicon-o-user class="w-4 h-4 mr-3"/>
                                <span>Профиль</span>
                            </a>
                        </li>
                        <li class="flex">
                            <form action="{{ route('logout') }}" method="post" class="w-full">
                                @csrf
                                <button
                                    class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 r
                                    ounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                    type="submit"
                                    >
                                    <x-heroicon-o-logout class="w-4 h-4 mr-3"/>
                                    <span>Выход</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </template>
            </li>
        </ul>
    </div>
</header>
