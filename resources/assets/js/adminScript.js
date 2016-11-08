/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
function drawCategoryList(categories, categoryParentId, pre) {
    var response = '';
    if (typeof categoryParentId === 'undefined') {
        categoryParentId = null;
    }
    if (typeof pre === 'undefined') {
        pre = '';
    }
    $.each(categories, function (key, category) {
        if (category.parent_id === categoryParentId) {
            var drawChil = drawCategoryList(categories, category.id, pre + '- ');
            response += '<option value="' + category.id + '">' + pre + category.name + '</option>';
            response += drawChil;
        }
    });
    return response;
}
$(document).ready(function () {
    $('#side-menu').metisMenu();
    $('.alert').delay(3000).slideUp();
    var url = window.location;
    $('ul.nav a').filter(function () {
        return this.href === url.href;
    }).addClass('active').closest('ul').addClass('in');
});
var addNewImage = function (input, img) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(img).attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
};
String.prototype.trunc = function (n, useWordBoundary) {
    var isTooLong = this.length > n,
        s_ = isTooLong ? this.substr(0, n - 1) : this;
    s_ = (useWordBoundary && isTooLong) ? s_.substr(0, s_.lastIndexOf(' ')) : s_;
    return isTooLong ? s_ + '&hellip;' : s_;
};
var randomScalingFactor = function () {
    return Math.round(Math.random() * 100);
};
var randomColorFactor = function () {
    return Math.round(Math.random() * 255);
};
var randomColor = function () {
    return 'rgba('
        + randomColorFactor()
        + ','
        + randomColorFactor()
        + ','
        + randomColorFactor()
        + ', 0.7)';
};
