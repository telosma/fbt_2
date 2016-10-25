@if (Session::has(config('common.flash_notice'), config('common.flash_level_key')))
    <div class="notification {!! Session::get(config('common.flash_level_key')) !!}-notification">
        <div class="icon">
            <i class="fa fa-bell"></i>
        </div>
        <div class="text">
            {!! Session::get(config('common.flash_notice')) !!}
        </div>
    </div>
@endif
