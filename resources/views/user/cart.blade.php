@extends('layouts.userMaster')

@section('content')
@include('includes.notification')
@include('includes.error')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3>
            {{ trans('label.booking_heading') }}
        </h3>
    </div>
    <div class="panel-body table-booking">
        @if (isset($bookings))
            <table class="table" table table-bordered>
                <tr>
                    <th>{{ trans('label.booking_request') }}</th>
                    <th>{{ trans('label.booked_at') }}</th>
                    <th>{{ trans('label.num_humans') }}</th>
                    <th>{{ trans('label.total_price') }}</th>
                    <th>{{ trans('label.status') }}</th>
                    <th></th>
                </tr>
                @if ($bookings['0'] != null)
                    @foreach ($bookings as $booking)
                        <tr id ="item-request-{{ $booking->id }}">
                            <td>
                                <a href="{{ route('getTour', $booking->tourSchedule->tour->id) }}">
                                    {{ $booking->tourSchedule->tour->name }}
                                </a>
                            </td>
                            <td>{{ $booking->created_at }}</td>
                            <td>{{ $booking->num_humans }}</td>
                            <td>
                                {{ trans('user.bill_cost', [
                                    'cost' => $booking->tourSchedule->price * $booking->num_humans,
                                ]) }}
                            </td>
                            @if ($booking->status == config('user.booking.new'))
                                <td>
                                    <button class="btn btn-info btn-get-checkout"
                                        data-booking-id="{{ $booking->id }}"
                                        data-cost="{{ $booking->tourSchedule->price * $booking->num_humans }}"
                                    >
                                        {{ trans('user.action.checkout') }}
                                    </button>
                                </td>
                                <td>
                                    <button class="cancel-booking btn btn-info"
                                        data-booking-id="{{ $booking->id }}"
                                        data-url-cancel-booking="{{ route('postCancelBooking') }}"
                                        data-message-confirm="{{ trans('user.message.confirm_cancel_booking') }}"
                                    >
                                        {{ trans('user.action.cancel') }}
                                    </button>
                                </td>
                            @elseif ($booking->status == config('user.booking.paid'))
                                <td>
                                    {{ trans('label.paid') }}
                                </td>
                                <td></td>
                            @elseif ($booking->status == config('user.booking.rejected'))
                                <td>
                                    {{ trans('label.deny') }}
                                </td>
                                <td></td>
                            @endif
                        </tr>
                    @endforeach
                @else
                    <div class="alert alert-info">
                        {{ trans('user.message.null_booking') }}
                    </div>
                @endif
            </table>
            <div>{{ $bookings->links() }}</div>
        @else
            <div class="alert alert-warning">
                {{ trans('user.message.wrong') }}
            </div>
        @endif
        <div class="modal fade" id="modal-payment-account" role="dialog">
            <div class="modal-dialog">
          <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3>{{ trans('user.message.info_bank_account') }}</h3>
                    </div>
                    {{ Form::open(['route' => 'user.checkout', 'method' => 'POST', 'id' => 'payment-form']) }}
                        @if (!empty($bankAccounts))
                            <div class="modal-body">
                                <div class="form-group">
                                    {{ Form::label('bankAccountId', trans('label.select_account'), [
                                        'class' => 'control-label',
                                    ]) }}
                                    {{ Form::select('bankAccountId', $bankAccounts, null, [
                                        'id' => 'account-number',
                                        'class' => 'form-control',
                                        'data-stripe' => 'number',
                                        'placeholder' => trans('label.choose_bank_account'),
                                    ]) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('code', trans('label.card_verification')) }}
                                    {{ Form::text('code', null, [
                                        'class' => 'form-control',
                                        'data-stripe' => 'exp_cvc',
                                        'id' => 'exp-cvc',
                                    ]) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('month', trans('label.expiration_month')) }}
                                    {{ Form::selectMonth('month', null, [
                                        'class' => 'form-control',
                                        'data-stripe' => 'exp_month',
                                        'id' => 'exp-month',
                                    ]) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('year', trans('label.expiration_year')) }}
                                    {{ Form::text('year', null, [
                                        'class' => 'form-control',
                                        'data-stripe' => 'exp_year',
                                        'id' => 'exp-year',
                                    ]) }}
                                </div>
                                {{ Form::hidden('bookingId', null, ['id' => 'modal-booking-id']) }}
                                {{ Form::hidden('cost', null, ['id' => 'modal-cost']) }}
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="pull-left">{{ trans('user.message.or_new_bank') }}</a>
                                {{ Form::submit(trans('user.action.checkout'), [
                                    'class' => 'btn btn-info btn-submit-payment',
                                ]) }}
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    {{ trans('label.close') }}
                                </button>
                            </div>
                        @else
                            <div class="modal-body">
                                <a class="btn btn-info" href="{{ route('getProfile') }}">{{ trans('user.message.new_bank_account') }}</a>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    {{ trans('label.close') }}
                                </button>
                            </div>
                        @endif
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    var stripePublishKey = '{{ env('STRIPE_KEY_PUBLISH') }}';
</script>
{{ Html::script('js/bookingCart.js') }}
@endsection
