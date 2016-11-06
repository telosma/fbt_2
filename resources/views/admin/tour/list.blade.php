@extends('layouts.adminMaster')

@section('page_title', trans('admin.list', ['name' => trans('admin.tour')]))
@section('main_title', trans('admin.list', ['name' => trans('admin.tour')]))

@include('includes.CKeditorScript')

@push('styles')
{!! Html::Style('css/adminTourStyle.css') !!}
@endpush

@section('content')
<table id="table" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th></th>
            <th>{!! trans('tour.name') !!}</th>
            <th>{!! trans('tour.category') !!}</th>
            <th>{!! trans('tour.price') !!}</th>
            <th>{!! trans('tour.num_day') !!}</th>
            <th>{!! trans('tour.rate') !!}</th>
            <th>{!! trans('tour.num_reviews') !!}</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th></th>
            <th>{!! trans('tour.name') !!}</th>
            <th>{!! trans('tour.category') !!}</th>
            <th>{!! trans('tour.price') !!}</th>
            <th>{!! trans('tour.num_day') !!}</th>
            <th>{!! trans('tour.rate') !!}</th>
            <th>{!! trans('tour.num_reviews') !!}</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </tfoot>
</table>
<!-- Modal edit-->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
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
                        {!! Form::label('category_id', trans('tour.category'), [
                            'class' => 'col-md-2 control-label'
                        ]) !!}
                        <div class="col-md-8">
                            {!! Form::select('category_id', [], null, [
                                'class' => 'form-control',
                                'placeholder' => trans('tour.choose_category')
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('places_list', trans('tour.places'), [
                            'class' => 'col-md-2 control-label'
                        ]) !!}
                        <div class="col-md-6">
                            {!! Form::select('places_list', [], null, [
                                'class' => 'form-control',
                                'placeholder' => trans('tour.choose_place')
                            ]) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::button(trans('admin.add'), ['class' => 'btn btn-primary btn-add-places']) !!}
                        </div>
                        <div class="col-md-8 col-md-offset-2" id="place_id"></div>
                    </div>
                    <div class="form-group">
                        {!! Form::label(
                            'name',
                            trans('tour.name'),
                            ['class' => 'col-md-2 control-label']
                        ) !!}
                        <div class="col-md-8">
                            {!! Form::text('name', null, [
                                'class' => 'form-control',
                                'placeholder' => trans('tour.write_name')
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label(
                            'price',
                            trans('tour.price'),
                            ['class' => 'col-md-2 control-label']
                        ) !!}
                        <div class="col-md-8">
                            {!! Form::number('price', null, [
                                'class' => 'form-control',
                                'placeholder' => trans('tour.write_price')
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label(
                            'num_day',
                            trans('tour.num_day'),
                            ['class' => 'col-md-2 control-label']
                        ) !!}
                        <div class="col-md-8">
                            {!! Form::number('num_day', null, [
                                'class' => 'form-control',
                                'placeholder' => trans('tour.write_num_day')
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label(
                            'description',
                            trans('tour.description'),
                            ['class' => 'col-md-2 control-label']
                        ) !!}
                        <div class="col-md-8">
                            {!! Form::textarea('description', null, [
                                'class' => 'form-control',
                                'rows' => config('common.textarea.rows'),
                                'cols' => config('common.textarea.cols'),
                            ]) !!}
                            <script>
                                CKEDITOR.replace('description');
                            </script>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-9">
                            {!! Form::button(trans('admin.save'), ['class' => 'btn btn-primary btn_save']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
                <!--end modal-body-->
            </div>
            <!--end modal-content-->
        </div>
    </div>
</div>
<!-- Modal edit image-->
<div class="modal fade" id="image-modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="image-modal-title"></h4>
                <!--end modal-header-->
            </div>
            <div class="modal-body">
                {!! Form::open(['class' => 'form-horizontal', 'method' => 'post', 'id' => 'image_form']) !!}
                    {!! Form::hidden('id', null) !!}
                    <div id="images-content"></div>
                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-9">
                            {!! Form::submit(trans('admin.save'), ['class' => 'btn btn-primary']) !!}
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
@include('includes.uploadMultipleFile')

@push('scripts')
{!! Html::script('js/adminTour.js') !!}
<script type="text/javascript">
    $(document).ready(function () {
        var Tour = new tour({
            url: {
                'ajaxShow': '{!! asset('admin/tour/ajax/show') !!}',
                'ajaxList': '{!! route('admin.tour.ajax.list') !!}',
                'ajaxCreate': '{!! route('admin.tour.ajax.create') !!}',
                'ajaxUpdate': '{!! route('admin.tour.ajax.update') !!}',
                'ajaxDelete': '{!! route('admin.tour.ajax.delete') !!}',
                'ajaxListCategory': '{!! route('admin.category.ajax.listOnly') !!}',
                'ajaxListPlaces': '{!! route('admin.place.ajax.listOnly') !!}',
                'ajaxUpdateImages': '{!! route('admin.tour.ajax.updateImage') !!}',
                'ajaxShowImage': '{!! asset('admin/tour/ajax/images') !!}',
            },
            lang: {
                'trans': {
                    'title_create': '{!! trans('tour.title_create') !!}',
                    'title_update': '{!! trans('tour.title_update') !!}',
                },
                'response': {
                    'key_name': '{!! config('common.flash_level_key') !!}',
                    'message_name': '{!! config('common.flash_message') !!}',
                },
            }
        });
        UploadMultipleFile.draw($('#images-content'));
    });
</script>
@endpush
