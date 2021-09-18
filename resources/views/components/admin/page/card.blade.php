<div {{ $attributes->merge(['class' => 'grid mb-8']) }}>
    <div
        class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
    >
        <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300 text-lg">
            {{ $title }}
        </h4>
        {{ $body ?? ''}}
    </div>
</div>
