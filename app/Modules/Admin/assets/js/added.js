// Add csrf token to all ajax calls
function ajaxSetupLoader() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            $('.ajax-loader').show();
        },
        complete: function () {
            $('.ajax-loader').hide();
        }
    });
}

function ajaxSetupNonLoader() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
        },
        complete: function () {
        }
    });
}

ajaxSetupLoader();

function explode(str, delimiter) {
    return str.split(delimiter);
}

// Bootstrap file button
$('body').on('change', '.btn-file :file', function () {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
});

// Sort array by property   sortByProperty(myArray, "name");
function sortByProperty(array, propertyName) {
    return array.sort(function (a, b) {
        return a[propertyName] - b[propertyName];
    });
}

// Ajax loader
function loaderShow() {
    $('.ajax-loader').show();
}

function loaderHide() {
    $('.ajax-loader').hide();
}

// Background color for drag & drop
function colorSuccess(item) {
    var color = item.css('background-color');
    item.css('background-color', '#64c664')
        .animate({'background-color': color}, 500, function () {
            item.removeAttr('style');
        });
}

function colorDanger(item) {
    var color = item.css('background-color');
    item.css('background-color', '#e71a1a')
        .animate({'background-color': color}, 500, function () {
            item.removeAttr('style');
        });
}

// Custom functions
function randomString(length) {
    length = typeof length !== 'undefined' ? length : 8;
    return Math.random().toString(36).slice(length);
}

// Get model (type: json | list | option)
function getModel(model, column, type, extra) {
    type = typeof type !== 'undefined' ? type : 'json';
    column = typeof column !== 'undefined' ? column : '*';
    var out = '';
    $.ajax({
        url: baseUrlAdmin + '/api/get-model',
        type: 'post',
        data: {
            "model": model,
            "column": column,
            "type": type,
            "extra": extra
        },
        success: function (data, textStatus, jqXHR) {
            out = data;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Server error.');
        },
        async: false
    });
    return out;
}

function resetForm(form) {
    form.find('input:text, input:password, input:file, select, textarea').val('');
    form.find('input:radio, input:checkbox')
        .removeAttr('checked').removeAttr('selected');
}

