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
            <li class="elastic-search-box">
                {!! Form::open(['url' => '', 'method' => 'get']) !!}
                    {!! Form::text('query', null, ['id' => 'input-autocomplete', 'class' => 'search-box']) !!}
                    {!! Form::submit(trans('label.search'), ['class' => 'btn btn-info']) !!}
                {!! Form::close() !!}
            </li>
            <li>
                <a data-toggle="modal" data-target="#contact-form">
                    {{ trans('label.contact') }}
                </a>
            </li>
            @if (Auth::check())
                <li>
                    <div class="dropdown-toggle dropdown-user header-option" data-toggle="dropdown">
                        <img class="circle small" src="{{ Auth::user()->avatar_link }}" alt="avt-img">
                        {{ Auth::user()->name }}<span class="caret"></span>
                    </div>
                    <ul class="dropdown-menu pull-right dropdown-user-menu">
                        <li><a href="#">{{ trans('user.profile') }}</a></li>
                        <li><a href="{{ route('user.booking.index') }}">{{ trans('user.cart') }}</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ route('signout') }}">{{ trans('user.action.logout') }}</a></li>
                    </ul>
                </li>
            @else
                <li>
                    <a data-toggle="modal" data-target="#login-modal">
                        {{ trans('user.action.login') }}
                    </a>
                </li>
                <li>
                    <a class="last-element" data-toggle="modal" data-target="#register-modal">
                        {{ trans('user.action.register') }}
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>
@if (!Auth::check())
    @include('includes.modalAuth')
@endif
@include('includes.modalContact')
