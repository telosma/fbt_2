@extends('layouts.userMaster')

@section('style')
    {!! Html::style('css/userStyle.css') !!}
    {!! Html::style('css/tourPreview.css') !!}
    {!! Html::style('css/tourMenu.css') !!}
@endsection
@section('content')
    <div class="row">
        @include('includes.notification')
        @include('includes.error')
        <div class="col-sm-3">
            <ul class="nav nav-pills nav-stacked" id="tour-menu">
                {!! $tourMenu !!}
            </ul>
        </div>
        <div class="page-content col-sm-8">
            <div id="products" class="content-section">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1 class="section-title">{{ trans('label.our_tours') }}</h1>
                    </div> <!-- /.col-md-12 -->
                    @if (count($tourSchedules))
                        @foreach ($tourSchedules as $tourSchedule)
                            @include('includes.tourPreview')
                        @endforeach
                    @else
                        <div class="alert alert-warning">
                            {{ trans('user.message.null_tour') }}
                        </div>
                    @endif
                </div> <!-- /.row -->
            </div>
        </div>
    </div>
@endsection
