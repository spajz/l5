// Add prev and next parametar to array
Array.prototype.next = function () {
    return this[++this.current];
};
Array.prototype.prev = function () {
    return this[--this.current];
};
Array.prototype.current = 0;

// Scroll to anchor
$.extend($.scrollTo.defaults, {
    axis: 'y',
    duration: 1000,
    easing: 'swing'
});

// Add csrf token to all ajax calls
function ajaxSetupLoader() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            showLoader();
        },
        complete: function () {
            hideLoader();
        }
    });
}

ajaxSetupLoader();

// Ajax loaders
function showLoader() {
    $('#loader').show();
}

function hideLoader() {
    $('#loader').hide();
}

$(window).load(function () {
    $('.persons-box .person-img').attr('src', baseUrl + '/assets/front/images/person350.png');
})

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
        setFontSizePerson($('.persons-box .person-btn'));
    }, 100, fullDateString.getTime())
});

function imageResize() {
    $('.persons-box .person-img').each(function (index) {
        var imgWidth = $(this).width();
        var size = imgWidth * 9;
        $(this).css({
            'background-position': '0 0',
            'background-size': size + 'px'
        });
    })
    //$('.vertical-center').flexVerticalCenter();
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
        var size = imgWidth * 9;

        //var elemImage = $elem.find('.person-img').first();
        //if ($(this)[0] === elemImage[0]) { console.log(index); console.log(7777777)
        //    $(this).css({
        //        'background-position': '0 0',
        //        'background-size': size + 'px'
        //    });
        //} else {
        $(this).css({
            'background-position': '-' + spritePosition + 'px 0',
            'background-size': size + 'px'
        });
        //}

    })
}

function setFontSizePerson(elem) {
    var imgSize = parseInt(elem.find('.person-img').first().width());
    var size = parseInt(imgSize / 10);
    elem.find('.info h3').css({
        'font-size': parseInt(size * 1.1) + 'px',
        'margin-top': parseInt(size * 2) + 'px',
        'margin-bottom': parseInt(size * 0.8) + 'px',
    });
    elem.find('.info .description').css({
        'font-size': parseInt(size * 0.6) + 'px',
        //'margin-bottom':parseInt(size * 0.8) + 'px',
    });
    elem.find('.info .lead').css({
        'font-size': parseInt(size * 0.8) + 'px',
        //'margin-bottom':parseInt(size * 0.8) + 'px',
    });
    $('.vertical-center').flexVerticalCenter();
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

    $('.persons-box .person-btn').on('click', function (e) {
        e.preventDefault();
        if ($(this).hasClass('person-active')) {
            $(this).find('.person-img').first().css('background-position', '0 0')
            $(this).removeClass('person-active');
            return;
        }
        setFontSizePerson($(this));
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

    function stickyFooter() {
        var footerHeight = $('#contact').innerHeight();
        var footerOffset = $('#contact').offset().top;
        var windowHeight = $(window).innerHeight();
        if (windowHeight > (footerHeight + footerOffset)) {
            $('#contact').css('padding-top', parseInt(windowHeight - (footerHeight + footerOffset)) + 'px')
        }
    }

    stickyFooter();

})

// Calculate color gradient
jsgradient = {
    inputA: '',
    inputB: '',
    inputC: '',
    gradientElement: '',

    // Convert a hex color to an RGB array e.g. [r,g,b]
    // Accepts the following formats: FFF, FFFFFF, #FFF, #FFFFFF
    hexToRgb: function (hex) {
        var r, g, b, parts;
        // Remove the hash if given
        hex = hex.replace('#', '');
        // If invalid code given return white
        if (hex.length !== 3 && hex.length !== 6) {
            return [255, 255, 255];
        }
        // Double up charaters if only three suplied
        if (hex.length == 3) {
            hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
        }
        // Convert to [r,g,b] array
        r = parseInt(hex.substr(0, 2), 16);
        g = parseInt(hex.substr(2, 2), 16);
        b = parseInt(hex.substr(4, 2), 16);

        return [r, g, b];
    },

    // Converts an RGB color array e.g. [255,255,255] into a hexidecimal color value e.g. 'FFFFFF'
    rgbToHex: function (color) {
        // Set boundries of upper 255 and lower 0
        color[0] = (color[0] > 255) ? 255 : (color[0] < 0) ? 0 : color[0];
        color[1] = (color[1] > 255) ? 255 : (color[1] < 0) ? 0 : color[1];
        color[2] = (color[2] > 255) ? 255 : (color[2] < 0) ? 0 : color[2];

        return this.zeroFill(color[0].toString(16), 2) + this.zeroFill(color[1].toString(16), 2) + this.zeroFill(color[2].toString(16), 2);
    },

    // Pads a number with specified number of leading zeroes
    zeroFill: function (number, width) {
        width -= number.toString().length;
        if (width > 0) {
            return new Array(width + (/\./.test(number) ? 2 : 1)).join('0') + number;
        }
        return number;
    },

    // Generates an array of color values in sequence from 'colorA' to 'colorB' using the specified number of steps
    generateGradient: function (colorA, colorB, steps) {
        var result = [], rInterval, gInterval, bInterval;

        colorA = this.hexToRgb(colorA); // [r,g,b]
        colorB = this.hexToRgb(colorB); // [r,g,b]
        steps -= 1; // Reduce the steps by one because we're including the first item manually

        // Calculate the intervals for each color
        rStep = ( Math.max(colorA[0], colorB[0]) - Math.min(colorA[0], colorB[0]) ) / steps;
        gStep = ( Math.max(colorA[1], colorB[1]) - Math.min(colorA[1], colorB[1]) ) / steps;
        bStep = ( Math.max(colorA[2], colorB[2]) - Math.min(colorA[2], colorB[2]) ) / steps;

        result.push('#' + this.rgbToHex(colorA));

        // Set the starting value as the first color value
        var rVal = colorA[0],
            gVal = colorA[1],
            bVal = colorA[2];

        // Loop over the steps-1 because we're includeing the last value manually to ensure it's accurate
        for (var i = 0; i < (steps - 1); i++) {
            // If the first value is lower than the last - increment up otherwise increment down
            rVal = (colorA[0] < colorB[0]) ? rVal + Math.round(rStep) : rVal - Math.round(rStep);
            gVal = (colorA[1] < colorB[1]) ? gVal + Math.round(gStep) : gVal - Math.round(gStep);
            bVal = (colorA[2] < colorB[2]) ? bVal + Math.round(bStep) : bVal - Math.round(bStep);
            result.push('#' + this.rgbToHex([rVal, gVal, bVal]));
        }
        ;

        result.push('#' + this.rgbToHex(colorB));

        return result;
    },

    gradientList: function (colorA, colorB, list) {
        var list = (typeof list === 'object') ? list : document.querySelector(list);

        var listItems = list.querySelectorAll('li'),
            steps = listItems.length,
            colors = jsgradient.generateGradient(colorA, colorB, steps);

        for (var i = 0; i < listItems.length; i++) {
            var item = listItems[i];
            item.style.backgroundColor = colors[i];
        }
        ;
    }

}