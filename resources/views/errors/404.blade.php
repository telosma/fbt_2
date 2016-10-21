<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ trans('label.page_title') }}</title>
    {!! Html::style('css/notFound.css') !!}
</head>
<body>
    <div id="wrapper">
        <div class="notfound">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <p class="notice-miss">{!! trans('label.notice_miss') !!}</p>
                        <a class="btn-gohome" href="{{ route('home') }}">
                            {{ trans('label.brand') }}
                            <img src="{{ config('asset.btn_gohome') }}">
                        </a>
                    </div>
                    <div class="col-lg-3"></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
