<div class="modal fade" id="booking-modal" role="dialog">
    <div class="modal-dialog">
  <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3>{{ trans('label.modal_booking') }}</h3>
            </div>
            {{ Form::open(['route' => 'postBookTour', 'method' => 'POST', 'id' => 'booking-form']) }}
                @if (count($tour->tourSchedules))
                    <div class="modal-body">
                        <div class="form-group">
                            {{ Form::label('month', trans('user.message.select_month')) }}
                            {{ Form::selectMonth('month', null, [
                                'class' => 'form-control',
                                'id' => 'select-month',
                                'data-url-ajax-get-schedules' => route('ajaxGetSchedules'),
                                'placeholder' => trans('user.message.month'),
                            ]) }}
                        </div>
                        <div class="alert alert-warning hidden warning-message">
                            {{ trans('user.message.noScheduleAvailable') }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('scheduleId', trans('user.message.select_schedule'), [
                                'class' => 'control-label',
                            ]) }}
                            {{ Form::select('scheduleId', [], null, [
                                'id' => 'schedule-select',
                                'class' => 'form-control',
                                'placeholder' => trans('user.message.select_schedule'),
                            ]) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('numHuman', trans('user.message.num_human')) }}
                            {{ Form::text('numHuman', null, [
                                'class' => 'form-control',
                                'placeholder' => trans('user.message.num_slot'),
                            ]) }}
                        </div>
                        {{ Form::hidden('tourId', $tour->id) }}
                    </div>
                    <div class="modal-footer">
                        {{ Form::submit(trans('user.action.book'), [
                            'class' => 'btn btn-info btn-submit-book',
                        ]) }}
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            {{ trans('label.close') }}
                        </button>
                    </div>
                @else
                    <div class="modal-body">
                        {{ trans('user.message.noavailable_schedule') }}
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
