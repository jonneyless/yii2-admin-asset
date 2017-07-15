$(document).ready(function(){
    if($(this).width() < 769){
        $('body').addClass('body-small');
    }else{
        $('body').removeClass('body-small');
    }

    $('#side-menu').metisMenu();

    $('.sidebar-container').slimScroll({
        height: '100%',
        railOpacity: 0.4,
        wheelStep: 10
    });

    $('.navbar-minimalize').on('click', function(event){
        event.preventDefault();
        $("body").toggleClass("mini-navbar");
        SmoothlyMenu();
    });

    function fix_height(){
        var heightWithoutNavbar = $("body > #wrapper").height() - 61;
        $(".sidebar-panel").css("min-height", heightWithoutNavbar + "px");

        var navbarheight = $('nav.navbar-default').height();
        var wrapperHeight = $('#page-wrapper').height();

        if(navbarheight > wrapperHeight){
            $('#page-wrapper').css("min-height", navbarheight + "px");
        }

        if(navbarheight < wrapperHeight){
            $('#page-wrapper').css("min-height", $(window).height() + "px");
        }

        if($('body').hasClass('fixed-nav')){
            if(navbarheight > wrapperHeight){
                $('#page-wrapper').css("min-height", navbarheight + "px");
            }else{
                $('#page-wrapper').css("min-height", $(window).height() - 60 + "px");
            }
        }
    }

    fix_height();

    $(window).bind("load", function () {
        if ($("body").hasClass('fixed-sidebar')) {
            $('.sidebar-collapse').slimScroll({
                height: '100%',
                railOpacity: 0.9
            });
        }
    });

    $(window).bind("resize", function(){
        if($(this).width() < 769){
            $('body').addClass('body-small');
        }else{
            $('body').removeClass('body-small');
        }
    });

    $(window).bind("load resize scroll", function(){
        if(!$("body").hasClass('body-small')){
            fix_height();
        }
    });

    $(document).tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });

    $("[data-toggle=popover]").popover();

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "progressBar": true,
        "preventDuplicates": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "400",
        "hideDuration": "1000",
        "timeOut": "7000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
});

function SmoothlyMenu(){
    if(!$('body').hasClass('mini-navbar') || $('body').hasClass('body-small')){
        // Hide menu in order to smoothly turn on when maximize menu
        $('#side-menu').hide();
        // For smoothly turn on menu
        setTimeout(
            function(){
                $('#side-menu').fadeIn(400);
            }, 200);
    }else if($('body').hasClass('fixed-sidebar')){
        $('#side-menu').hide();
        setTimeout(
            function(){
                $('#side-menu').fadeIn(400);
            }, 100);
    }else{
        // Remove all inline style from jquery fadeIn function to reset menu state
        $('#side-menu').removeAttr('style');
    }
}