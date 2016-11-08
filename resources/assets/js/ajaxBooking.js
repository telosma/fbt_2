$('#select-month').on('change', function() {
    var tourId = $(this).data('urlAjaxGetSchedules');
    var month = $(this).val();
    $('#schedule-select').find('option[name=scheduleId]').remove();
    $.ajax({
        url: tourId,
        method: 'POST',
        data: {
            month: month,
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
