/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* global SendRequest, DatatableBase */

function tourSchedule(option) {
    var current = this;
    this.table = null;
    this.request = null;
    this.type = 'cde';
    this.lang = {
        'trans': {
            'title_create': 'Create new tour schedule',
            'title_update': 'Update tour schedule',
            'confirm_delete': 'Do you want delete field? All tour with this category will be deleted.',
        },
    };
    this.buttonSubmitText = {
        'create': 'Create',
        'update': 'Update',
    };
    this.url = {
        'ajaxList': '',
        'ajaxCreate': '',
        'ajaxUpdate': '',
        'ajaxDelete': '',
        'ajaxListOnly': '',
        'ajaxTour': '',
        'ajaxTourList': '',
        'ajaxRevenueList': '',
    };
    this.complete = function () {
        current.loadTour($('select[name=tour_id]').val());
    };
    this.scheduleItem = function (option) {
        var current = this;
        this.data = '';
        $.each(option, function (i, v) {
            if (typeof v !== 'object') {
                current.data += 'data-' + i + '="' + v + '" ';
            }
        });

        this.option = {
            start: typeof option.start !== 'undefined' ? option.start : 'NULL',
            end: typeof option.end !== 'undefined' ? option.end : 'NULL',
            max_slot: typeof option.max_slot !== 'undefined' ? option.max_slot : 'NULL',
            revenue: typeof option.revenue !== 'undefined' && option.revenue !== null ? option.revenue.value : 'NULL',
            available_slot: typeof option.available_slot !== 'undefined' ? option.available_slot : 'NULL',
            price: typeof option.price !== 'undefined' ? option.price : 'NULL',
        };
        this.get = function () {
            var response = '<tr ' + current.data + '>';
            $.each(current.option, function (i, v) {
                response += '<td data-' + i + '="' + v + '">' + v + '</td>';
            });
            response += '<td class="modal-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></td>';
            response += '<td class="modal-delete"><i class="fa fa-times" aria-hidden="true"></i></td>';
            response += '</tr>';

            return response;
        };

        return this;
    };
    this.columns = [
        {
            'data': function (data) {
                return data.tour === null ? 'NULL' : data.tour.name;
            },
        },
        {'data': 'max_slot'},
        {'data': 'available_slot'},
        {
            'data': function (data) {
                return data.tour === null ? 'NULL' : data.tour.num_day;
            },
        },
        {'data': 'start'},
        {'data': 'end'},
        {'data': 'price'},
        {
            'data': function (data) {
                return data.tour === null ? 'NULL' : data.tour.price;
            },
        },
        {
            'data': function (data) {
                return data.revenue === null ? 'NULL' : data.revenue.value;
            },
        },
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
    this.changeButtonText = function (buttonSubmitText) {
        for (var key in this.buttonSubmitText) {
            if (typeof buttonSubmitText[key] !== 'undefined') {
                this.buttonSubmitText[key] = buttonSubmitText[key];
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

        if (typeof options.buttonSubmitText !== 'undefined') {
            this.changeButtonText(options.buttonSubmitText);
        }

        DatatableBase.addItem(this);
        this.addEvent();
    };
    this.changeButtonSubmit = function (status) {
        $('input[type=submit]').prop('value', current.buttonSubmitText[status]);
    };
    this.addEvent = function () {
        $('select[name=tour_id]').on('change', function () {
            current.loadTour($(this).val());
        });
        $('#schedule-list').on('click', '.modal-edit', function () {
            rData = $(this).parents('tr').data();
            $('input[name=id]').val(rData.id);
            $('[name=revenue_id]').children('option').prop('selected', false);
            $('[name=revenue_id]').children('option[value="' + rData.revenue_id + '"]').prop('selected', true);
            $('[name=max_slot]').val(rData.max_slot);
            $('[name=start]').val(rData.start);
            $('[name=end]').val(rData.end);
            $('#form_modal').prop('action', current.url.ajaxUpdate);
            current.changeButtonSubmit('update');
        });
        $('#schedule-list').on('click', '.modal-delete', function () {
            DatatableBase.deleteById($(this).parents('tr').data('id'));
            current.complete();
        });
        $('#btn-create').on('click', function () {
            current.loadCreateScheduleForm();
            current.changeButtonSubmit('create');
        });
        $('[name=start]').on('keyup change', function () {
            current.caculateEndDate();
        });
    };
    this.loadTourList = function () {
        SendRequest.send(current.url.ajaxTourList, null, 'get', function (response) {
            $('select[name=tour_id]').children(':nth-child(n+2)').remove();
            var chil = '';
            $.each(response.responseJSON, function (key, tour_name) {
                chil += '<option value="' + key + '">' + tour_name + '</option>';
            });
            $('select[name=tour_id]').append(chil);
        });
    };
    this.loadRevenueList = function () {
        SendRequest.send(current.url.ajaxRevenueList, null, 'get', function (response) {
            $('select[name=revenue_id]').children(':nth-child(n+2)').remove();
            var chil = '';
            $.each(response.responseJSON.data, function (key, revenue) {
                chil += '<option value="' + revenue.id + '">' + revenue.value + '</option>';
            });
            $('select[name=revenue_id]').append(chil);
        });
    };
    this.loadScheduleTable = function (data) {
        $('#schedule-list').children().remove();
        $.each(data, function (i, schedule) {
            var scheduleItem = new current.scheduleItem(schedule);
            $('#schedule-list').append(scheduleItem.get());
        });
    };
    this.loadTour = function (id) {
        if (id !== null && typeof id !== 'undefined' && id !== '') {
            SendRequest.send(current.url.ajaxTour + '/' + id, null, 'get', function (response) {
                var data = response.responseJSON;
                var tourPlace = '';
                $('#tour-category').html(data.category.name);
                $('#tour-name').html(data.name);
                $('#schedule-title').html('Schedule tour: ' + data.name);
                $.each(data.places, function (i, place) {
                    tourPlace += place.name + '<br/>';
                });
                $('#tour-place').html(tourPlace);
                $('#tour-price').html(data.price);
                $('#tour-num-day').html(data.num_day);
                current.loadScheduleTable(data.tour_schedules);
            });
        } else {
            current.loadZero();
        }

        current.caculateEndDate();
    };
    this.loadCreateScheduleForm = function () {
        $('#form_modal').prop('action', current.url.ajaxCreate);
        $('#modal-title').html(DatatableBase.lang.trans.title_create);
        current.changeButtonSubmit('create');
        $('.form-group').removeClass('has-error');
        $('[name=revenue_id]').children().prop('selected', false);
        $('[name=max_slot]').val('');
        $('[name=start]').val('');
        $('[name=end]').val('');
    };
    this.showFormUpdate = function (rData) {
        this.loadTourList();
        this.loadRevenueList();
        $('[name=tour_id]').children('option[value="' + rData.tour_id + '"]').prop('selected', true);
        current.loadTour(rData.tour_id);
        $('[name=revenue_id]').children('option[value="' + rData.revenue_id + '"]').prop('selected', true);
        $('[name=max_slot]').val(rData.max_slot);
        $('[name=start]').val(rData.start);
        $('[name=end]').val(rData.end);
        $('#form_modal').prop('action', current.url.ajaxUpdate);
        current.changeButtonSubmit('update');
    };
    this.caculateEndDate = function () {
        var startArray = $('[name=start]').val().split('-');
        var numDay = parseInt($('#tour-num-day').html());
        if (startArray.length !== 3 || isNaN(numDay)) {
            $('[name=end]').val('');

            return '';
        }

        var endDate = '';
        var result = new Date(startArray[2], (startArray[1] - 1), startArray[0]);
        result.setDate(result.getDate() + numDay);
        endDate += result.getDate();
        endDate += '-' + (result.getMonth() + 1);
        endDate += '-' + result.getFullYear();
        $('[name=end]').val(endDate);

        return endDate;
    };
    this.loadZero = function () {
        $('#tour-category').html('');
        $('#tour-name').html('');
        $('#tour-place').html('');
        $('#tour-price').html('');
        $('#tour-num-day').html('');
        current.loadScheduleTable([]);
    };
    this.showFormCreate = function () {
        current.changeButtonSubmit('create');
        this.loadTourList();
        this.loadRevenueList();
        current.loadZero();
        $('.form-group').removeClass('has-error');
        $('option').prop('selected', false);
    };
    this.init(option);

    return this;
}
