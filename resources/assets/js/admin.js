class Admin {
    cspNonce;

    booted = false;

    static make() {
        if (!window._admin) {
            window._admin = new Admin();
            window._admin.init();
            window._admin.boot();
        }
        return window._admin;
    }

    init() {
        this.initCstfToken();
        this.initCspNonce();
    }

    boot() {
        if (this.booted) {
            return;
        }
        this.initActionButton();
        this.booted = true;
    }

    initCstfToken() {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        if (csrfToken) {
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': csrfToken}});
        }
    }

    initCspNonce() {
        const metaElement = document.querySelector('meta[name="csp-nonce"]');
        if (metaElement) {
            this.cspNonce = metaElement.getAttribute('content');
        } else {
            console.log('can not found csp nonce');
        }
    }

    initActionButton() {
        $('[data-action]').on('click', async function (event) {
            let confirm_message = $(this).data('confirm');

            if (confirm_message) {
                if (!confirm(confirm_message)) {
                    event.preventDefault();
                    event.stopPropagation();
                    return false;
                }
            }

            let action = $(this).data('action');
            let method = $(this).data('method');
            let payload = $(this).data('payload') || {};

            if ($(this).data('table')) {
                payload.ids = $('#' + $(this).data('table') + ' .check:checked').map(function () {
                    return $(this).data('id');
                }).get();
            }

            $.ajax(action, {
                method: method, data: payload, success: function (response) {
                    admin().response(response);
                }, error: function (error) {
                    console.log(error);
                }
            });
        });
    }

    toast(toastData) {
        Toastify({
            newWindow: true,
            text: toastData.text,
            gravity: toastData.gravity,
            position: toastData.position,
            className: "bg-" + toastData.className,
            stopOnFocus: true,
            escapeMarkup: false,
            offset: {
                x: toastData.offset ? 50 : 0, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                y: toastData.offset ? 10 : 0, // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
            duration: toastData.duration,
            close: toastData.close === "close",
            style: toastData.style === "style" ? {
                background: "linear-gradient(to right, var(--vz-success), var(--vz-primary))"
            } : "",
        }).showToast();
    }

    params(url) {
        let params = {};
        try {
            // 创建 URL 对象
            const urlObj = new URL(url);

            // 获取 URLSearchParams 对象
            const searchParams = urlObj.searchParams;

            // 遍历所有参数并添加到对象中
            for (const [key, value] of searchParams) {
                params[key] = value;
            }

            return params;
        } catch (error) {
            console.error('Invalid URL:', error);
            return {};
        }
    }

    response(response) {
        // check if response is json

        if (typeof response === 'string') {
            response = JSON.parse(response);
        }

        switch (response.action) {
            case 'alert':
                alert(response.message);
                break;
            case 'redirect':
                window.location.href = response.url;
                break;
            case 'back':
                window.history.back();
                break;
            case 'reload':
            case 'refresh':
                window.location.reload();
                break;
            case 'dismiss':
            case 'close':
                $(`.modal`).modal('hide');
                break;
        }
    }

    errors(detail, container) {
        for (let key in detail) {
            $(`input[name=${key}]`).addClass('is-invalid');
        }
    }

    asyncRender(url, done, error) {
        $.ajax({
            type: 'get', url: url
        }).then(function (data) {
            done(data);
        }, function (a, b, c) {
            if (error) {
                if (error(a, b, c) === false) {
                    return false;
                }
            }
        })
    }

    selectTable(options) {
        return new SelectTable(options);
    }

    lazyForm(options) {
        return new LazyForm(options);
    }

    async copyToClipboard(text) {
        if (navigator.clipboard && window.isSecureContext) {
            try {
                await navigator.clipboard.writeText(text);
                return true;
            } catch (err) {
                console.error(err);
            }
        }

        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';

        document.body.appendChild(textarea);
        textarea.select();

        try {
            const successful = document.execCommand('copy');
            document.body.removeChild(textarea);

            if (successful) {
                console.log('文本已复制到剪贴板');
                return true;
            } else {
                console.error('复制失败');
                return false;
            }
        } catch (err) {
            document.body.removeChild(textarea);
            console.error('复制失败:', err);
            return false;
        }
    }
}

class SelectTable {
    constructor(options) {
        let that = this;

        that.id = options.id;
        that.url = options.url;
        that.nonce = options.nonce;
        that.selected = [];
        that.choices = new Choices("#" + that.id + ' .form-select', {
            removeItemButton: true,
        });
        that.button_select = $('#' + that.id + ' .btn-select');
        that.button_clear = $('#' + that.id + ' .btn-clear');
        that.dialog = $('.select-table-dialog[data-table=' + that.id + ']');

        that.button_clear.on('click', function () {
            that.selected = [];
            that.choices.clearChoices();
            that.choices.clearStore();
            that.button_clear.hide();
        });

        that.button_select.on('click', function () {
            that.asyncLoad({
                element: that.dialog.data('from'), nonce: that.nonce,
            }, that.dialog.find('.modal-body'));
            that.dialog.modal('show');
        });

        that.dialog.find('button.btn-confirm').on('click', function () {
            let remove_select = [];
            that.dialog.find('.check:checked:not(.selected)').each(function (index, item) {
                let v = $(item).data('id') + "";
                that.selected.push({
                    value: v, label: $(item).data('label')
                })
            });

            that.dialog.find('.check:not(:checked).selected').each(function (index, item) {
                remove_select.push($(item).data('id') + "");
            });

            // remove remove_select values from selected
            that.selected = that.selected.filter(item => !remove_select.includes(item.value));

            that.choices.clearChoices();
            that.choices.clearStore();
            that.choices.setValue(that.selected);
            that.dialog.modal('hide');

            if (that.selected.length > 0) {
                that.button_clear.show();
            } else {
                that.button_clear.hide();
            }
        });

        that.button_clear.hide();

        $('#' + that.id).removeClass('hidden');
    }

    asyncLoad(params, container) {
        let that = this;

        admin().asyncRender(this.url, params, function (data) {
            $(container).html(data);

            that.selected = [];
            let _values = that.choices.getValue();

            for (let i in _values) {
                let _value = _values[i];
                that.selected.push({
                    value: _value.value, label: _value.label
                })
            }
            for (let i in that.selected) {
                let id = that.selected[i]['value'];
                $(container).find('.check[data-id=' + id + ']').prop('checked', true);
                $(container).find('.check[data-id=' + id + ']').addClass('selected');
            }

            $(container).find('a').on("click", function (e) {
                e.preventDefault();
                let _params = admin().params(this.href);
                _params.element = params.element;
                _params._nonce = "{{admin()->csp()}}";
                that.asyncLoad(_params, container);
            });

            $(container).find('.check').on("change", function () {
                console.log($(this).data('id') + ' : ' + $(this).prop('checked'));
            });

            $(container).find('form').on('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                const _params = {};
                formData.forEach((value, key) => {
                    _params[key] = value;
                });
                _params.element = params.element;
                _params._nonce = "{{admin()->csp()}}";
                that.asyncLoad(_params, container);
                return false;
            });
        });
    }
}

class LazyForm {

    rendered = false;
    contentUrl;
    id;

    constructor(options) {
        let that = this;
        that.id = options.id;
        that.contentUrl = options.url;
        document.getElementById('btn_' + that.id).addEventListener('click', function () {
            if (!that.rendered) {
                const container = document.getElementById('lazy_content_' + that.id);
                admin().asyncRender(that.contentUrl, function (result) {
                    $('#errors_' + that.id).hide();
                    container.innerHTML = result;
                    container.querySelectorAll('form').forEach(function (form) {
                        form.addEventListener('submit', function (e) {
                            e.preventDefault();
                            $.ajax({
                                type: 'post',
                                url: form.getAttribute('action'),
                                data: new FormData(form),
                                processData: false,
                                contentType: false,
                                success: function (result) {
                                    admin().response(result);
                                },
                                error: function (error) {
                                    let data = error.responseJSON;
                                    admin().errors(data.errors, container);
                                    $('#errors_' + that.id).html(data.message).show();
                                }
                            })
                        });
                    });
                });
                that.rendered = true;
            }
            (new bootstrap.Modal(document.getElementById(that.id))).show();
        });
    }
}

(function () {
    window.admin = function () {
        return Admin.make();
    }
    window.admin();
})();


