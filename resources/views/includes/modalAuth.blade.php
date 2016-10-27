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
                        {!! Form::open(['route' => 'signin', 'method' => 'post']) !!}
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
                <div class="endbox">
                    {{ trans('label.question_has_account') }}
                    <span>{{ trans('label.register') }}</span>
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
                        {!! Form::open(['url' => '', 'method' => 'post']) !!}
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
