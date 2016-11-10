@forelse ($tours as $tour)
    <div class="col-md-6 col-sm-6" class="product-board">
        <div class="product-item">
            <div class="item-thumb" style="background-image: url({{
                count($tour->images) ?
                    $tour->images[0]->url :
                    asset(config('upload.default_folder_path') . config('asset.default_tour'))
            }})">
                <div class="overlay">
                    <div class="overlay-inner">
                        <a href="{{ route('getTour', $tour->id) }}"
                            class="view-detail">{{ trans('label.view_detail') }}
                        </a>
                    </div>
                </div> <!-- /.overlay -->
            </div> <!-- /.item-thumb -->
            <h3>{{ $tour->name }}</h3>
            <span>
                {{ trans('label.price') }}
                <em class="price sale-price">{{ $tour->price }}</em>
            </span>
        </div> <!-- /.product-item -->
    </div>
@empty
    <div class="alert alert-warning">
        {{ trans('user.message.null_tour') }}
    </div>
@endforelse
