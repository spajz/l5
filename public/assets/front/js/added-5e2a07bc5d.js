// Scroll to anchor
$.extend($.scrollTo.defaults, {
    axis: 'y',
    duration: 1000,
    easing: 'swing'
});

// Get current viewport
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
        imageResize();
    }, 100, fullDateString.getTime())
});

function imageResize() {
    $('.persons-box .person-img').each(function (index) {
        var imgWidth = $(this).width();
        var size = imgWidth * 10;
        $(this).css({
            'background-position': '-' + imgWidth + 'px 0',
            'background-size': size + 'px'
        });
    })
}

/* Orientation
 1 - direct
 2 - up
 3 - up-right
 4 - right
 5 - down-right
 6 - down
 7 - down-left
 8 - left
 9 - up-left
 10 - empty
 */

var orientations = {
    direct: 0,
    up: 1,
    upRight: 2,
    right: 3,
    downRight: 4,
    down: 5,
    downLeft: 6,
    left: 7,
    upLeft: 8
};

function setOrientation($elem) {
    var elemOffset = $elem.offset();
    var top = parseInt(elemOffset.top);
    var left = parseInt(elemOffset.left);
    $('.persons-box .person-img').each(function (index) {

        var imgWidth = $(this).width();
        //var imgWidth = Math.round($(this)[0].getBoundingClientRect().width);
        var itemOffset = $(this).offset();
        var itemTop = parseInt(itemOffset.top);
        var itemLeft = parseInt(itemOffset.left);
        var verPosition;
        var horPosition;
        var orientation;

        // Vertical position
        switch (true) {
            case (top > itemTop):
                verPosition = 'below';
                break;
            case (top < itemTop):
                verPosition = 'above';
                break;
            case (top == itemTop):
                verPosition = 'same';
                break;
        }

        // Horizontal position
        switch (true) {
            case (left < itemLeft):
                horPosition = 'left';
                break;
            case (left > itemLeft):
                horPosition = 'right';
                break;
            case (left == itemLeft):
                horPosition = 'same';
                break;
        }

        // Set position
        switch (true) {
            case (verPosition == 'below' && horPosition == 'left'):
                orientation = orientations.downLeft;
                break;

            case (verPosition == 'below' && horPosition == 'right'):
                orientation = orientations.downRight;
                break;

            case (verPosition == 'below' && horPosition == 'same'):
                orientation = orientations.down;
                break;

            case (verPosition == 'above' && horPosition == 'left'):
                orientation = orientations.upLeft;
                break;

            case (verPosition == 'above' && horPosition == 'right'):
                orientation = orientations.upRight;
                break;

            case (verPosition == 'above' && horPosition == 'same'):
                orientation = orientations.up;
                break;

            case (verPosition == 'same' && horPosition == 'left'):
                orientation = orientations.left;
                break;

            case (verPosition == 'same' && horPosition == 'right'):
                orientation = orientations.right;
                break;

            case (verPosition == 'same' && horPosition == 'same'):
                orientation = orientations.direct;
                break;
        }

        var spritePosition = orientation * imgWidth;
        var size = imgWidth * 10;

        $(this).css({
            'background-position': '-' + spritePosition + 'px 0',
            'background-size': size + 'px'
        });
    })
}


function getViewport() {
    var vpc = $('.viewports div:visible').attr('class');
    vpc = vpc.split("-");
    return vpc[1];
}

// Lazy load
$("img.lazy").lazyload();

$(document).ready(function () {

    // Smooth scroll
    $.scrollSpeed(100, 800);

    var winHeight = $(window).height();

    getViewport();
    imageResize();

    $('.persons-box .person-btn').hover(
        function () {
            setOrientation($(this));
        },
        function () {
        }
    );

    //$('.persons-box .person-btn').hoverIntent({
    //    over:  function () {
    //        setOrientation($(this));
    //    },
    //    out: function () {
    //    },
    //    sensitivity: 400
    //});

    $('.persons-box .person-btn').on('click', function(e){
        e.preventDefault();
        setOrientation($(this));
        $('.ih-item.square').find('.person-active').removeClass('person-active');
        $(this).addClass('person-active');
    });

    // Disable click on buttons
    $('.no-click').on('click', function (e) {
        e.preventDefault();
    })

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

// Clients hover effects adjust
$(window).load(function () {
    $('.ih-item').each(function () {
        $(this).css('maxWidth', $('img', this).width() + 'px')
    })
})