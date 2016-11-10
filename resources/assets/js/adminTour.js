/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* global SendRequest, DatatableBase, CKEDITOR, UploadMultipleFile */

function tour(option) {
    var current = this;
    this.table = null;
    this.request = null;
    this.selectPlace = [];
    this.placeItem = function (id, name) {
        this.name = name;
        this.id = id;
        this.content = [
            '<span class="label label-success place-item">',
            this.name,
            '&nbsp;<i class="fa fa-times delete-place" aria-hidden="true" style="cursor: pointer"></i>',
            '<input type="hidden" name="places[]" value="',
            this.id,
            '"/>',
            '</span>',
        ];
        this.get = function () {
            var response = '';
            $.each(this.content, function (i, v) {
                response += v;
            });
            return response;
        };
    };
    this.type = 'cde';
    this.lang = {
        'trans': {
            'title_create': 'Create new tour',
            'title_update': 'Update tour',
        },
        'response': {
            'key_name': 'key',
            'message_name': 'message',
        }
    };
    this.url = {
        'ajaxShow': '',
        'ajaxShowImage': '',
        'ajaxList': '',
        'ajaxCreate': '',
        'ajaxUpdate': '',
        'ajaxDelete': '',
        'ajaxListCategory': '',
        'ajaxListPlaces': '',
        'ajaxUpdateImages': '',
    };
    this.columns = [
        {
            'data': 'name',
            'class': 'tour-name',
        },
        {
            'data': function (source, type, val) {
                if (source.category === null) {
                    return 'NULL';
                }
                return source.category.name;
            }
        },
        {'data': 'price'},
        {'data': 'num_day'},
        {
            'data': function (source, type, val) {
                if (source.rate_average === null || source.rate_average === '') {
                    return 0;
                }
                return source.rate_average;
            }
        },
        {'data': 'reviews_count'},
        {
            'orderable': false,
            'searchable': false,
            'className': 'show-images center',
            'defaultContent': '<i class="fa fa-picture-o tour-photo" aria-hidden="true"></i>'
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
    this.init = function (options) {
        if (typeof options.url !== 'undefined') {
            this.setUrl(options.url);
        }

        if (typeof options.lang !== 'undefined') {
            this.changeLang(options.lang);
        }

        DatatableBase.order.column = 5;
        DatatableBase.order.type = 'desc';
        DatatableBase.addItem(this);
        this.addEvent();
    };
    this.addEvent = function () {
        $('.btn_save').on('click', function () {
            $('[name=description]').val(CKEDITOR.instances.description.getData());
            $('#form_modal').submit();
        });
        $('.btn-add-places').on('click', function () {
            current.addPlace();
        });
        $('#place_id').on('click', '.delete-place', function () {
            current.removePlace(this);
        });
        //Images
        $('#table tbody').on('click', 'td.show-images', function () {
            var tr = $(this).closest('tr');
            var data = DatatableBase.table.row(tr).data();
            current.showFormUploadImage(data.id);
        });
        $('#image_form').submit(function () {
            var request = {
                'id': $(this).children('input[name=id]').val(),
                'images': UploadMultipleFile.getUploaded(),
            };
            $(this).find('input').prop('disable', true);
            SendRequest.send(current.url.ajaxUpdateImages, request, 'post', function (data) {
                message(
                    data.responseJSON[current.lang.response.message_name],
                    data.responseJSON[current.lang.response.key_name]
                );
                $('#image-modal').modal('hide');
            });
            $(this).find('input').prop('disable', false);
            return false;
        });
    };
    this.showFormUploadImage = function (tourId) {
        var data;
        var images = [];
        var i = 0;
        SendRequest.send(current.url.ajaxShowImage + '/' + tourId, null, 'get', function (response) {
            data = response.responseJSON;
        });
        $.each(data.images, function (j,  image) {
            images[i] = image.url;
            i++;
        });
        UploadMultipleFile.removeAll();
        $('#image_form').children('input[name=id]').val(data.id);
        UploadMultipleFile.addImage(images);
        $('#image-modal-title').html(data.name);
        $('#image-modal').modal('show');
    };
    this.loadTour = function (tourId) {
        var data = null;
        SendRequest.send(current.url.ajaxShow + '/' + tourId, null, 'get', function (response) {
            data = response.responseJSON;
        });
        return data;
    };
    this.addPlace = function () {
        var placeId = $('#places_list').val();
        if (typeof placeId === 'string' && placeId !== '') {
            var exists = false;
            $.each(current.selectPlace, function (i, v) {
                if (placeId === v) {
                    exists = true;
                }
            });
            if (!exists) {
                var name = $('#places_list').children('[value=' + placeId + ']').html();
                $('#places_list').children('[value=' + placeId + ']').prop('disabled', true);
                current.selectPlace.push(placeId);
                var item = new current.placeItem(placeId, name);
                $('#place_id').append(item.get());
            }
        }
    };
    this.removePlace = function (placeItem) {
        var id = parseInt($(placeItem).parents('.place-item').find('input').val());
        $.each(current.selectPlace, function (i, placeId) {
            if (parseInt(placeId) === id) {
                $(placeItem).parents('.place-item').remove();
                delete(current.selectPlace[i]);
                $('#places_list').children('[value=' + id + ']').prop('disabled', false);
            }
        });
    };
    this.loadCategory = function () {
        SendRequest.send(current.url.ajaxListCategory, null, 'get', function (response) {
            $('#category_id').children(':nth-child(n+2)').remove();
            $('#category_id').append(drawCategoryList(response.responseJSON.data));
        });
    };
    this.loadPlace = function () {
        var item = '';
        SendRequest.send(current.url.ajaxListPlaces, null, 'get', function (response) {
            $('#places_list').children(':nth-child(n+2)').remove();
            $.each(response.responseJSON.data, function (key, place) {
                item += '<option value="' + place.id + '">' + place.name + '</option>';
            });
            $('#places_list').append(item);
        });
        current.selectPlace = [];
        $('#place_id').html('');
    };
    this.showFormUpdate = function (rData) {
        this.loadCategory();
        this.loadPlace();
        $('option').prop('selected', false);
        $('option').prop('disabled', false);
        $('#category_id').children('option[value="' + rData.category_id + '"]').prop('selected', true);
        $.each(rData.places, function (i, place) {
            var name = $('#places_list').children('[value=' + place.id + ']').html();
            $('#places_list').children('[value=' + place.id + ']').prop('disabled', true);
            current.selectPlace.push(place.id);
            var item = new current.placeItem(place.id, name);
            $('#place_id').append(item.get());
        });
        $('#name').val(rData.name);
        $('#price').val(rData.price);
        $('#num_day').val(rData.num_day);
        CKEDITOR.instances.description.setData(rData.description);
    };
    this.showFormCreate = function () {
        this.loadCategory();
        this.loadPlace();
        $('option').prop('selected', false);
        $('option').prop('disabled', false);
        CKEDITOR.instances.description.setData('');
    };
    this.init(option);

    return this;
}
