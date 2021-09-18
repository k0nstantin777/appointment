@extends('admin.auth.layout')

@section('admin.auth.form')
    <h1
        class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200"
    >
        Восстановить пароль
    </h1>
    <form action="{{ route('password.email') }}" method="post">
        @csrf
        <label class="block text-sm">
            <span class="text-gray-700 dark:text-gray-400">Email</span>
            <input
                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none
                focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input
                @if($errors->has('email'))
                    border-red-500
                @endif
                "
                placeholder="Email"
                name="email"
                value="{{ old('email') ?? '' }}"
            />
            @if($errors->has('email'))
                <span class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                    {{ $errors->first('email') }}
                </span>
            @endif
        </label>

        <!-- You should use a button here, as the anchor is only used for the example  -->
        <button
            class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
            type="submit"
        >
            Отправить
        </button>
    </form>
@endsection
