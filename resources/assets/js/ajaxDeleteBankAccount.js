var deleteBankAccountRunning = false;
$('.box-bank-account').on('click', '.del-bank-account', function() {
    if (deleteBankAccountRunning) {
        return;
    }

    deleteBankAccountRunning = true;
    var confirmDelete = confirm($(this).data('message'));
    var currentElement = this;
    if(confirmDelete) {
        $.ajax({
            url: $(currentElement).data('urlDeleteBank'),
            method: 'POST',
            data: {
                _method: 'DELETE'
            },
            success: function(msg) {
                if (msg['status']) {
                    $('#bank-account-' + $(currentElement).data('id')).remove();
                }
            },
            complete: function() {
                deleteBankAccountRunning = false;
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                alert(xhr.status);
                location.reload();
            }
        });
    }

    deleteBankAccountRunning = false;
});
