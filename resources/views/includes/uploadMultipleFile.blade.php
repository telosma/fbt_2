@push('styles')
{!! Html::style('css/uploadImage.css') !!}
@endpush

@push('scripts')
{!! Html::Script('js/uploadMultipleFile.js') !!}
<script>
    var UploadMultipleFile = new uploadMultipleFile({
        'url': {
            'upload': '{!! route('upload.image') !!}',
            'login': '',
        },
        'lang': {
            'unknown_error': '{!! trans('general.unknown_error') !!}',
            'comfirm_login': '{!! trans('general.comfirm_login') !!}',
            'add': '{!! trans('upload.add') !!}',
            'removeAll': '{!! trans('upload.remove_all') !!}',
            'upload': '{!! trans('upload.upload') !!}',
            'stop': '{!! trans('upload.stop') !!}',
            'finish': '{!! trans('upload.finish') !!}',
            'stop_upload': '{!! trans('upload.stop_upload') !!}',
            'file_big': '{!! trans('upload.file_big') !!}',
        },
        'maxSize': {!! config('upload.image_upload.max_size') !!},
    });
</script>
@endpush
