$(document).ready(function() {
    $('.notification').delay(4000).fadeOut();
    $('.notification').on({
        mouseover: function() {
            $('.notification').stop(true, true);
        } ,
        mouseout: function() {
            $('.notification').delay(1000).fadeOut();
        }
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});