$(document).ready(function () {
//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
//Sets the min-height of #page-wrapper to window size
    $(window).bind("load resize", function () {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    // Menu
    var url = window.location;
    var element = $('ul.nav a').filter(function () {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }

    // Sortable
    function initSortable() {
        $('table.sortable').sortable({
            axis: 'y',
            items: 'tbody tr',
            handle: '.btn-sort',
            forcePlaceholderSize: true,
            cancel: '',
            placeholder: 'sortable-placeholder',
            helper: function (e, ui) {
                ui.children().each(function () {
                    $(this).width($(this).width());
                    $(this).height($(this).height());
                });
                return ui;
            },
            start: function (e, ui) {
                $('.sortable-placeholder').height(ui.item.height());
                ui.item.siblings("tr").has(':checkbox:checked').not(".ui-sortable-placeholder").appendTo(ui.item).hide();
            },
            stop: function (e, ui) {
                var items = ui.item.find("tr");
                ui.item.after(items.show());
                colorSuccess(items);
                colorSuccess(ui.item);
                $('table.sortable input:checkbox').removeAttr('checked');
            }

        }).bind('sortupdate', function (e, ui) {
            var sort = [];
            $('table.sortable tbody tr').each(function (index) {
                sort[index + 1] = $(this).data('id');
            });
            sortRows($('table.sortable').data('model'), sort, ui.item);
        });
    }

    function sortRows(model, sortData, item) {
        $.ajax({
            url: baseUrlAdmin + '/api/sort-rows',
            type: 'post',
            data: {
                "model": model,
                "data": sortData
            },
            success: function (data, textStatus, jqXHR) {
                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Server error.');
            }
        });
    }

    initSortable();

    // Select2
    function initSelect2() {
        $('select.select2').select2(
            {placeholder: "Select a State", maximumSelectionSize: 6}
        );
    }

    initSelect2();

    // Fancybox
    function initFancyBox() {
        $('.fancybox').fancybox({
            openEffect: 'none',
            closeEffect: 'none'
        });
    }

    $('body').on('click', '.fancy-close', function (e) {
        e.preventDefault();
        $.fancybox.close();
    })

    initFancyBox();

    // Msg modal
    $('#overlay-modal').modal();

    // CKEditor
    function initCkeditor() {
        if (typeof CKEDITOR !== 'undefined') {
            var roxyFileman = baseUrl + '/assets/admin/fileman/index.html';

            CKEDITOR.disableAutoInline = true;
            $('.ckeditor').ckeditor(
                {
                    filebrowserBrowseUrl: roxyFileman,
                    filebrowserImageBrowseUrl: roxyFileman + '?type=image',
                    removeDialogTabs: 'link:upload;image:upload'
                }
            );
        }
    }

    initCkeditor();

    // Pjax
    $.pjax.defaults.scrollTo = false;
    $.pjax.defaults.timeout = 5000;
    var pjaxContainer = '#pjax-container';

    $('body').on('pjax:send', function () {
        loaderShow();
    })
    $('body').on('pjax:complete', function () {
        initSelect2();
        initCkeditor();
        loaderHide();
        initSortable();
        initColspan();
        initFancyBoxCrop();
        activeTab();
        initColorPicker();
        initAutocomplete();
    })

    function addSubmitButtons(thisObj) {
        $('<input>').attr({
            type: 'hidden',
            name: thisObj.attr('name'),
            value: thisObj.attr('value')
        }).appendTo(thisObj.closest('form'));
    }

    $('body').on('submit', 'form[data-pjax]', function (e) {
        //e.preventDefault();
        var btn = $(":input[type=submit]:focus");
        if (btn.data('pjax')) {
            addSubmitButtons(btn);
            $.pjax.submit(e, {container: pjaxContainer});
        }
    })

    $('body').on('click', 'a[data-pjax]', function (e) {
        $.pjax.click(e, {container: pjaxContainer})
    })

    // Password generator
    $('body').on('click', '[data-random-string]', function (e) {
        e.preventDefault();
        var element = $(this).data('random-string');
        $(element).val(randomString());
    })

    // Boot box confirm with pjax options
    // confirm, confirmPjax, submit, submitPjax
    var bbFunction = {};

    $('body').on('click', '[data-bb]', function (e) {
        e.preventDefault();
        var type = $(this).data('bb');
        var thisObj = $(this);

        if (typeof bbFunction[type] === 'function') {
            bbFunction[type](thisObj);
        }
    });

    bbFunction.confirm = function (thisObj) {
        bootbox.confirm("Are you sure?", function (result) {
            if (result) {
                location.href = thisObj.attr('href');
            }
        });
    };

    bbFunction.confirmPjax = function (thisObj) {
        bootbox.confirm("Are you sure?", function (result) {
            if (result) {
                $.pjax({url: thisObj.attr('href'), container: pjaxContainer})
            }
        });
    };

    bbFunction.submit = function (thisObj) {
        bootbox.confirm("Are you sure?", function (result) {
            if (result) {
                addSubmitButtons(thisObj);
                thisObj.closest('form').submit();
            }
        });
    };

    bbFunction.submitPjax = function (thisObj) {
        bootbox.confirm("Are you sure?", function (result) {
            if (result) {
                addSubmitButtons(thisObj);
                thisObj.closest('form').on('submit', function (e) {
                    $.pjax.submit(e, {container: pjaxContainer});
                }).submit()
            }
        });
    };

    bbFunction.remove = function (thisObj) {
        bootbox.confirm("Are you sure?", function (result) {
            if (result) {
                if (thisObj.attr('href')) {
                    $.ajax({
                        url: thisObj.attr('href'),
                        type: 'get',
                        success: function (data, textStatus, jqXHR) {
                            if (data.rere) {
                                setInfoBox(data);
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert('Server error.');
                        }
                    });
                }
                thisObj.closest('.remove-this').remove();
            }
        });
    };

    // File button
    $('body').on('fileselect', '.btn-file :file', function (event, numFiles, label) {
        var input = $(this).parents('.input-group').find(':text');
        var log = numFiles > 1 ? numFiles + ' files selected' : label;
        if (input.length) {
            input.val(log);
        } else {
            if (log) alert(log);
        }
    });

    // Colspan
    function initColspan() {
        var count = $('.colspan').closest('table').find('thead tr').children().length;
        $('.colspan').attr('colspan', count);
    }

    initColspan();

    // Change status button
    $('body').on('click', '.change-status', function (e) {
        e.preventDefault();
        var thisObj = $(this);
        $.ajax({
            url: baseUrlAdmin + '/api/change-status',
            type: 'get',
            data: {
                "model": thisObj.data('model'),
                "id": thisObj.data('id'),
                "column": thisObj.data('column')
            },
            success: function (data, textStatus, jqXHR) {
                thisObj.replaceWith(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Server error.');
            }
        });
    })

    // Image crop
    function updateCoords(c) //update the cropped image cords on change
    {
        //console.log(c.x)
        $('.fancybox-outer #x').text(Math.round(c.x));
        $('.fancybox-outer #y').text(Math.round(c.y));
        $('.fancybox-outer #w').text(Math.round(c.w));
        $('.fancybox-outer #h').text(Math.round(c.h));

        $('.fancybox-outer input[name=x]').val(Math.round(c.x));
        $('.fancybox-outer input[name=y]').val(Math.round(c.y));
        $('.fancybox-outer input[name=w]').val(Math.round(c.w));
        $('.fancybox-outer input[name=h]').val(Math.round(c.h));

    }

    $('body').on('submit', '#jcrop-form', function (e) {
        e.preventDefault();
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");
        $.ajax(
            {
                url: formURL,
                type: "post",
                data: postData,
                success: function (data, textStatus, jqXHR) {
                    $.fancybox.close();
                    parent.location.reload(true);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Server error.')
                }
            });
    })

    function initFancyBoxCrop() {
        $('.fancybox-crop').fancybox({
            afterShow: function () {
                $('.fancybox-outer #alt_new_crop').val($(this.element).closest('tr').find("input[name^='alt_update']").first().val());
                $('.fancybox-outer #description_new_crop').val($(this.element).closest('tr').find("input[name^='description_update']").first().val());

                $('.fancybox-outer input[name=image_id]').val($(this.element).attr('data-image-id'))
                $('.fancybox-inner').find('img').Jcrop({
                    allowMove: true,
                    onChange: updateCoords,
                    trueSize: [$(this.element).attr('data-w'), $(this.element).attr('data-h')]
                });
            },
            beforeShow: function () {
                $('#fancy-footer').clone().appendTo('.fancybox-outer').show();
            }
        });
    }

    initFancyBoxCrop();

    // Reset form button
    $('body').on('click', '.reset-form', function (e) {
        e.preventDefault();
        resetForm($(this).closest('form'));
    })

    // Add model content element
    $('body').on('click', '.add-element-btn', function (e) {
        e.preventDefault();
        var select = $('.add-element');
        var module = $('select.add-element').data('module');
        var url = baseUrlAdmin + '/api/add-element';
        if (module) {
            url = baseUrlAdmin + '/api/' + module + '/add-element';
        }

        if (select.select2('val')) {
            $.ajax({
                url: url,
                type: 'get',
                data: {
                    "element": select.select2('val')
                },
                success: function (data, textStatus, jqXHR) {
                    var html = $.parseHTML(data);
                    html = $(html);
                    //var formData = html.find('.added-form').html();
                    //html.find('.added-form').replaceWith(formData);
                    $('#module-content-form .content-form-box').append(html);
                    initCkeditor();
                    addOrderId();
                    initColspan();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Server error.');
                }
            });
        }
    })


    // Add order id after adding the element
    function addOrderId() {
        $('div.sortable-row').each(function (index) {
            $(this).find('.order-id').first().val(index + 1);
        });
    }

    function initSortableContent() {
        $('.content-sortable').sortable({
            axis: 'y',
            items: 'div.sortable-row',
            handle: '.btn-sort',
            forcePlaceholderSize: true,
            cancel: '',
            placeholder: 'sortable-placeholder',
            helper: function (e, ui) {
                ui.children().each(function () {
                    $(this).width($(this).width());
                    $(this).height($(this).height());
                });
                return ui;
            },
            start: function (e, ui) {
                $('.sortable-placeholder').height(ui.item.height());
            },
            stop: function (e, ui) {
                colorSuccess(ui.item);
            }

        }).bind('sortupdate', function (e, ui) {
            var sort = [];
            $('div.sortable-row').each(function (index) {
                sort[index + 1] = $(this).data('id');
                $(this).find('.order-id').first().val(index + 1);
            });
        });
    }

    initSortableContent();

    // Info box
    function setInfoBox(data) {
        $('#info-box').html(data).show('fast');
    }

    $('body').on('click', '.tab-selector a', function (e) {
        e.preventDefault();
        var id = $(this).attr('href');
        $(this).parent('li').siblings().removeClass();
        $(this).parent('li').addClass('active');
        activeTab();

        var postData = {
            session: {settings: {tab: id}}
        }
        setSession(postData);
    })

    function activeTab() {
        $('.tab-selector li').each(function () {
            if (!$(this).hasClass('active')) {
                $($('a', this).first().attr('href')).hide();
            } else {
                $($('a', this).first().attr('href')).show();
            }
        });
    }

    activeTab();

    function setSession(postData) {
        $.ajax(
            {
                url: baseUrlAdmin + '/api/set-session',
                type: "post",
                data: postData,
                success: function (data, textStatus, jqXHR) {
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Server error.')
                }
            });
    }

    // Color picker
    function initColorPicker() {
        $('.color-picker-input').colorpicker();
    }

    initColorPicker();

    // Datatable static
    $('.datatable-static').DataTable({
        "stateSave": true,
        "responsive": true,
        "autoWidth": false,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
    });

    function initAutocomplete() {
        $('.autocomplete').each(function () {
            var params = {
                "model": $(this).data('model'),
                "key": $(this).data('id'),
                "column": $(this).data('column'),
                "type": $(this).data('type')
            };
            $(this).autocomplete({
                serviceUrl: baseUrlAdmin + '/api/get-model',
                params: params,
                type: 'post',
                deferRequestBy: 400,
                onSearchStart: function (query) {
                    ajaxSetupNonLoader();
                },
                onSearchComplete: function (query, suggestions) {
                    ajaxSetupLoader();
                }
            });
        })
    }

    initAutocomplete();

    // Disable click on buttons
    $('.no-click').on('click', function (e) {
        e.preventDefault();
    })

})