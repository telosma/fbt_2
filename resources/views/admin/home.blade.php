@extends('layouts.adminMaster')

@section('page_title', trans('admin.title_home'))
@section('main_title', trans('admin.title_home'))

@include('includes.ajaxSendRequest')

@section('content')
<div class="panel panel-default">
    <div class="panel-body">
        <h3 class="body-title" style="">
            {!!
                trans('admin.monthly_revenue')
                    . ' '
                    . (Carbon\Carbon::now()->year - 1)
                    . ' - '
                    .  Carbon\Carbon::now()->year
            !!}
        </h3>
        <canvas id="monthly-revenue"></canvas>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <h3 class="body-title" style="">
            {!! trans('admin.annual_turnover') !!}
        </h3>
        <canvas id="annual-turnover"></canvas>
    </div>
</div>
@endsection

@push('scripts')
{!! Html::script('js/Chart.bundle.min.js') !!}
{!! Html::script('js/chartBase.js') !!}
<script>
    var MONTHS = {!! json_encode(trans('general.months')) !!};
    $(document).ready(function () {
        var MonthlyRevenue = new chartBase(
            '{!! route('admin.ajax.monthlyRevenue') !!}',
            'bar',
            $('#monthly-revenue'),
            '{!! trans('admin.revenue') !!}'
        );
        MonthlyRevenue.drawChart();
        var AnnualTurnover = new chartBase(
            '{!! route('admin.ajax.annualTurnover') !!}',
            'line',
            $('#annual-turnover'),
            '{!! trans('admin.revenue') !!}'
        );
        AnnualTurnover.drawChart();
    });
</script>
@endpush