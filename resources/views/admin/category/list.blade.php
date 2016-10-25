@extends('layouts.adminMaster')

@section('page_title', trans('admin.list', ['name' => trans('admin.category')]))

@section('main_title', trans('admin.list', ['name' => trans('admin.category')]))

@section('content')
<table id="table" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th></th>
            <th>{!! trans('category.name') !!}</th>
            <th>{!! trans('category.parent') !!}</th>
            <th>{!! trans('category.tours_count') !!}</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th></th>
            <th>{!! trans('category.name') !!}</th>
            <th>{!! trans('category.parent') !!}</th>
            <th>{!! trans('category.tours_count') !!}</th>
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
                        {!! Form::label('parent_id', trans('category.parent_id'), [
                            'class' => 'col-md-3 control-label'
                        ]) !!}
                        <div class="col-md-8">
                            {!! Form::select('parent_id', [], null, [
                                'class' => 'form-control',
                                'placeholder' => trans('category.choose_parent')
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label(
                            'name',
                            trans('category.name'),
                            ['class' => 'col-md-3 control-label']
                        ) !!}
                        <div class="col-md-8">
                            {!! Form::text('name', null, [
                                'class' => 'form-control',
                                'placeholder' => trans('category.write_category')
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
{!! Html::script('js/adminCategory.js') !!}
<script type="text/javascript">
    $(document).ready(function () {
        var Category = new category({
            url: {
                'ajaxList': '{!! route('admin.category.ajax.list') !!}',
                'ajaxCreate': '{!! route('admin.category.ajax.create') !!}',
                'ajaxUpdate': '{!! route('admin.category.ajax.update') !!}',
                'ajaxDelete': '{!! route('admin.category.ajax.delete') !!}',
                'ajaxListOnly': '{!! route('admin.category.ajax.listOnly') !!}',
            },
            lang: {
                'trans': {
                    'title_create': '{!! trans('category.title_create') !!}',
                    'title_update': '{!! trans('category.title_update') !!}',
                },
            }
        });
    });
</script>
@endpush
