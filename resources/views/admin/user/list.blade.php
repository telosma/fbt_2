@extends('layouts.adminMaster')

@section('page_title', trans('admin.list', ['name' => trans('admin.user')]))

@section('main_title', trans('admin.list', ['name' => trans('admin.user')]))

@section('content')
<table id="table" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th></th>
            <th>{!! trans('user.name') !!}</th>
            <th>{!! trans('user.email') !!}</th>
            <th>{!! trans('user.reviews') !!}</th>
            <th>{!! trans('user.bookings') !!}</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th></th>
            <th>{!! trans('user.name') !!}</th>
            <th>{!! trans('user.email') !!}</th>
            <th>{!! trans('user.reviews') !!}</th>
            <th>{!! trans('user.bookings') !!}</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </tfoot>
</table>
<!-- Modal edit-->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="modal-title"></h4>
                <!--end modal-header-->
            </div>
            <div class="modal-body">
                {!! Form::open(['class' => 'form-horizontal', 'method' => 'post', 'id' => 'form_modal']) !!}
                    {!! Form::hidden('id', null) !!}
                    <div class="form-group">
                        {!! Form::label(
                            'name',
                            trans('user.name'),
                            ['class' => 'col-md-3 control-label']
                        ) !!}
                        <div class="col-md-8">
                            {!! Form::text('name', null, [
                                'class' => 'form-control',
                                'placeholder' => trans('user.write_name')
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label(
                            'email',
                            trans('user.email'),
                            ['class' => 'col-md-3 control-label']
                        ) !!}
                        <div class="col-md-8">
                            {!! Form::text('email', null, [
                                'class' => 'form-control',
                                'placeholder' => trans('user.write_email')
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-9">
                            {!! Form::submit(trans('admin.save'), ['class' => 'btn btn-primary btn_save']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
                <!--end modal-body-->
            </div>
            <!--end modal-content-->
        </div>
    </div>
</div>
@endsection

@include('includes.ajaxSendRequest')
@include('includes.datatableBase')

@push('scripts')
{!! Html::script('js/adminUser.js') !!}
<script type="text/javascript">
    $(document).ready(function () {
        var User = new user({
            url: {
                'ajaxList': '{!! route('admin.user.ajax.list') !!}',
                'ajaxCreate': '{!! route('admin.user.ajax.create') !!}',
                'ajaxUpdate': '{!! route('admin.user.ajax.update') !!}',
                'ajaxDelete': '{!! route('admin.user.ajax.delete') !!}',
                'ajaxResetPass': '{!! route('admin.user.ajax.resetPass') !!}',
            },
            lang: {
                'trans': {
                    'title_create': '{!! trans('user.title_create') !!}',
                    'title_update': '{!! trans('user.title_update') !!}',
                },
                'button_text': {
                    'reset_password': '{!! trans('user.reset_password') !!}',
                },
            }
        });
    });
</script>
@endpush
