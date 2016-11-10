$('.btn-book').on('click', function() {
    var url = $(this).data('urlAjaxGetSchedules');
    $('#schedule-select').children(':nth-child(n+2)').remove();
    $('#booking-modal').modal('show');
    $.ajax({
        url: url,
        method: 'POST',
        data: {
            tourId: $('#booking-form').find('input[name=tourId]').val()
        },
        success: function(msg) {
            var item = '';
            if (msg['status']) {
                if (msg['schedules'].length == 0) {
                    $('.warning-message').removeClass('hidden');
                } else {
                    $('.warning-message').addClass('hidden');
                    $.each(msg['schedules'], function(key, schedule) {
                        item += '<option value="' + schedule.id + '">'
                        item += messages.from + ' ' + schedule.start + ' ' + messages.to + ' ' + schedule.end;
                        item += ' ' + messages.available_slot + ' ' + schedule.available_slot;
                        item += '</option>';
                    });
                    $('#schedule-select').append(item);
                };
            } else {
                alert(msg['status']);
            }
        },
        error: function(xhr, ajaxOption, thrownerror) {
            location.reload();
        }
    });

    return false;
});
