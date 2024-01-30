jQuery(document).ready(function($) {

    $('.custom-menu .has-dropdown').hover(
        function() {
            $(this).find('.dropdown').slideDown(200);
        },
        function() {
            $(this).find('.dropdown').slideUp(200);
        }
    );


    $('.menu-parent > a').click(function(e) {
        e.preventDefault();
        $(this).siblings('.submenu').slideToggle();
    });


    
});