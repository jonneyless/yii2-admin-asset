$(document).ready(function(){
    if($(this).width() < 769){
        $('body').addClass('body-small')
    }else{
        $('body').removeClass('body-small')
    }

    $('#sidebar-nav').metisMenu();

    function fix_height() {
        $('#sidebar').css('minHeight', $(window).height());
        $('#page-wrapper').css('minHeight', $(window).height());
    }

    fix_height();

    $(window).bind("resize", function () {
        if ($(this).width() < 769) {
            $('body').addClass('body-small')
        } else {
            $('body').removeClass('body-small')
        }
    });

    $(window).bind("load resize scroll", function () {
        if (!$("body").hasClass('body-small')) {
            fix_height();
        }
    });
});