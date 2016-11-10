@extends('layouts.userMaster')

@section('style')
    @include('includes.userStyle')
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
        <div class="page-content col-sm-6">
            <div id="products" class="content-section">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1 class="section-title">{{ trans('label.our_tours') }}</h1>
                    </div> <!-- /.col-md-12 -->
                    @include('includes.tourListNoPaginate')
                </div> <!-- /.row -->
            </div>
        </div>
        <div class="top-right col-sm-3">
            @include('includes.tourTop')
        </div>
    </div>
@endsection
