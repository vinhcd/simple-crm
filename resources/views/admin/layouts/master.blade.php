<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Neos Organization Manager</title>

    @include('head')
    @yield('custom-head')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        @include('nav')

        @include('admin.sidebar')

        <div class="content-wrapper">
            @include('header')

            @yield('content')
        </div>

        @include('footer')
        @include('control-sidebar')
    </div>
    @yield('custom-scripts')
    @include('scripts')
</body>
</html>
