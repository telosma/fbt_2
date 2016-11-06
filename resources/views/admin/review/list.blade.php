@extends('layouts.adminMaster')

@section('page_title', trans('admin.list', ['name' => trans('admin.review')]))

@section('main_title', trans('admin.list', ['name' => trans('admin.review')]))

@section('content')
<table id="table" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th></th>
            <th>{!! trans('review.tour') !!}</th>
            <th>{!! trans('review.user') !!}</th>
            <th>{!! trans('review.content') !!}</th>
            <th>{!! trans('review.comments_count') !!}</th>
            <th>{!! trans('review.created_at') !!}</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th></th>
            <th>{!! trans('review.tour') !!}</th>
            <th>{!! trans('review.user') !!}</th>
            <th>{!! trans('review.content') !!}</th>
            <th>{!! trans('review.comments_count') !!}</th>
            <th>{!! trans('review.created_at') !!}</th>
            <th></th>
            <th></th>
        </tr>
    </tfoot>
</table>
@endsection

@include('includes.ajaxSendRequest')
@include('includes.datatableBase')

@push('scripts')
{!! Html::script('js/adminReview.js') !!}
<script type="text/javascript">
    $(document).ready(function () {
        var Review = new review({
            url: {
                'ajaxList': '{!! route('admin.review.ajax.list') !!}',
                'ajaxDelete': '{!! route('admin.review.ajax.delete') !!}',
            },
        });
    });
</script>
@endpush
