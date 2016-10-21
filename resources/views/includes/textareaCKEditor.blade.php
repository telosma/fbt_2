<textarea name="{!! $editorName or 'editor' !!}"
    id="{!! $editorName or 'editor' !!}"
    rows="{!! $editorRows or config('common.textarea.rows') !!}"
    cols="{!! $editorCols or config('common.textarea.cols') !!}"
></textarea>
<script>
    CKEDITOR.replace('{!! $editorName or 'editor' !!}');
</script>
