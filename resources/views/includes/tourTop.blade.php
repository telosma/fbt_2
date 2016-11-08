<div class="tour-top row">
    <h3 class="p20">{{ trans('label.top_rate') }}</h3>
    @foreach($topTours as $tour)
        <div class="row single-box-tour">
            <div class="col-sm-6 col-sm-offset-2">
                @include('includes.rating', ['point' => ceil($tour->rate_average)])
            </div>
            <div class="box-tour-top col-sm-12">
                <a href="{{ route('getTour', $tour->id) }}">
                    <span class="top-name">{{ $tour->name }}</span>
                </a>
            </div>
        </div>
    @endforeach
</div>
