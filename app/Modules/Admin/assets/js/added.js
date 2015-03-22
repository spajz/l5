// Ajax loader
function loaderShow() {
    $('.ajax-loader').show();
}

function loaderHide() {
    $('.ajax-loader').hide();
}

// Sort rows
function sortRows(model, sortData) {
    $.ajax({
        url: baseUrlAdmin + '/sort-rows',
        type: 'post',
        data: {
            "model": model,
            "data": sortData
        },
        success: function (data, status) {

        },
        error: function (xhr, desc, err) {
            alert('Server error.');
        }
    });
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

    $(document).on('pjax:send', function () {
        loaderShow();
    })
    $(document).on('pjax:complete', function () {
        initSelect2();
        initCkeditor();
        loaderHide();
    })

    $(document).on('submit', 'form[data-pjax]', function (event) {
        var btn = $(":input[type=submit]:focus");
        if (btn.data('pjax')) {
            $.pjax.submit(event, {container: '#pjax-container', timeout: 5000});
        }
    })

    //$(document).on('click', 'a[data-pjax]', function (e) {
    //    $.pjax.click(e, {container: '#pjax-container', timeout: 5000})
    //})


})