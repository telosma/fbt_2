@extends('layouts.adminMaster')

@section('page_title', trans('admin.list', ['name' => trans('admin.tour_schedule')]))

@section('main_title', trans('admin.list', ['name' => trans('admin.tour_schedule')]))

@section('content')
<table id="table" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th></th>
            <th>{!! trans('tourSchedule.tour_name') !!}</th>
            <th>{!! trans('tourSchedule.max_slot') !!}</th>
            <th>{!! trans('tourSchedule.available_slot') !!}</th>
            <th>{!! trans('tourSchedule.num_day') !!}</th>
            <th>{!! trans('tourSchedule.start_date') !!}</th>
            <th>{!! trans('tourSchedule.end_date') !!}</th>
            <th>{!! trans('tourSchedule.price') !!}</th>
            <th>{!! trans('tourSchedule.origin_price') !!}</th>
            <th>{!! trans('tourSchedule.revenue') !!}</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th></th>
            <th>{!! trans('tourSchedule.tour_name') !!}</th>
            <th>{!! trans('tourSchedule.max_slot') !!}</th>
            <th>{!! trans('tourSchedule.available_slot') !!}</th>
            <th>{!! trans('tourSchedule.num_day') !!}</th>
            <th>{!! trans('tourSchedule.start_date') !!}</th>
            <th>{!! trans('tourSchedule.end_date') !!}</th>
            <th>{!! trans('tourSchedule.price') !!}</th>
            <th>{!! trans('tourSchedule.origin_price') !!}</th>
            <th>{!! trans('tourSchedule.revenue') !!}</th>
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
                <div class="row">
                    {!! Form::open(['method' => 'post', 'id' => 'form_modal']) !!}
                        {!! Form::hidden('id', null) !!}
                        <div class="col-sm-12">
                            <div class="row">
                                <label class="col-sm-2">{!! trans('tourSchedule.tour') !!}</label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        {!! Form::select('tour_id', [], null, [
                                            'class' => 'form-control',
                                            'placeholder' => trans('tourSchedule.choose_tour')
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row tour-option">
                                <label class="col-sm-2">{!! trans('tourSchedule.option') !!}</label>
                                <div class="col-sm-10">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-xs-3 label-option">{!! trans('tour.category') !!}</div>
                                                <div class="col-xs-9" id="tour-category">
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-xs-3 label-option">{!! trans('tour.name') !!}</div>
                                                <div class="col-xs-9" id="tour-name">
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-xs-3 label-option">{!! trans('tour.places') !!}</div>
                                                <div class="col-xs-9" id="tour-place">
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-xs-3 label-option">
                                                    {!! trans('tourSchedule.origin_price') !!}
                                                </div>
                                                <div class="col-xs-9" id="tour-price">
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-xs-3 label-option">{!! trans('tour.num_day') !!}</div>
                                                <div class="col-xs-9" id="tour-num-day">
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading" id="schedule-title"></div>
                                <div class="panel-body">
                                    <div class="btn btn-default" id="btn-create">
                                        {!! trans('tourSchedule.create_new') !!}
                                    </div>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="form-group">
                                                        {!! Form::text('start', null, [
                                                            'class' => 'form-control',
                                                            'placeholder' => trans('tourSchedule.start_date')
                                                        ]) !!}
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="form-group">
                                                        {!! Form::text('end', null, [
                                                            'class' => 'form-control',
                                                            'placeholder' => trans('tourSchedule.end_date')
                                                        ]) !!}
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="form-group">
                                                        {!! Form::text('max_slot', null, [
                                                            'class' => 'form-control',
                                                            'placeholder' => trans('tourSchedule.max_slot')
                                                        ]) !!}
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="form-group">
                                                        {!! Form::select('revenue_id', [], null, [
                                                            'class' => 'form-control',
                                                            'placeholder' => trans('tourSchedule.choose_revenue')
                                                        ]) !!}
                                                    </div>
                                                </th>
                                                <th colspan="4">
                                                    <div class="form-group">
                                                        {!! Form::submit(trans('admin.save'), [
                                                            'class' => 'btn btn-primary btn_save'
                                                        ]) !!}
                                                    </div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>{!! trans('tourSchedule.start_date') !!}</th>
                                                <th>{!! trans('tourSchedule.end_date') !!}</th>
                                                <th>{!! trans('tourSchedule.max_slot') !!}</th>
                                                <th>{!! trans('tourSchedule.revenue') !!}</th>
                                                <th>{!! trans('tourSchedule.available_slot') !!}</th>
                                                <th>{!! trans('tourSchedule.price') !!}</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="schedule-list"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
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
{!! Html::script('js/adminTourSchedule.js') !!}
<script type="text/javascript">
    $(document).ready(function () {
        var TourSchedule = new tourSchedule({
            url: {
                'ajaxList': '{!! route('admin.tourSchedule.ajax.list') !!}',
                'ajaxCreate': '{!! route('admin.tourSchedule.ajax.create') !!}',
                'ajaxUpdate': '{!! route('admin.tourSchedule.ajax.update') !!}',
                'ajaxDelete': '{!! route('admin.tourSchedule.ajax.delete') !!}',
                'ajaxTour': '{!! asset('admin/tour/ajax/show-with-schedule') !!}',
                'ajaxTourList': '{!! route('admin.tour.ajax.listOnly') !!}',
                'ajaxRevenueList': '{!! route('admin.revenue.ajax.listOnly') !!}',
            },
            lang: {
                'trans': {
                    'title_create': '{!! trans('tourSchedule.title_create') !!}',
                    'title_update': '{!! trans('tourSchedule.title_update') !!}',
                },
            },
            buttonSubmitText: {
                'create': '{!! trans('tourSchedule.create') !!}',
                'update': '{!! trans('tourSchedule.update') !!}',
            }
        });
    });
</script>
@endpush
