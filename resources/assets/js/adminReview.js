/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* global SendRequest, DatatableBase */

function review(option) {
    var current = this;
    this.table = null;
    this.request = null;
    this.type = 'd';
    this.url = {
        'ajaxList': '',
        'ajaxDelete': '',
    };
    this.columns = [
        {'data': 'tour.name'},
        {'data': 'user.name'},
        {'data': 'short_content'},
        {'data': 'comments_count'},
        {'data': 'created_at'},
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

        DatatableBase.addItem(this);
        DatatableBase.order.column = 5;
        DatatableBase.order.type = 'desc';
    };
    this.init(option);

    return this;
}
