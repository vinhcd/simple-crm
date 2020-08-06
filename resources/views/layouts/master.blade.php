<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Neos Timesheet Project</title>

    @include('includes.head')
    @yield('custom-head')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        @include('includes.nav')

        @include('sidebar')

        <div class="content-wrapper">
            @include('includes.header')

            @yield('content')
        </div>

        @include('includes.footer')
        @include('includes.control-sidebar')
    </div>
    @include('includes.scripts')
    @yield('custom-scripts')
</body>
</html>
