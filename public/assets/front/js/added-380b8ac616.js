$(document).ready(function () {
    var winHeight = $(window).height();

    function height100(elem) {
        if(elem.height() > winHeight) return;

        var childLowHeight = 0;
        elem.find('.child-low').each(function(index){
            childLowHeight += $(this).height();
        })

        elem.find('.child-high').first().height(winHeight - childLowHeight);
    }

    height100($('#where-we-are'));
})