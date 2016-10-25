@push('scripts')
{!! Html::script('js/datatableBase.js') !!}
<script>
    var DatatableBase = new datatableBase({
        lang: {
            'trans': {
                'unknown_error': '{!! trans('dataTable.unknown_error') !!}',
                'confirm_select_all': '{!! trans('dataTable.confirm_select_all') !!}',
                'confirm_delete': '{!! trans('dataTable.confirm_delete') !!}',
            },
            'button_text': {
                'select_page': '{!! trans('dataTable.select_page') !!}',
                'select_all': '{!! trans('dataTable.select_all') !!}',
                'unselect': '{!! trans('dataTable.unselect') !!}',
                'delete_select': '{!! trans('dataTable.delete_select') !!}',
                'create': '{!! trans('dataTable.create') !!}',
            },
            'response': {
                'key_name': '{!! config('common.flash_level_key') !!}',
                'message_name': '{!! config('common.flash_message') !!}',
            },
        }
    });
</script>
@endpush
