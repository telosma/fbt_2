<span class="rating">
        @foreach (range(config('common.max_rate_point'), 1) as $i)
            <input
                type="radio"
                value="{!! $i !!}"
                class = "rating-input hide"
                {!! $i == $point ? 'checked="checked"' : '' !!}
                readonly
            ></input>
            <label class="rating-star-fixed"></label>
        @endforeach
</span>
