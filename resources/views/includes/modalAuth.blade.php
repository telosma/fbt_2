<div id="login-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ trans('label.modal.login_title') }}</h4>
            </div>
            <div class="modal-auth-body">
                <div class="box-warper">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="social-login fb">
                                <a href="{{ route('redirectToProvider', 'facebook') }}">
                                    <i class="face-icon fa fa-facebook"></i>
                                    <span class="face-text">{{ trans('label.login_with_fb') }}</span>
                                </a>
                            </div>
                            <div class="social-login gg">
                                <a href="{{ route('redirectToProvider', 'github') }}">
                                    <i class="gg-icon fa fa-google-plus"></i>
                                    <span class="gg-text">{{ trans('label.login_with_gg') }}</span>
                                </a>
                            </div>
                            <div class="social-login gh">
                                <a href="{{ route('redirectToProvider', 'github') }}">
                                    <i class="gg-icon fa fa-github"></i>
                                    <span class="gg-text">{{ trans('label.login_with_gh') }}</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4>{{ trans('label.normal_login') }}</h4>
                            {!! Form::open(['url' => '', 'method' => 'post']) !!}
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-envelope"></span>
                                        </div>
                                        {!! Form::text('email', null,[
                                            'class' => 'form-control',
                                            'placeholder' => trans('label.your_email'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-lock"></span>
                                        </div>
                                        {!! Form::password('password', [
                                            'class' => 'form-control',
                                            'placeholder' => trans('label.password'),
                                        ]) !!}
                                    </div>
                                </div>
                                {!! Form::submit(trans('label.login'), ['class' => 'btn btn-info']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>                
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
            <div class="modal-auth-body">
                <div class="box-warper">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="social-login fb">
                                <i class="face-icon fa fa-facebook"></i>
                                <span class="gg-text">{{ trans('label.login_with_fb') }}</span>
                            </div>
                            <div class="social-login gg">
                                <i class="gg-icon fa fa-google-plus"></i>
                                <span class="gg-text">{{ trans('label.login_with_gg') }}</span>
                            </div>
                            <div class="social-login gh">
                                <i class="gg-icon fa fa-twitter"></i>
                                <span class="gg-text">{{ trans('label.login_with_gh') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4>{{ trans('label.new_register') }}</h4>
                            {!! Form::open(['route' => 'signup', 'method' => 'post']) !!}
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <span class="fa fa-user"></span>
                                        </div>
                                        {!! Form::text('name', null, [
                                            'class' => 'form-control',
                                            'placeholder' => trans('label.your_name'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-envelope"></span>
                                        </div>
                                        {!! Form::text('email', null, [
                                            'class' => 'form-control',
                                            'placeholder' => trans('label.your_email'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-lock"></span>
                                        </div>
                                        {!! Form::password('password', [
                                            'class' => 'form-control',
                                            'placeholder' => trans('label.password'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-lock"></span>
                                        </div>
                                        {!! Form::password('password_confirmation', [
                                            'class' => 'form-control',
                                            'placeholder' => trans('label.confirm_password'),
                                        ]) !!}
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
</div>
