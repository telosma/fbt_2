@extends('layouts.userMaster')

@section('style')
    {!! Html::style('css/userStyle.css') !!}
    {!! Html::style('css/tourShow.css') !!}
    {!! Html::style('css/reviewShow.css') !!}
@endsection
@section('content')
    @include('includes.error')
    @include('includes.notification')
    <div class="page-content container p20">
        <div class="detail-content row">
            <div class="col-sm-9 col-xs-9">
                <div class="review-show">
                    <div class="rv-header p20 row">
                        <div class="col-sm-4">
                            <figure class="tour-img">
                                <img src="{{
                                        count($review->tour->images) ?
                                        $review->tour->images[0]->url :
                                        asset(config('upload.default_folder_path') . config('asset.default_tour'))
                                    }}"
                                    width="200" height="200"
                                >
                            </figure>
                        </div>
                        <div class="col-sm-8">
                            <div class="row bg-white">
                                <div class="banner-review-name col-sm-12 border-bottom bottom-20">
                                    <h3>{{ $review->tour->name }}</h3>
                                </div>
                                <div class="banner-review-by col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            @include('includes.rating', ['point' => $review->tour->rate_average])
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="user-review-info pull-left">
                                                <a href="#" class="cusor-pointer">
                                                    <img src="{{ $review->user->avatar_link }}" class="circle small">
                                                    <span class="name">
                                                        {{ $review->user->name }}
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rv-content bg-white p20">
                        <div class="row border-bottom bottom-50">
                            <div class="review-rate">
                                <div class="col-sm-3">
                                    <p>{{ trans('label.review.food') }}</p>
                                    @include('includes.rating', ['point' => $review->rated_food])
                                </div>
                                <div class="col-sm-3">
                                    <p>{{ trans('label.review.place') }}</p>
                                    @include('includes.rating', ['point' => $review->rated_place])
                                </div>
                                <div class="col-sm-3">
                                    <p>{{ trans('label.review.serivce') }}</p>
                                    @include('includes.rating', ['point' => $review->rated_service])
                                </div>
                            </div>
                        </div>
                        <div class="content">
                            {!! $review->content !!}
                        </div>
                    </div>
                </div>
                <div class="like-banner">
                    <div class="row">
                        <i class="fa fa-heart-o heart fa-2x cusor-pointer"
                            id="icon-like"
                            data-toggle="tool-tip"
                            title="{{ trans('label.like') }}">
                        </i>
                        <span class="num-like">
                            {{ $review->likes_count }} <i class="fa fa-heart heart"></i>
                        </span>
                    </div>
                </div>
                <div class="comment-wrapper">
                    {{-- List comment --}}
                    <div class="list-comment">
                        @foreach ($comments as $comment)
                            @include('includes.comment')
                        @endforeach
                        <div>{{ $comments->links() }}</div>
                    </div>
                    @if (Auth::check())
                        <div class="add-comment">
                            {{-- form comment --}}
                            <div class="well">
                                {!! Form::open([
                                    'route' => 'comments.store',
                                    'method' => 'POST',
                                    'role' => 'form',
                                    'id' => 'form-comment',
                                ]) !!}
                                    <div class="form-group">
                                        {!! Form::textarea('content', null, [
                                            'class' => 'form-control',
                                            'rows' => '3',
                                        ]) !!}
                                    </div>
                                    {!! Form::hidden('reviewId', $review->id) !!}
                                    {!! Form::hidden('urlPostCreateComment', route('comments.store')) !!}
                                    {!! Form::submit(trans('user.action.comment'), ['class' => 'btn btn-info']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    @else
                        <a data-toggle="modal" data-target="#login-modal" class="cusor-pointer">
                            {{ trans('user.message.login_add_comment') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {!! Html::script('js/ajaxComment.js') !!}
@endsection
