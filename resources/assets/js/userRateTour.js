/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* global RATEURL, LANG, RESULT */

function message(text, type, timeout) {
    noty({
        text: text,
        type: type,
        theme: 'relax',
        layout: 'topRight',
        timeout: typeof timeout === 'Number' ? timeout : 5000,
        dismissQueue: true,
        maxVisible: 10,
        animation: {
            layout: 'topRight',
            open: 'animated bounceInRight',
            close: 'animated bounceOutRight',
            easing: 'swing',
            speed: 1000,
        }
    });
}

$(document).ready(function () {
    $('#rate-tour').on('click', function () {
        $('#rate-tour-block').toggle();
    });
    var action = false;
    $('input[name=rating_tour]').on('change', function () {
        var value = $(this).val();
        var tourId = $('input[name=tour_id]').val();
        console.log($(this).val());
        if (action) {
            return false;
        }
        action = true;
        $.ajax({
            url: RATEURL,
            method: 'POST',
            data: {
                point: value,
                tour_id: tourId,
            },
            complete: function (data) {
                $.each(data, function (i, v) {
                    console.log(i);
                    console.log(v);
                });
                action = false;
                switch (data.status) {
                    case 200:
                        var result = data.responseJSON;
                        message(result[RESULT.MESSAGE], result[RESULT.STATUS]);
                        break;
                    case 401:
                        message(LANG.CONFIRM_LOGIN, 'error');
                        break;
                    case 422:
                        var i = 0;
                        $.each(data.responseJSON, function (key, val) {
                            var error = '';
                            $('[name=' + key + ']').closest('.form-group').addClass('has-error');
                            $.each(val, function (k, v) {
                                error += v + '</br>';
                            });
                            setTimeout(function () {
                                message(error, 'error');
                            }, i * 1000);
                            i++;
                        });
                        break;
                    default :
                        message(LANG.ERROR + ': ' + data.status, 'error');
                        setTimeout(function () {
                            window.location.reload(1);
                        }, 2000);
                }
            },
        });
    });
});
