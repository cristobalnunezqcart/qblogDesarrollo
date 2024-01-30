jQuery(document).ready(function($) {
    $('.search-form').on('submit', function(e) {
        e.preventDefault();
        

        $('.loading-overlay').show().css({
            display: 'flex',
            justifyContent: 'center',
            alignItems: 'center',
            position: 'fixed',
            top: 0,
            left: 0,
            width: '100%',
            height: '100%',
            backgroundColor: 'rgba(0, 0, 0, 0.5)', // Cambia esto para ajustar la opacidad del fondo
            zIndex: 9999 // Asegúrate de que la capa esté por encima de otros elementos
        });

        var searchQuery = "";
        $('.search-field').each(function() {
            searchQuery = ($(this).val() != "") ? $(this).val() : searchQuery;
        });


        $.ajax({
            url: custom_search_params.ajax_url,
            type: 'POST',
            data: {
                action: 'custom_search',
                search_query: searchQuery, // Agregar el valor de búsqueda aquí
                nonce: custom_search_params.nonce,
            },
            beforeSend: function() {
                //
            },
            success: function(response) {

                window.scrollTo({ top: 0, behavior: 'smooth' });
                $('.loading-overlay').hide();
                if ($('.checkbox').prop('checked')) {
                    $('.checkbox').click();
                }
                $('.fa-window-close').click();

                $('.site-main').removeClass('post-alone');
                $('.single-post').addClass('home');
                $('.single-post').removeClass('single');
                $('.swiper.banner.mobile').attr('style','display:none !important');
                $('.swiper-outer-container').attr('style','margin-top:11vh;display:block!important');

                $('#primary').html('<div class="grid"></div>');

                var $container = $('.grid').find('.masonry-container');

                // Si no existe, créalo y agréguelo dentro de .grid
                if ($container.length === 0) {
                    $container = $('<div class="row g-2 masonry-container"></div>').appendTo('.grid');
                }
                

                var $grid = $('.masonry-container').masonry({
                itemSelector: '.masonry-item',
                columnWidth: '.masonry-item',
                percentPosition: true
                });



                var $newPosts = $(response); // Convierte la respuesta en elementos jQuery
            
                // Agrega los nuevos posts al contenedor Masonry
                $('.masonry-container').append($newPosts).masonry('appended', $newPosts);
            
                // Layout Masonry después de agregar nuevos elementos
                $('.masonry-container').masonry('layout');


            },
            error: function(error) {
                alert('Por favor corroborar conexión a internet, conexión inestable')
            }
        });
    });
});