<label class="block text-sm mb-3">
    <span class="text-gray-700 dark:text-gray-400">
        {{ $label }}
    </span>
    <input
        class="block w-full mt-1 text-sm dark:text-gray-300 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-red form-input
            @if($errors->has($name))
                border-red-600
            @endif
        "
        type="{{ $type }}"
        placeholder="{{ $placeholder ?: $label }}"
        name="{{ $name }}"
        value="{{ old($name) ?? $value }}"
    />
    @if($errors->has($name))
        <span class="text-xs text-red-600 dark:text-red-400">
           {{ $errors->first($name) }}
        </span>
    @endif
</label>
