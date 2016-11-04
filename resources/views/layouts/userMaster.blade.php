<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('page_title')</title>
        {!! Html::style('css/bootstrap.min.css') !!}
        {!! Html::style('css/font-awesome.min.css') !!}
        {!! Html::style('css/main.css') !!}
        @yield('style')
        @stack('header')
    </head>
    <body>
        @include('includes.userHeader')
        <div class="container-fluid page-body">
            @yield('content')
        </div>
        <div class="container-fluid">
            @include('includes.userFooter')
        </div>
        {!! Html::script('js/jquery.min.js') !!}
        {!! Html::script('js/bootstrap.min.js') !!}
        @yield('script')
        @stack('scripts')
    </body>
</html>
