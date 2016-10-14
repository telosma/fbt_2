@if (Session::has(config('common.flash_message'), config('common.flash_level_key')))
    <div class="alert alert-{!! Session::get(config('common.flash_level_key')) !!}">
        {!! Session::get(config('common.flash_message')) !!}
    </div>
@endif
