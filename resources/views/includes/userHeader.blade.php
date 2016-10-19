<div class="green-cross"></div>
<nav class="navbar navbar-fixed-top my-navbar-head">
    <div class="navbar-header col-md-4 col-sm-6 col-xs-6">
        <a class="navbar-brand" href="{{ route('home') }}">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div style="width: 50px; height: 50px; background: url({{ asset('images/logo-fr.png') }}) center no-repeat; background-size: cover;"></div>
                </div>
                <div class="col-md-9 col-sm-6">
                    <span style="color: #fff; font-size: 30px; font-weight: 900; position: relative;">{{ trans('label.brand') }}</span>
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
            <li><a data-toggle="modal" data-target="#login-modal">{{ trans('label.login') }}</a></li>
            <li><a class="last-element" data-toggle="modal" data-target="#register-modal">{{ trans('label.register') }}</a></li>
            <li>
                <div class="dropdown-toggle dropdown-user header-option" data-toggle="dropdown">
                    <img class="circle small" src="https://tky-chat-work-appdata.s3.amazonaws.com/avatar/1211/1211498.rsz.jpg" alt="avt-img">
                    Name
                    <span class="caret"></span>
                </div>
                <ul class="dropdown-menu pull-right" style="position: absolute;">
                    <li><a href="#">{{ trans('user.profile') }}</a></li>
                    <li class="divider"></li>
                    <li><a href="#">{{ trans('user.action.logout') }}</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<div id="login-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ trans('label.modal.login_title') }}</h4>
            </div>
            <div class="box-warper">
                <div class="row">
                    <div class="col-md-4">
                        <div class="social-login fb">
                            <i class="face-icon fa fa-facebook"></i>
                            <span class="face-text">{{ trans('label.login_with_fb') }}</span>
                        </div>
                        <div class="social-login gg">
                            <i class="gg-icon fa fa-google-plus"></i>
                            <span class="gg-text">{{ trans('label.login_with_gg') }}</span>
                        </div>
                        <div class="social-login tw">
                            <i class="gg-icon fa fa-twitter"></i>
                            <span class="gg-text">{{ trans('label.login_with_tw') }}</span>
                        </div>
                    </div>
                    <div class="col-md-7 col-md-offset-1">
                        <h4>{{ trans('label.normal_login') }}</h4>
                        {!! Form::open(['url' => '#', 'method' => 'post']) !!}
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-envelope"></span>
                                    </div>
                                    {!! Form::text('email', null,['class' => 'form-control', 'placeholder' => trans('label.your_email')]) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-lock"></span>
                                    </div>
                                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => trans('label.password')]) !!}
                                </div>
                            </div>
                            {!! Form::submit(trans('label.login'), ['class' => 'btn btn-info']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="endbox">{{ trans('label.question_has_account') }}<span style="color:blue; cursor:pointer;"> {{ trans('label.register') }} </span></div>
            </div>
        </div>
    </div>
</div>
<div id="register-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ trans('label.modal.regiter_title') }}</h4>
            </div>
            <div class="box-warper">
                <div class="row">
                    <div class="col-md-4">
                        <div class="social-login fb">
                            <i class="face-icon fa fa-facebook"></i>
                            <span class="gg-text">{{ trans('label.login_with_fb') }}</span>
                        </div>
                        <div class="social-login gg">
                            <i class="gg-icon fa fa-google-plus"></i>
                            <span class="gg-text">{{ trans('label.login_with_gg') }}</span>
                        </div>
                        <div class="social-login tw">
                            <i class="gg-icon fa fa-twitter"></i>
                            <span class="gg-text">{{ trans('label.login_with_tw') }}</span>
                        </div>
                    </div>
                    <div class="col-md-7 col-md-offset-1">
                        <h4>{{ trans('label.new_register') }}</h4>
                        {!! Form::open(['route' => 'postSignup', 'method' => 'post']) !!}
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="fa fa-user"></span>
                                    </div>
                                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('label.your_name')]) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-envelope"></span>
                                    </div>
                                    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => trans('label.your_email')]) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-lock"></span>
                                    </div>
                                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => trans('label.password')]) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-lock"></span>
                                    </div>
                                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => trans('label.confirm_password')]) !!}
                                </div>
                            </div>
                            {!! Form::submit(trans('label.register'), ['class' => 'btn btn-info']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
