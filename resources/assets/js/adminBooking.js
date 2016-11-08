/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* global SendRequest, DatatableBase, BOOKING */

function booking(option) {
    var current = this;
    this.table = null;
    this.request = null;
    this.type = 'd';
    this.lang = {
        'trans': {
            'confirm_reject': 'Do you want reject field?',
        },
        'button_text': {
            'reject': 'Reject',
        },
    };
    this.bookingStatus = {
        '0': 'new',
        '1': 'paid',
        '2': 'rejected',
    };
    this.bookingStatusHtml = {
        'new': '<span style="color: green">' + BOOKING.NEW + '</span>',
        'paid': '<span style="color: blue">' + BOOKING.PAID + '</span>',
        'rejected': '<span style="color: darkred">' + BOOKING.REJECTED + '</span>',
    };
    this.url = {
        'ajaxList': '',
        'ajaxDelete': '',
        'ajaxReject': '',
    };
    this.columns = [
        {'data': 'user.name'},
        {'data': 'tour_schedule.tour.name'},
        {'data': 'tour_schedule.tour.num_day'},
        {'data': 'tour_schedule.start'},
        {'data': 'tour_schedule.end'},
        {'data': 'num_humans'},
        {
            'data': function (data) {
                return data.tour_schedule.price * data.num_humans;
            },
        },
        {'data': 'created_at'},
        {
            'data': function (data) {
                return current.bookingStatusHtml[current.bookingStatus[data.status]];
            },
        },
    ];
    this.buttons = [
        {
            text: current.lang.button_text.reject,
            action: function () {
                var ids = [];
                DatatableBase.table
                    .rows({selected: true})
                    .data()
                    .each(function (group, i) {
                        ids.push(group.id);
                    });
                current.rejectById(ids);
            },
        },
    ];
    this.setUrl = function (url) {
        for (var key in this.url) {
            if (typeof url[key] !== 'undefined') {
                this.url[key] = url[key];
            }
        }
    };
    this.changeLang = function (lang) {
        for (var p_key in this.lang) {
            if (typeof lang[p_key] === 'undefined') {
                continue;
            }

            for (var c_key in this.lang[p_key]) {
                if (typeof lang[p_key][c_key] !== 'undefined') {
                    this.lang[p_key][c_key] = lang[p_key][c_key];
                }
            }
        }
    };
    this.init = function (options) {
        if (typeof options.url !== 'undefined') {
            this.setUrl(options.url);
        }

        if (typeof options.lang !== 'undefined') {
            this.changeLang(options.lang);
        }

        DatatableBase.order.column = 8;
        DatatableBase.order.type = 'desc';
        DatatableBase.addItem(this);
        this.addEvent();
    };
    this.addEvent = function () {
        DatatableBase.table.on('select.dt deselect.dt processing.dt', function () {
            current.enDisButton();
        });
    };
    this.enDisButton = function () {
        var selectedRows = DatatableBase.table.rows({selected: true}).count();
        if (selectedRows > 0) {
            DatatableBase.table.button(4).enable();
        } else {
            DatatableBase.table.button(4).disable();
        }
    };
    this.rejectById = function (id) {
        var r = confirm(current.lang.trans.confirm_reject);
        if (r) {
            SendRequest.send(current.url.ajaxReject, {'id': id}, 'post', DatatableBase.showMessage);
            DatatableBase.table.ajax.reload(null, false);
        }
    };
    this.init(option);

    return this;
}
