<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>{!! trans('admin.admin_login') !!}</title>        
        {!! Html::style('css/login-form.css') !!}
    </head>
    <body>
        {!! Form::open([
            'action' => 'Admin\AdminController@postLogin',
            'class' => 'login',
            'method' => 'post',
        ]) !!}
            <h1>{!! trans('admin.login') !!}</h1>
            @include('includes.error')
            @include('includes.message')
            <fieldset class="inputs">
                {!! Form::email('email', null, [
                    'class' => 'email',
                    'placeholder' => trans('admin.email'),
                ]) !!}
                {!! Form::password('password', [
                    'class' => 'password',
                    'placeholder' => trans('admin.password'),
                ]) !!}
            </fieldset>
            <fieldset class="actions">
                {!! Form::submit(trans('admin.submit'), ['class' => 'submit']) !!}
            </fieldset>
        {!! Form::close() !!}
        {!! Html::script('js/jquery.min.js') !!}
        {!! Html::script('js/adminScript.js') !!}
    </body>
</html>
