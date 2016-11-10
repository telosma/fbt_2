@extends('layouts.userMaster')

@section('style')
    {!! Html::style('css/tourShow.css') !!}
    {!! Html::style('css/animate.min.css') !!}
@endsection

@push('header')
    @include('includes.CKeditorScript')
@endpush

@section('content')
    @include('includes.notification')
    @include('includes.error')
    <section class="page-content">
        <div class="tour-banner">
            <div class="detail-banner" style="background-image: url('{{
                isset($tour->images[0]) ?
                    $tour->images[0]->url :
                    asset(config('upload.default_folder_path') . config('asset.default_tour'))
            }}')">
                <div class="container">
                    <div class="detail-banner-left">
                        <h2 class="detail-title">
                            {{ $tour->name }}
                        </h2>
                        <div class="detail-banner-price">
                            <span>
                                <em class="sale-price">{{ trans('tour.sale_price', ['price' => $tour->price]) }}</em>
                            </span>
                        </div>
                        <div class="detail-banner-rating">
                            @include('includes.rating', ['point' => ceil($tour->rate_average)])
                            @if ($tour->rates_count)
                                <span class="detail-num-rating">
                                    {{ trans('label.review.rate_from', ['num' => $tour->rates_count]) }}
                                     <i class="fa fa-user"></i>
                                </span>
                            @endif
                            <div id="rate-tour-block" class="input-rating" style="display: none">
                                <span class="your-rate">{!! trans('user.your_rate') !!}</span>
                                <span class="rating">
                                    {!! Form::hidden('tour_id', $tour->id) !!}
                                    @foreach (range(config('common.max_rate_point'), 1) as $i)
                                        {!! Form::radio('rating_tour', $i, false, [
                                            'id' => 'rating-tour-' . $i,
                                            'class' => 'rating-input',
                                        ]) !!}
                                        {!! Form::label('rating-tour-' . $i, ' ', ['class' => 'rating-star']) !!}
                                    @endforeach
                                </span>
                            </div>
                        </div>
                        <div class="detail-banner-btn write">
                            <i class="fa fa-pencil"></i>
                            <a href="#section-write-review">{{ trans('user.action.write_review') }}</a>
                        </div>
                        <div class="detail-banner-btn" id="rate-tour">
                            {{ trans('user.action.rate_this_tour') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row detail-content">
                <h2>{{ trans('label.destination') }}</h2>
                <div class="col-sm-12">
                    <div class="detail-banner-address bg-white p20">
                        @foreach($tour->places as $key => $place)
                            <i class="fa fa-map-marker"></i>
                            <a href="{{ route('getTourByPlace', $place->id) }}">{{ $place->name }}</a>
                            @if (($key+1) != count($tour->places))
                                <i class="fa fa-long-arrow-right"></i>
                            @endif
                        @endforeach
                    </div>
                    <h2>{{ trans('label.image_overview') }}</h2>
                </div>
                <div class="col-sm-7">
                    @if(empty($tour->images->toArray()))
                        <div class="alert alert-info">
                            {{ trans('tour.null_preview_image') }}
                        </div>
                    @else
                        <div class="detail-gallery">
                            <div class="row">
                                <!-- Carousel -->
                                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                    <!-- Indicators -->
                                    <ol class="carousel-indicators">
                                        @foreach($tour->images as $key => $image)
                                            @if ($key == 0)
                                                <li data-target="#carousel-example-generic" data-slide-to="{{ $key }}" class="active"></li>
                                            @else
                                                <li data-target="#carousel-example-generic" data-slide-to="{{ $key }}"></li>
                                            @endif
                                        @endforeach
                                    </ol>
                                    <div class="carousel-inner">
                                        @foreach($tour->images as $key => $image)
                                            <div class="item{{ $key == 0 ? ' active' : '' }}">
                                                <img src="{{ $image->url }}">
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- Controls -->
                                    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left"></span>
                                    </a>
                                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                    </a>
                                </div><!-- /carousel -->
                            </div>
                        </div>
                    @endif
                    <h2>{{ trans('label.description') }}</h2>
                    <div class="bg-white p20">
                        <div class="detail-description">
                            <p>
                                {!! $tour->description !!}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="bg-white p20">
                        <div class="detail-overview-review">
                            {{ trans('label.review.num_review', ['num' => $tour->reviews_count]) }}
                        </div>
                        <div class="detail-action row">
                            <div class="col-sm-4">
                                <div class="btn btn-book"
                                    data-url-ajax-get-schedules="{{ route('ajaxGetSchedules') }}">
                                    <i class="fa fa-shopping-cart"></i>
                                    {{ trans('label.choose_schedule') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <h2>{{ trans('label.all_review') }}</h2>
                    <div class="reviews">
                        @foreach ($reviews as $review)
                            <div class="review">
                                <div class="user-review-image cusor-pointer" data-toggle="tooltip" title="{{ $review->user->name }}">
                                    <a href="#">
                                        <img class="circle" src="{{ $review->user->avatar_link }}" alt="">
                                    </a>
                                </div>
                                <div class="review-inner">
                                    <div class="review-title">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>{{ trans('label.review.write_at', ['time' => $review->created_at]) }}</p>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="review-total-like">
                                                    {{ count($review->likes) }} <i class="fa fa-heart heart"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="review-wrapper-content">
                                        <div class="review-content">
                                            {!! str_limit($review->text_preview, config('common.limit.text_preview')) !!}
                                            <a href="{{ route('review.show', $review->id) }}">{{ trans('user.message.continue_reading') }}</a>
                                        </div>
                                        <div class="review-rating">
                                            <dl>
                                                <dt>{{ trans('label.review.food') }}</dt>
                                                <dd>
                                                    @include('includes.rating', ['point' => $review->rated_food])
                                                </dd>
                                                <dt>{{ trans('label.review.place') }}</dt>
                                                <dd>
                                                    @include('includes.rating', ['point' => $review->rated_place])
                                                </dd>
                                                <dt>{{ trans('label.review.serivce') }}</dt>
                                                <dd>
                                                    @include('includes.rating', ['point' => $review->rated_service])
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div> <!-- /review-inner -->
                            </div> <!-- /review -->
                        @endforeach
                        <span class="clear-fixed">{!! $reviews->links() !!}</span>
                    </div> <!-- reviews -->
                </div>
                <div class="col-sm-12" id="section-write-review">
                    <h2>{{ trans('label.review.submit') }}</h2>
                    {{ Form::open(['route' => 'postCreateReview',
                        'method' => 'post',
                        'class' => 'bg-white p20 add-review'
                    ]) }}
                        <div class="row">
                            <div class="form-group input-rating col-sm-3 col-sm-offset-2">
                                <div class="rating-title">
                                    {{ trans('label.review.food') }}
                                </div>
                                <span class="rating">
                                    @foreach (range(config('common.max_rate_point'), 1) as $i)
                                        {!! Form::radio('food', $i, false, [
                                            'id' => 'rating-food-' . $i,
                                            'class' => 'rating-input',
                                        ]) !!}
                                        {!! Form::label('rating-food-' . $i, ' ', ['class' => 'rating-star']) !!}
                                    @endforeach
                                </span>
                            </div>
                            <div class="form-group input-rating col-sm-3">
                                <div class="rating-title">
                                    {{ trans('label.review.place') }}
                                </div>
                                <span class="rating">
                                    @foreach (range(config('common.max_rate_point'), 1) as $i)
                                        {!! Form::radio('place', $i, false, [
                                            'id' => 'rating-place-' . $i,
                                            'class' => 'rating-input',
                                        ]) !!}
                                        {!! Form::label('rating-place-' . $i, ' ', ['class' => 'rating-star']) !!}
                                    @endforeach
                                </span>
                            </div>
                            <div class="form-group input-rating col-sm-3">
                                <div class="rating-title">
                                    {{ trans('label.review.serivce') }}
                                </div>
                                <span class="rating">
                                    @foreach (range(config('common.max_rate_point'), 1) as $i)
                                        {!! Form::radio('serivce', $i, false, [
                                            'id' => 'rating-service-' . $i,
                                            'class' => 'rating-input',
                                        ]) !!}
                                        {!! Form::label('rating-service-' . $i, ' ', ['class' => 'rating-star']) !!}
                                    @endforeach
                                </span>
                            </div>
                            <div class="col-sm-8 col-sm-offset-2">
                                {!! Form::textarea('content', null, [
                                    'id' => 'rv-content',
                                    'rows' => config('common.textarea.rows'),
                                    'cols' => config('common.textarea.cols'),
                                ]) !!}
                            </div>
                            {!! Form::hidden('tourId', $tour->id) !!}
                            <div class="col-sm-8 col-sm-offset-2">
                                @if (Auth::check())
                                    {!! Form::submit('Submit Review', ['class' => 'btn btn-info']) !!}
                                @else
                                    <a class="btn btn-info" data-toggle="modal" data-target="#login-modal">
                                        {{ trans('user.message.to_submit_review') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
    @include('includes.modalBooking')
@endsection
@section('script')
    <script type="text/javascript">
        var messages = {
            to: '{{ trans('user.message.to') }}',
            from: '{{ trans('user.message.from') }}',
            available_slot: '{{ trans('user.message.available_slot') }}'
        }
    </script>
    {{ Html::script('js/ajaxBooking.js') }}
    <script type="text/javascript">
        CKEDITOR.replace('rv-content');
        RATEURL = '{!! route('user.rateTour') !!}';
        LANG = {
            CONFIRM_LOGIN: '{!! trans('user.message.auth_require') !!}',
            ERROR: '{!! trans('user.message.error') !!}',
        };
        RESULT = {
            STATUS: '{!! config('common.flash_level_key') !!}',
            MESSAGE: '{!! config('common.flash_notice') !!}'
        };

    </script>
    {!! Html::script('js/jquery.noty.packaged.min.js') !!}
    {!! Html::script('js/userRateTour.js') !!}
@endsection
