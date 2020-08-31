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

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{route('home')}}" class="brand-link">
            <img src="{{url('dist/img/AdminLTELogo.png')}}" alt="Neos Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Neos Corporation</span>
        </a>
    </aside>

    <div class="content-wrapper">
        @include('includes.header')

        @yield('content')
    </div>

    @include('includes.footer')
</div>
@include('includes.scripts')
@yield('custom-scripts')
</body>
</html>
