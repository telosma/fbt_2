<div class="green-cross"></div>
<nav class="navbar navbar-fixed-top my-navbar-head">
    <div class="navbar-header col-md-4 col-sm-6 col-xs-6">
        <a class="navbar-brand" href="{{ route('home') }}">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="brand-logo"></div>
                </div>
                <div class="col-md-9 col-sm-6">
                    <span class="brand-text">{{ trans('label.brand') }}</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-8 col-sm-6 col-xs-6">
        <ul class="nav navbar-nav my-navbar-right">
            <li>
                {!! Form::open(['url' => '', 'method' => 'get']) !!}
                    {!! Form::text('query', null, ['id' => 'input-autocomplete', 'class' => 'search-box']) !!}
                    {!! Form::submit(trans('label.search'), ['class' => 'btn btn-info']) !!}
                {!! Form::close() !!}
            </li>
            <li><a data-toggle="modal" data-target="#login-modal">{{ trans('user.action.login') }}</a></li>
            <li><a class="last-element" data-toggle="modal" data-target="#register-modal">{{ trans('user.action.register') }}</a></li>
            <li>
                <div class="dropdown-toggle dropdown-user header-option" data-toggle="dropdown">
                    <img class="circle small" src="{{ config('asset.default_avatar') }}" alt="avt-img">
                    Name
                    <span class="caret"></span>
                </div>
                <ul class="dropdown-menu pull-right dropdown-user-menu">
                    <li><a href="#">{{ trans('user.profile') }}</a></li>
                    <li class="divider"></li>
                    <li><a href="#">{{ trans('user.action.logout') }}</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
