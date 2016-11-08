$(document).ready(function() {
    var cancelBookingRunning = false;
    $('.cancel-booking').on('click', function(e) {
        var cf = confirm($(this).data('messageConfirm'));
        if (cf == true) {
            if (cancelBookingRunning) {
                return;
            }

            cancelBookingRunning = true;
            var bookingId = $(this).data('bookingId');
            $.ajax({
                url: $(this).data('urlCancelBooking'),
                method: 'POST',
                data: {
                    bookingId: bookingId
                },
                success: function(msg) {
                    if (msg['err']) {
                        confirm(msg['err']);
                    } else {
                        confirm(msg['success']);
                        $('#item-request-' + bookingId).remove();
                    }
                },
                complete: function() {
                    cancelBookingRunning = false;
                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    alert(xhr.status);
                }
            });
        }
    });
    $('.btn-get-checkout').on('click', function() {
        $('#modal-booking-id').val($(this).data('bookingId'));
        $('#modal-cost').val($(this).data('cost'));
        $('#modal-payment-account').modal('show');
    });
    Stripe.setPublishableKey(stripePublishKey);
    var $form = $('#payment-form');
    $form.submit(function(event) {
        $form.find('input[type="submit"]').prop('disabled', true);
        Stripe.card.createToken({
            number: $('#account-number option:selected').html(),
            exp_month: $('#exp-month').val(),
            exp_year: $('#exp-year').val(),
            cvc: $('#cvc').val()
        }, stripeResponseHandler);

        return false;
    });

    function stripeResponseHandler(status, response) {
        if (response.error) {
            $form.find('input[type="submit"]').prop('disabled', false);
            alert(response.error.message);
        } else {
            var token = response.id;
            $form.append($('<input type="hidden" name="stripeToken">').val(token));
            $form.get(0).submit();
        }
    }
});
