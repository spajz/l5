// Add csrf token to all ajax calls
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
            "extra": extra,
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
    function initSortable(){
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
        if ($('.fancybox').length) {
            $('.fancybox').fancybox({
                openEffect: 'none',
                closeEffect: 'none'
            });
        }
    }

    initFancyBox();

    // Msg modal
    if ($('#overlay-modal').length) {
        $('#overlay-modal').modal();
    }

    // CKEditor
    function initCkeditor() {
        CKEDITOR.disableAutoInline = true;
        if ($('#ckeditor').length) {
            $('#ckeditor').ckeditor();
        }
    }

    initCkeditor();

    // Pjax
    $.pjax.defaults.scrollTo = false;

    $('body').on('pjax:send', function () {
        loaderShow();
    })
    $('body').on('pjax:complete', function () {
        initSelect2();
        initCkeditor();
        loaderHide();
        initSortable();
    })

    $('body').on('submit', 'form[data-pjax]', function (e) {
        var btn = $(":input[type=submit]:focus");
        if (btn.data('pjax')) {
            $.pjax.submit(e, {container: '#pjax-container', timeout: 5000});
        }
    })

    $('body').on('click', 'a[data-pjax]', function (e) {
        $.pjax.click(e, {container: '#pjax-container', timeout: 5000})
    })

    // Password generator
    $('[data-random-string]').on('click', function (e) {
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
                $.pjax({url: thisObj.attr('href'), container: '#pjax-container', timeout: 5000})
            }
        });
    };

    bbFunction.submit = function (thisObj) {
        bootbox.confirm("Are you sure?", function (result) {
            if (result) {
                $('<input>').attr({
                    type: 'hidden',
                    name: thisObj.attr('name'),
                    value: thisObj.attr('value')
                }).appendTo(thisObj.closest('form'));
                thisObj.closest('form').submit();
            }
        });
    };

    bbFunction.submitPjax = function (thisObj) {
        bootbox.confirm("Are you sure?", function (result) {
            if (result) {
                $('<input>').attr({
                    type: 'hidden',
                    name: thisObj.attr('name'),
                    value: thisObj.attr('value')
                }).appendTo(thisObj.closest('form'));

                thisObj.closest('form').on('submit', function (e) {
                        $.pjax.submit(e, {container: '#pjax-container', timeout: 5000});
                }).submit()
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

})