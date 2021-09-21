<div class="w-full overflow-hidden rounded-lg shadow-xs">
    <div class="w-full overflow-x-auto">
        <table class="w-full whitespace-no-wrap">
            <thead>
                {{ $thead }}
            </thead>
            <tbody
                class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
            >
                {{ $tbody }}
            </tbody>
        </table>
    </div>
    <div
        class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800"
    >
        <span class="flex items-center col-span-3">
             Показано {{ $collection->firstItem() }} - {{ $collection->lastItem() }} из {{ $collection->total() }}
        </span>
        <span class="col-span-2"></span>
        <!-- Pagination -->
        <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
            {{ $collection->links('vendor.pagination.tailwind-custom') }}
        </span>
    </div>
</div>
