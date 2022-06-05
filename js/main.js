(function ($) {
    'use strict';

    // ===== Main Menu
    function mainMenu() {
        $('.navbar-toggler').on('click', function (e) {
            e.preventDefault();
            $('.nav-menu').slideToggle()
            $(this).toggleClass('toggle-open');

        });

        $(".nav-menu ul a").on("click", function (e) {
            if ($(this).hasClass('multistep-toggle')) {
                e.preventDefault();
            }

            if ($(this).hasClass('submenu-toggle')) {
                e.preventDefault();
            }

            $(this).parent().siblings().children("ul,div").hide();
            $(this).next().toggle();

            $(this).parent().siblings('.multistep-open').removeClass('multistep-open');
			$(this).parent().toggleClass('multistep-open');
        });

        function breakpointCheck() {
            var windoWidth = window.innerWidth;

            if (windoWidth <= 991) {
                $('.nav-menu').hide()
            } else {
                $('.nav-menu').show()
                $('.navbar-toggler').removeClass('toggle-open');
            }
        }

        breakpointCheck();

        $(window).on('resize', function () {
            breakpointCheck();
        });
    }

    $(document).ready(function () {
        mainMenu();
    });


    $(".cp-upload-form").on("change", ".file-upload-field", function(){ 
        $(this).parent(".file-upload-wrapper").attr("data-text",         $(this).val().replace(/.*(\/|\\)/, '') );
        $(this).parent(".file-upload-wrapper").addClass("added")
    });

})(jQuery);