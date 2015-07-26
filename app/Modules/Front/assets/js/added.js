$.extend($.scrollTo.defaults, {
    axis: 'y',
    duration: 1000,
    easing: 'swing'
});

var waitForFinalEvent = function () {
    var b = {};
    return function (c, d, a) {
        a || (a = "I am a banana!");
        b[a] && clearTimeout(b[a]);
        b[a] = setTimeout(c, d)
    }
}();
var fullDateString = new Date();

$(window).resize(function () {
    waitForFinalEvent(function () {
        var viewPort = getViewport();
    }, 300, fullDateString.getTime())
});

function getViewport() {
    var vpc = $('.viewports div:visible').attr('class');
    vpc = vpc.split("-");
    return vpc[1];
}

$("img.lazy").lazyload();

$(document).ready(function () {
    $('.no-click').on('click', function (e) {
        e.preventDefault();
    })

    var winHeight = $(window).height();

    getViewport();

    function height100(elem) {
        if (elem.height() > winHeight) return;

        var childLowHeight = 0;
        elem.find('.child-low').each(function (index) {
            childLowHeight += $(this).height();
        })

        elem.find('.child-high').first().height(winHeight - childLowHeight);
    }

    height100($('#where-we-are'));

    $('.scroll-btn').on('click', function (e) {
        e.preventDefault();
        $(window).stop(true).scrollTo(this.hash, {interrupt: true});
    })
})