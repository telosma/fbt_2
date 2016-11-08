/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* global SendRequest, DatatableBase */

function revenue(option) {
    var current = this;
    this.table = null;
    this.request = null;
    this.type = 'cde';
    this.lang = {
        'trans': {
            'title_create': 'Create new revenue',
            'title_update': 'Update revenue',
        },
    };
    this.url = {
        'ajaxList': '',
        'ajaxCreate': '',
        'ajaxUpdate': '',
        'ajaxDelete': '',
        'ajaxListOnly': '',
    };
    this.columns = [
        {'data': 'value'},
        {'data': 'tour_schedules_count'},
    ];
    this.buttons = [];
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

        DatatableBase.order.column = 2;
        DatatableBase.order.type = 'desc';
        DatatableBase.addItem(this);
    };
    this.showFormUpdate = function (rData) {
        $('input[name=id]').val(rData.id);
        $('input[name=value]').val(rData.value);
    };
    this.init(option);

    return this;
}
