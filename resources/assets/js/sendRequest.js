/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function sendRequest(options) {
    this.request = null;
    this.calback = function () {
    };
    this.type = 'post';
    this.dataType = 'json';
    this.lang = {
        'unknown_error': 'Unknown error! code: ',
        'comfirm_login': 'You have to login to do this action',
    };
    this.url = {
        'login': '',
        'dest': '',
    };
    this.setRequest = function (request) {
        this.request = request;
    };
    this.setUrlDest = function (urlDest) {
        this.url.dest = urlDest;
    };
    this.setLang = function (lang) {
        for (var key in this.lang) {
            if (typeof lang[key] !== 'undefined') {
                this.lang[key] = lang[key];
            }
        }
    };
    this.setProperty = function (options) {
        if (typeof options.lang !== 'undefined') {
            this.setLang(options.lang);
        }

        if (typeof options.urlDest === 'string') {
            this.url.dest = options.urlDest;
        }

        if (typeof options.request !== 'undefined') {
            this.request = options.request;
        }

        if (typeof options.calback === 'function') {
            this.calback = options.calback;
        }

        if (typeof options.type === 'string') {
            this.type = options.type;
        }

        if (typeof options.dataType === 'string') {
            this.dataType = options.dataType;
        }
    };
    this.init = function (options) {
        if (typeof options !== 'undefined') {
            this.setProperty(options);
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    };
    this.send = function (urlDest, request, type, calback) {
        var current = this;
        if (typeof urlDest === 'string') {
            this.url.dest = urlDest;
        }

        if (typeof type === 'string') {
            this.type = type;
        }

        if (typeof request !== 'undefined' && request !== null) {
            this.request = request;
        }

        if (typeof calback === 'function') {
            this.calback = calback;
        }

        $.ajax({
            url: current.url.dest,
            type: current.type,
            dataType: current.dataType,
            async: false,
            data: current.request,
            complete: function (data) {
                switch (data.status) {
                    case 200:
                        calback(data);
                        break;
                    case 401:
                        if (confirm(current.lang.comfirm_login)) {
                            window.location = current.url.login;
                        }
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
                        break;
                    default :
                        message(current.lang.unknown_error + data.status, 'error');
                        setTimeout(function () {
                            window.location.reload(1);
                        }, 2000);
                }
            }
        });
    };
    this.init(options);
    return this;
}
