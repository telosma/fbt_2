<div id="contact-form" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ trans('label.contact_us') }}</h4>
            </div>
            <div class="box-warper">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        {{ Form::open(['route' => 'postContact', 'method' => 'post']) }}
                            <div class="form-group">
                                {{ Form::label('email', trans('label.your_email')) }}
                                {{ Form::text('email', null, ['id' => 'email', 'class' => 'form-control']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('phone', trans('label.your_phone')) }}
                                {{ Form::text('phone', null, ['id' => 'phone', 'class' => 'form-control']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('subject', trans('label.subject')) }}
                                {{ Form::text('subject', null, ['id' => 'subject', 'class' => 'form-control']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('bodymMessage', trans('label.message')) }}
                                {{ Form::textarea('bodyMessage', null, ['id' => 'message', 'class' => 'form-control']) }}
                            </div>
                            {{ Form::submit(trans('user.action.send_mail'), ['class' => 'btn btn-info']) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
