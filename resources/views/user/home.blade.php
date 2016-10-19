@extends('layouts.userMaster')

@section('style')
    {!! Html::style('css/tour.css') !!}
@endsection
@section('content')
    @include('includes.notification')
    @include('includes.error')
    <section style="min-height: 500px;">
        @include('includes.listTour')
    </section>
@endsection
@section('script')
    {!! Html::script('js/userScript.js') !!}
@endsection
