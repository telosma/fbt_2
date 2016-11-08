@extends('layouts.adminMaster')

@section('page_title', trans('admin.list', ['name' => trans('admin.booking')]))

@section('main_title', trans('admin.list', ['name' => trans('admin.booking')]))

@section('content')
<table id="table" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th></th>
            <th>{!! trans('booking.user_name') !!}</th>
            <th>{!! trans('booking.tour_name') !!}</th>
            <th>{!! trans('booking.num_day') !!}</th>
            <th>{!! trans('booking.start_date') !!}</th>
            <th>{!! trans('booking.end_date') !!}</th>
            <th>{!! trans('booking.num_humans') !!}</th>
            <th>{!! trans('booking.total_price') !!}</th>
            <th>{!! trans('booking.created_at') !!}</th>
            <th>{!! trans('booking.status') !!}</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th></th>
            <th>{!! trans('booking.user_name') !!}</th>
            <th>{!! trans('booking.tour_name') !!}</th>
            <th>{!! trans('booking.num_day') !!}</th>
            <th>{!! trans('booking.start_date') !!}</th>
            <th>{!! trans('booking.end_date') !!}</th>
            <th>{!! trans('booking.num_humans') !!}</th>
            <th>{!! trans('booking.total_price') !!}</th>
            <th>{!! trans('booking.created_at') !!}</th>
            <th>{!! trans('booking.status') !!}</th>
            <th></th>
            <th></th>
        </tr>
    </tfoot>
</table>
@endsection

@include('includes.ajaxSendRequest')
@include('includes.datatableBase')

@push('scripts')
{!! Html::script('js/adminBooking.js') !!}
<script type="text/javascript">
    $(document).ready(function () {
        BOOKING = {
            NEW: '{!! trans('booking.new') !!}',
            PAID: '{!! trans('booking.paid') !!}',
            REJECTED: '{!! trans('booking.rejected') !!}',
        };
        var Booking = new booking({
            url: {
                'ajaxList': '{!! route('admin.booking.ajax.list') !!}',
                'ajaxDelete': '{!! route('admin.booking.ajax.delete') !!}',
                'ajaxReject': '{!! route('admin.booking.ajax.reject') !!}',
            },
            lang: {
                'trans': {
                    'confirm_reject': '{!! trans('booking.confirm_reject') !!}',
                },
                'button_text': {
                    'reject': '{!! trans('booking.reject') !!}'
                },
            }
        });
    });
</script>
@endpush
