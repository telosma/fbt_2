@push('scripts')
{!! Html::script('js/sendRequest.js') !!}
<script>
    var SendRequest = new sendRequest({
        'lang': {
            'unknown_error': '{!! trans('general.unknown_error') !!}',
            'comfirm_login': '{!! trans('general.comfirm_login') !!}',
        },
        'url': {
            'login': '',
        }
    });
</script>
@endpush
