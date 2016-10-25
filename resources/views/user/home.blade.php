@extends('layouts.userMaster')

@section('style')
    {!! Html::style('css/userStyle.css') !!}
    {!! Html::style('css/tourPreview.css') !!}
@endsection
@section('content')
    @include('includes.notification')
    @include('includes.error')
    <section class="page-content">
        <div id="products" class="content-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1 class="section-title">{{ trans('label.our_tours') }}</h1>
                    </div> <!-- /.col-md-12 -->
                </div> <!-- /.row -->
                <div class="row">
                    @for ($i = 0; $i < 8; $i++)
                        {!! view('includes.tourPreview') !!}
                    @endfor
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </div>
    </section>
    @include('includes.modalAuth')
@endsection
@section('script')
    {!! Html::script('js/userScript.js') !!}
@endsection
