/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/* fileItem.status = wait/process/error/success */

function uploadMultipleFile(option) {
    var current = this;
    this.fileItem = function (file, id, status, url) {
        this.id = id;
        this.status = typeof status === 'undefined' ? 'upload' : status;
        this.file = file;
        this.url = typeof url === 'undefined' ? '' : url;
    };
    this.maxSize = 1436538;
    this.filesUploaded = [];
    this.fileProcess = null;
    this.onProcess = false;
    this.currentUpload;
    this.currentId = 0;
    this.files = [];
    this.lang = {
        'unknown_error': 'Unknown error! code: ',
        'comfirm_login': 'You have to login to do this action',
        'add': 'Add',
        'remove_all': 'Remove all',
        'upload': 'Upload',
        'stop': 'Stop',
        'finish': 'Upload finish!',
        'stop_upload': 'Upload stopped!',
        'file_big': ' too big',
    };
    this.url = {
        'upload': '',
        'login': '',
    };
    this.statusContent = {
        'upload': '<i class="fa fa-upload fa-2x button" aria-hidden="true"></i>',
        'error': '<i class="fa fa-repeat fa-2x button" aria-hidden="true"></i>',
        'process': '<i class="fa fa-spinner fa-pulse fa-2x button" style="left:28%;top:25%;color:blue;text-shadow: 0 0 0;"></i>',
        'success': '<i class="fa fa-check-circle fa-2x button" style="color:green;text-shadow: 0 0 0"></i>',
    };
    this.buttonContent = {
        'start': '<i class="fa fa-cloud-upload" aria-hidden="true"></i> ' + current.lang.upload,
        'stop': '<i class="fa fa-stop-circle" aria-hidden="true"></i> ' + current.lang.stop,
        'removeAll': '<i class="fa fa-times-circle" aria-hidden="true"></i> ' + current.lang.remove_all,
        'add': '<i class="fa fa-plus-circle" aria-hidden="true"></i> ' + current.lang.add,
    };
    this.item = function (id, img, status) {
        this.content = '<div class="thumb hvr-grow-shadow" data-file-id="';
        this.content += id;
        this.content += '">';
        this.content += '<div class="status">';
        this.content += typeof status === 'undefined' ? current.statusContent.upload : current.statusContent[status];
        this.content += '</div>';
        this.content += '<div class="delete-button">';
        this.content += '<i class="fa fa-times" aria-hidden="true"></i>';
        this.content += '</div>';
        this.content += '</div>';
        this.img = img;
        this.get = function () {
            return $(this.content).css('background-image', 'url("' + this.img + '")');
        };
    };
    this.drawMain = {
        content: [
            '<div class="panel panel-default" id="image-upload">',
            '<div class="panel-body" id="images-list"></div>',
            '<div class="panel-footer">',
            '<div class="btn btn-primary btn-xs" id="add">',
            current.buttonContent.add,
            '</div>&nbsp;',
            '<input style="display: none"',
            'type="file"',
            'name="file-photo"',
            'id="file-photo"',
            'multiple="multiple"',
            'accept="image/x-png, image/gif, image/jpeg"',
            '/>',
            '<div class="btn btn-primary btn-xs" id="remove">',
            current.buttonContent.removeAll,
            '</div>',
            '<div class="btn btn-primary btn-xs" style="float: right" id="action" data-action="start">',
            current.buttonContent.start,
            '</div>',
            '</div>',
            '</div>',
        ],
        draw: function () {
            var main = '';
            $.each(current.drawMain.content, function (i, v) {
                main += v;
            });

            return main;
        }
    };
    this.changeLang = function (lang) {
        for (var key in this.lang) {
            if (typeof lang[key] !== 'undefined') {
                this.lang[key] = lang[key];
            }
        }
    };
    this.changeUrl = function (url) {
        for (var key in this.url) {
            if (typeof url[key] !== 'undefined') {
                this.url[key] = url[key];
            }
        }
    };
    this.init = function (option) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        if (typeof option.url !== 'undefined') {
            this.changeUrl(option.url);
        }

        if (typeof option.lang !== 'undefined') {
            this.changeLang(option.lang);
        }

        if (typeof option.maxSize === 'number') {
            this.maxSize = option.maxSize;
        }
    };
    this.draw = function (div) {
        div.append(current.drawMain.draw());
        this.addEvent();
    };
    this.fileIsset = function (newFile) {
        var response = false;
        $.each(current.files, function (i, item) {
            if (typeof item !== 'undefined' && item.file.name === newFile.name && item.file.size === newFile.size) {
                response = true;
            }
        });

        $.each(current.filesUploaded, function (i, item) {
            if (
                typeof item !== 'undefined'
                && item.file !== null
                && item.file.name === newFile.name
                && item.file.size === newFile.size
            ) {
                response = true;
            }
        });

        if (
            current.fileProcess !== null
            && current.fileProcess.file.name === newFile.name
            && current.fileProcess.file.size === newFile.size
        ) {
            response = true;
        }

        return response;
    };
    this.addItem = function (fileItem) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var item = new current.item(fileItem.id, e.target.result);
            $('#images-list').append(item.get());
        };
        reader.readAsDataURL(fileItem.file);
        return true;
    };
    this.addFiles = function (files) {
        $.each(files, function (i, file) {
            if (!current.fileIsset(file)) {
                if (file.size > current.maxSize) {
                    message(file.name + current.lang.file_big, 'error');
                } else {
                    var FileItem = new current.fileItem(file, current.currentId);
                    current.addItem(FileItem);
                    current.files.push(FileItem);
                    current.currentId++;
                }
            }
        });
    };
    this.removeFile = function (item) {
        var id = item.data('file-id');
        $.each(current.files, function (i, file) {
            if (typeof file !== 'undefined' && file.id === id) {
                delete(current.files[i]);
                item.remove();
            }
        });

        $.each(current.filesUploaded, function (i, file) {
            if (typeof file !== 'undefined' && file.id === id) {
                delete(current.filesUploaded[i]);
                item.remove();
            }
        });
    };
    this.removeAll = function () {
        $('.thumb').remove();
        current.files = [];
        current.filesUploaded = [];
    };
    this.start = function () {
        if (current.onProcess && current.fileProcess === null) {
            var file = current.files.shift();
            if (typeof file !== 'undefined') {
                current.fileProcess = file;
                current.uploadFile(current.fileProcess);
                current.addItemStatus(file, 'process');
            } else {
                if (current.files.length > 0) {
                    current.start();
                } else {
                    current.writeButtonStart();
                    current.onProcess = false;
                    message(current.lang.finish, 'success');
                }
            }
        }
    };
    this.addItemStatus = function (file, status) {
        var item = $('.thumb[data-file-id="' + file.id + '"]');
        item.removeClass('error');
        item.children('.status').html(current.statusContent[status]);
        if (status === 'error') {
            item.addClass('error');
        }

        if (status === 'process' || status === 'success') {
            item.children('.status').css('opacity', '0.6');
        } else {
            item.children('.status').css('opacity', '');
        }
    };
    this.stop = function () {
        current.currentUpload.abort();
        current.onProcess = false;
        current.addStatus('error');
    };
    this.writeButtonStart = function () {
        $('#remove').show();
        $('#action').data('action', 'start').html(current.buttonContent.start);
    };
    this.writeButtonStop = function () {
        $('#remove').hide();
        $('#action').data('action', 'stop').html(current.buttonContent.stop);
    };
    this.action = function (button) {
        if ($(button).data('action') === 'start') {
            current.writeButtonStop();
            current.onProcess = true;
            current.start();
        } else {
            current.writeButtonStart();
            current.stop();
        }
    };
    this.addStatus = function (status) {
        if (status === 'success') {
            current.fileProcess.status = 'success';
            current.filesUploaded.push(current.fileProcess);
            current.addItemStatus(current.fileProcess, 'success');
        } else {
            current.fileProcess.status = 'error';
            current.files.push(current.fileProcess);
            current.addItemStatus(current.fileProcess, 'error');
        }
        current.fileProcess = null;
        current.start();
    };
    this.uploadOneFile = function (itemStatus) {
        if (current.fileProcess === null) {
            var item = $(itemStatus).parents('.thumb');
            var id = item.data('file-id');
            $.each(current.files, function (i, file) {
                if (typeof file !== 'undefined' && file.id === id) {
                    delete(current.files[i]);
                    current.fileProcess = file;
                    current.uploadFile(current.fileProcess);
                    current.addItemStatus(file, 'process');
                }
            });
        }
    };
    this.addEvent = function () {
        $('#add').on('click', function () {
            $('#file-photo').click();
        });
        $('#remove').on('click', function () {
            current.removeAll();
        });
        $('#image-upload').on('click', '#action', function () {
            current.action(this);
        });
        $('#images-list').on('click', '.delete-button', function () {
            current.removeFile($(this).parents('.thumb'));
        });
        $('#images-list').on('click', '.status', function () {
            current.uploadOneFile(this);
        });
        $('#file-photo').on('change', function () {
            current.addFiles(this.files);
        });
    };
    this.uploadFile = function (item) {
        var formData = new FormData();
        formData.append('upload', item.file);
        current.currentUpload = $.ajax({
            url: current.url.upload,
            type: 'post',
            dataType: 'json',
            complete: function (data) {
                switch (data.status) {
                    case 200:
                        current.fileProcess.url = data.responseJSON.url;

                        if (data.responseJSON.status) {
                            current.addStatus('success');
                        } else {
                            current.addStatus('error');
                        }
                        break;
                    case 401:
                        if (confirm(current.lang.comfirm_login)) {
                            window.location = current.url.login;
                        }
                        current.addStatus('error');
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
                        current.addStatus('error');
                        break;
                    case 0:
                        message(current.lang.stop_upload, 'error');
                        break;
                    default :
                        message(current.lang.unknown_error + data.status, 'error');
                        setTimeout(function () {
                            window.location.reload(1);
                        }, 2000);
                        current.addStatus('error');
                }
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });
    };
    this.getUploaded = function () {
        var response = [];
        $.each(current.filesUploaded, function (i, item) {
            if (typeof item !== 'undefined') {
                response.push(item.url);
            }
        });

        return response;
    };
    this.addImage = function (images) {
        $.each(images, function (i, url) {
            var fileItem = new current.fileItem(null, current.currentId, 'success', url);
            current.currentId++;
            var item = new current.item(fileItem.id, fileItem.url, fileItem.status);
            current.filesUploaded.push(fileItem);
            $('#images-list').append(item.get());
        });
    };
    this.init(option);

    return this;
}
