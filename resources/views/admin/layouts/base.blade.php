<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? config('app.name') }}</title>
    @include('admin.parts.styles')
    @stack('admin.styles')
    <script src="{{ url(mix('/js/admin/alpine.js')) }}" defer></script>
</head>
<body :class="{'theme-dark': dark }" x-data="data()">
    @yield('bodyContent')
    @stack('admin.vendor-scripts')
    @stack('admin.scripts')
</body>
</html>
