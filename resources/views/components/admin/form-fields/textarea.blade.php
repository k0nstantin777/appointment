<label class="block text-sm mb-3">
    <span class="text-gray-700 dark:text-gray-400">
        {{ $label }}
    </span>
    <textarea
        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray
            @if($errors->has($name))
                border-red-600
            @endif
        "
        placeholder="{{ $placeholder ?: $label }}"
        name="{{ $name }}"
        rows="3"
    >{{ old($name) ?? $value }}</textarea>
    @if($errors->has($name))
        <span class="text-xs text-red-600 dark:text-red-400">
           {{ $errors->first($name) }}
        </span>
    @endif
</label>
