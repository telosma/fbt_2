/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* global SendRequest */
function datatableBase(option) {
    var current = this;
    this.item;
    this.columns = [];
    this.table;
    this.request;
    this.lang = {
        'trans': {
            'unknown_error': 'Unknown error! code: ',
            'confirm_select_all': 'Do you want select all field?',
            'confirm_delete': 'Do you want delete field?',
        },
        'button_text': {
            'select_page': 'Select current page',
            'select_all': 'Select all',
            'unselect': 'Unselect',
            'delete_select': 'Delete',
            'create': 'Create'
        },
        'response': {
            'key_name': 'key',
            'message_name': 'message',
        }
    };
    this.url = {
        'ajaxList': '',
        'ajaxCreate': '',
        'ajaxUpdate': '',
        'ajaxDelete': '',
    };
    this.columnIndex = {
        'searchable': false,
        'orderable': false,
        'defaultContent': '',
    };
    this.baseColumns = {
        'edit': {
            'orderable': false,
            'searchable': false,
            'className': 'edit center',
            'defaultContent': '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>'
        },
        'delete': {
            'orderable': false,
            'searchable': false,
            'className': 'delete center',
            'defaultContent': '<i class="fa fa-times" aria-hidden="true"></i>'
        },
        'select': {
            'orderable': false,
            'searchable': false,
            'className': 'select-checkbox center',
            'defaultContent': ' '
        },
    };
    this.createButton = {
        text: current.lang.button_text.create,
        action: function () {
            current.showFormCreate();
        },
    };
    this.buttons = [
        {
            text: current.lang.button_text.select_page,
            action: function () {
                current.table.rows().deselect();
                current.table.rows({page: 'current'}).select();
            }
        },
        {
            text: current.lang.button_text.select_all,
            action: function () {
                var r = confirm(current.lang.trans.confirm_select_all);
                if (r) {
                    current.table.rows().select();
                }
            }
        },
        {
            text: current.lang.button_text.unselect,
            action: function () {
                current.table.rows().deselect();
            },
            enabled: false
        },
        {
            text: this.lang.button_text.delete_select,
            action: function () {
                var id = [];
                current.table
                    .rows({selected: true})
                    .data()
                    .each(function (group, i) {
                        id.push(group.id);
                    });
                current.deleteById(id);
            },
            enabled: false
        },
    ];
    this.setUrl = function (url) {
        for (var key in this.url) {
            if (typeof url[key] !== 'undefined') {
                this.url[key] = url[key];
            }
        }
    };
    this.addUrl = function (url) {
        for (var key in url) {
            this.url[key] = url[key];
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
    this.addLang = function (lang) {
        for (var p_key in lang) {
            for (var c_key in lang[p_key]) {
                this.lang[p_key][c_key] = lang[p_key][c_key];
            }
        }
    };
    this.addColumn = function (columns) {
        var i = 1;
        this.columns[0] = this.columnIndex;
        for (var key in columns) {
            this.columns[i] = columns[key];
            i++;
        }
        if (this.item.type.search('e') >= 0) {
            this.columns[i] = this.baseColumns.edit;
            i++;
        }

        if (this.item.type.search('d') >= 0) {
            this.columns[i] = this.baseColumns.delete;
            i++;
        }

        this.columns[i] = this.baseColumns.select;
    };
    this.addButton = function (buttons) {
        var i = 4;
        if (this.item.type.search('c') >= 0) {
            this.buttons[i] = this.createButton;
            i++;
        }

        for (var key in buttons) {
            this.buttons[i] = buttons[key];
            i++;
        }
    };
    this.enDisButton = function () {
        var selectedRows = this.table.rows({selected: true}).count();
        if (selectedRows > 0) {
            this.table.button(2).enable();
            this.table.button(3).enable();
        } else {
            this.table.button(2).disable();
            this.table.button(3).disable();
        }
    };
    this.initItem = function () {
        if (typeof this.item.url !== 'undefined') {
            this.addUrl(this.item.url);
        }

        if (typeof this.item.lang !== 'undefined') {
            this.addLang(this.item.lang);
        }

        if (typeof this.item.columns !== 'undefined') {
            this.addColumn(this.item.columns);
        }

        if (typeof this.item.buttons !== 'undefined') {
            this.addButton(this.item.buttons);
        }
    };
    this.addItem = function (item) {
        this.item = item;
        this.initItem();
        this.table = $('#table').DataTable({
            dom: 'Bfrtip',
            'processing': true,
            'ajax': current.url.ajaxList,
            'columns': current.columns,
            'order': [1, 'asc'],
            select: {
                style: 'multi',
                selector: 'td:last-child'
            },
            buttons: current.buttons,
        });
        this.addEvent();
    };
    this.addEvent = function () {
        this.table.on('select.dt deselect.dt processing.dt', function () {
            current.enDisButton();
        });
        //Delete
        $('#table tbody').on('click', 'td.delete', function () {
            var tr = $(this).closest('tr');
            var row = current.table.row(tr);
            var id = row.data().id;
            current.deleteById(id);
        });
        //Numbered
        this.table.on('order.dt search.dt', function () {
            current.table
                .column(0, {search: 'applied', order: 'applied'})
                .nodes()
                .each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
        }).draw();
        //Auto reload
        setInterval(function () {
            current.table.ajax.reload(null, false);
        }, 30000);
        //Update
        $('#table tbody').on('click', 'td.edit', function () {
            current.showFormUpdate(this);
        });
        //Submit form
        $('#form_modal').submit(function () {
            current.request = $(this).serializeObject();
            var inputs = $(this).find('input, select, button, textarea');
            inputs.prop('disabled', true);
            SendRequest.send($(this).prop('action'), current.request, 'post', function (data) {
                current.showMessage(data);
                $('#myModal').modal('hide');
            });
            current.table.ajax.reload(null, false);
            inputs.prop('disabled', false);

            return false;
        });
        if (typeof this.item.event === 'function') {
            this.item.event();
        }
    };
    this.showFormCreate = function () {
        this.loadCategory();
        $('#form_modal').prop('action', current.url.ajaxCreate);
        if (typeof this.item.showFormCreate === 'function') {
            this.item.showFormCreate();
        }

        $('#modal-title').html(current.lang.trans.title_create);
        $('#form_modal')[0].reset();
        $('.form-group').removeClass('has-error');
        $('#myModal').modal("show");
    };
    this.showFormUpdate = function (thisRow) {
        var tr = $(thisRow).closest('tr');
        var row = current.table.row(tr);
        var rdata = row.data();
        current.loadCategory();
        $('#form_modal').prop('action', current.url.ajaxUpdate);
        if (typeof this.item.showFormUpdate === 'function') {
            this.item.showFormUpdate(rdata);
        }

        $('input[name=id]').val(rdata.id);
        $('#modal-title').html(current.lang.trans.title_update);
        $('.form-group').removeClass('has-error');
        $('#myModal').modal("show");
    };
    this.showMessage = function (data) {
        message(
            data.responseJSON[current.lang.response.message_name],
            data.responseJSON[current.lang.response.key_name]
        );
    };
    this.loadCategory = function () {
        SendRequest.send(current.url.ajaxList, current.request, 'get', function (response) {
            if (response.status === 200) {
                $('#parent_id').children(':nth-child(n+2)').remove();
                $('#parent_id').append(drawCategoryList(response.responseJSON.data));
            } else {
                alert(current.lang.trans.load_categories_error + response.status);
            }
        });
    };
    this.deleteById = function (id) {
        this.request = {id: id, _method: 'delete'};
        var r = confirm(current.lang.trans.confirm_delete);
        if (r) {
            SendRequest.send(current.url.delete, current.request, 'post', current.showMessage);
            current.table.ajax.reload(null, false);
        }
    };
    this.init = function (options) {
        if (typeof options.url !== 'undefined') {
            this.setUrl(options.url);
        }

        if (typeof options.lang !== 'undefined') {
            this.changeLang(options.lang);
        }
    };
    this.init(option);

    return this;
}
