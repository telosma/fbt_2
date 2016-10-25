/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* global SendRequest, DatatableBase */

function category(option) {
    var current = this;
    this.table = null;
    this.request = null;
    this.type = 'cde';
    this.lang = {
        'trans': {
            'title_create': 'Create new category',
            'title_update': 'Update category',
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
        {'data': 'name'},
        {'defaultContent': 'NULL'},
        {'data': 'tours_count'},
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
        this.addEvent();
    };
    this.addEvent = function () {
        //show parent
        DatatableBase.table.on('draw.dt', function () {
            DatatableBase.table.column(2).nodes().to$().each(function (index, cell) {
                var tr = $(cell).closest('tr');
                var row = DatatableBase.table.row(tr);
                var rowData = row.data();
                $.each(DatatableBase.table.data(), function (index, value) {
                    if (value.id === rowData.parent_id) {
                        $(cell).html(value.name);
                    }
                });
            });
        });
    };
    this.loadCategory = function () {
        SendRequest.send(current.url.ajaxListOnly, current.request, 'get', function (response) {
            if (response.status === 200) {
                $('#parent_id').children(':nth-child(n+2)').remove();
                $('#parent_id').append(drawCategoryList(response.responseJSON.data));
            } else {
                alert(current.lang.trans.load_categories_error + response.status);
            }
        });
    };
    this.showFormUpdate = function (rData) {
        current.loadCategory();
        $('option').prop('selected', false);
        $('option').prop('disabled', false);
        $('option[value="' + rData.parent_id + '"]').prop('selected', true);
        $('option[value="' + rData.id + '"]').prop('disabled', true);
        $('input[name=id]').val(rData.id);
        $('#name').val(rData.name);
    };
    this.showFormCreate = function (){
        this.loadCategory();
        $('option').prop('selected', false);
        $('option').prop('disabled', false);
    };
    this.init(option);

    return this;
}
