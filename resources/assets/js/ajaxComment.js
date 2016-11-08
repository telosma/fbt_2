var requestRunning = false;
$('#form-comment').submit(function() {
    var form = this;
    if ($(form).find('textarea[name=content]').val().trim() == '') {
        return false;
    }

    $(form).find('input[type=submit]').prop('disabled', true);
    $.ajax({
        url: $(form).prop('action'),
        method: 'POST',
        data: {
            reviewId: $(form).find('input[name=reviewId]').val(),
            content: $(form).find('textarea[name=content]').val()
        },
        success: function(msg) {
            if (msg['status']) {
                $('.list-comment').append(msg['htmlComents']);
                $(form)[0].reset();
            } else {
                alert(msg['message']);
            }
        },
        complete: function() {
            $(form).find('input[type=submit]').prop('disabled', false);
        },
        error: function(xhr, ajaxOption, thrownerror) {
            location.reload();
        }
    });

    return false;
});
$('.list-comment').on('click', '.item-comment .btn-delete-comment',function() {
    var del = this;
    if (requestRunning) {
        return;
    }

    requestRunning = true;
    var c = confirm($(del).data('message'));
    var commentId = $(del).parent().data('commentId');
    if (c) {
        $.ajax({
            url: $(del).data('urlDeleteComment'),
            method: 'POST',
            data: {
                _method: 'DELETE',
                commentId: commentId
            },
            success: function(msg) {
                if (msg['status']) {
                    $('#item-comment-' + commentId).remove();
                }
            },
            complete: function(data) {
                requestRunning = false;
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                location.reload();
            }
        });
    }

    requestRunning = false;
});
$('.list-comment').on('click', '.media-body .btn-edit-comment', function() {
    var commentId = $(this).parent().data('commentId');
    var currentBoxComment = $('#box-comment-content-' + commentId);
    var oldCommentContent = currentBoxComment.find('span').html().trim();
    var boxEditComment = '<div>'
    boxEditComment += '<div class="form-group ">';
    boxEditComment += '<textarea class="form-control" rows="3" name="content">';
    boxEditComment += oldCommentContent;
    boxEditComment += '</textarea>';
    boxEditComment += '</div>';
    boxEditComment += '<i class="submit-edit-comment hover">' + $(this).data('labelUpdate') + '</i>';
    boxEditComment += '<i class="cancel-edit-comment hover">' + $(this).data('labelCancel') + '</i>';
    boxEditComment += '</div>';
    // Hide current + add box edit
    currentBoxComment.addClass('hidden');
    currentBoxComment.parent().append(boxEditComment);
    // Handle event cancel update
    currentBoxComment.parent().on('click', '.cancel-edit-comment', function() {
        currentBoxComment.removeClass('hidden');
        $(this).parent().remove();
    });
    // Handle event update
    currentBoxComment.parent().on('click', '.submit-edit-comment', function() {
        var submitUpdateComment = this;
        newContent = $(submitUpdateComment).prev().find('textarea').val();
        if ((newContent.trim() == '') ||
            requestRunning ||
            newContent.trim() == oldCommentContent) {
            return;
        }

        requestRunning = true;
        $.ajax({
            url: $('.btn-edit-comment').data('urlUpdateComment'),
            method: 'POST',
            data: {
                _method: 'PUT',
                commentId: commentId,
                content: newContent
            },
            success: function(msg) {
                if (msg['status']) {
                    currentBoxComment.find('span').html(newContent);
                    $(submitUpdateComment).parent().remove();
                    currentBoxComment.removeClass('hidden');
                }
            },
            complete: function() {
                requestRunning = false;
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                location.reload();
            }
        });
    });

    requestRunning = false;
});
