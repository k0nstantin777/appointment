@extends('admin.auth.layout')

@section('admin.auth.form')
    <h1
        class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200"
    >
        {{ __('Reset Password') }}
    </h1>
    <form action="{{ route('password.update') }}" method="post">
        @csrf
        <label class="block text-sm">
            <span class="text-gray-700 dark:text-gray-400">{{ __('Email') }}</span>
            <input
                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400
                focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input
                    @if($errors->has('email'))
                        border-red-500
                    @endif
                    "
                placeholder="{{ __('E-Mail Address') }}"
                name="email"
                value="{{ request()->get('email') }}"
                readonly
            />
            @if($errors->has('email'))
                <span class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                    {{ $errors->first('email') }}
                </span>
            @endif
        </label>
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400">{{ __('Password') }}</span>
            <input
                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400
                    focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input
                    @if($errors->has('password'))
                        border-red-500
                    @endif
                    "
                placeholder="***************"
                type="password"
                name="password"
                value="{{ old('password') ?? '' }}"
            />
            @if($errors->has('password'))
                <span class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                    {{ $errors->first('password') }}
                </span>
            @endif
        </label>
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400">{{ __('Password Confirmation') }}</span>
            <input
                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400
                    focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input
                    @if($errors->has('password_confirmation'))
                        border-red-500
                    @endif
                    "
                placeholder="***************"
                type="password"
                name="password_confirmation"
                value="{{ old('password_confirmation') ?? '' }}"
            />
            @if($errors->has('password_confirmation'))
                <span class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                    {{ $errors->first('password_confirmation') }}
                </span>
            @endif
        </label>
        <input type="hidden" name="token" value="{{ request()->route('token') }}">
        <!-- You should use a button here, as the anchor is only used for the example  -->
        <button
            class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
            type="submit"
        >
            {{ __('Send') }}
        </button>
    </form>
@endsection
