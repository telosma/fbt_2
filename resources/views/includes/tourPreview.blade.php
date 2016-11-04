<div class="col-md-6 col-sm-6" class="product-board">
    <div class="product-item">
        <div class="item-thumb" style="background-image: url({{
            count($tourSchedule->tour->images) ?
                $tourSchedule->tour->images[0]->url :
                asset(config('upload.default_folder_path') . config('asset.default_tour'))
        }})">
            <div class="overlay">
                <div class="overlay-inner">
                    <a href="{{ route('getTour', $tourSchedule->tour->id) }}" class="view-detail">{{ trans('label.view_detail') }}</a>
                </div>
            </div> <!-- /.overlay -->
        </div> <!-- /.item-thumb -->
        <h3>{{ $tourSchedule->tour->name }}</h3>
        <span>
            {{ trans('label.price') }}
            @if ($tourSchedule->tour->price != $tourSchedule->price)
                <em class="text-muted price">{{ $tourSchedule->tour->price }}</em>
            @endif
            <em class="price sale-price">{{ $tourSchedule->price }}</em>
        </span>
    </div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
