<li class="relative px-6 py-3" x-data="dropdown">
    <button class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150
        hover:text-gray-800 dark:hover:text-gray-200 focus:outline-none"
        @click="toggle"
        aria-haspopup="true"
    >
        <span class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors
                    duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100">
            {{ $icon }}
            <span class="ml-4">{{ $name }}</span>
        </span>
        <x-heroicon-o-chevron-down
            class="w-5 h-5 text-gray-800 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100 transform"
            x-bind:class="isOpen ? '-rotate-90' : ''"
        />
    </button>

    {{ $dropdown }}
</li>

