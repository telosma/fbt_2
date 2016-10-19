<!DOCTYPE html>

<html>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {!! Html::style('css/bootstrap.min.css') !!}
        {!! Html::style('css/font-awesome.min.css') !!}
        {!! Html::style('css/main.css') !!}

        @yield('style')

    </head>
    <body>

        @include('includes.userHeader')
        <div class="wrraper">
            @yield('content')            
        </div>
        @include('includes.userFooter')

        {!! Html::script('js/jquery.min.js') !!}
        {!! Html::script('js/bootstrap.min.js') !!}

        @yield('script')
    </body>
</html>
