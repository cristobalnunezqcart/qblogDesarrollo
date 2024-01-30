jQuery(document).ready(function($) {
    var isLoading = false;

    var loadMoreButton = $('#custom-widget-load-more');
    var totalPosts = loadMoreButton.data('total');
    var perPage = loadMoreButton.data('per-page');
    var remainingPosts = loadMoreButton.data('remainingPosts');
    var selectedCategory = '';
    // Función para limpiar la grilla de resultados
    function clearResults() {
        $('.custom-widget-grid').empty();
    }

    
    // Manejar el envío del formulario de búsqueda
    $('#search-form').on('submit', function(e) {
        e.preventDefault();
        var searchInput = $('#search-input').val();

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
        // Limpiar la grilla antes de cargar nuevos resultados
        clearResults();
        var postsToLoad = (remainingPosts < perPage ? remainingPosts : perPage) < 0 ? 0 : (remainingPosts < perPage ? remainingPosts : perPage) ;
        var remainingPosts = (totalPosts - (1 * perPage)) < 0 ? 0 : (totalPosts - (1 * perPage));


        // Realizar la búsqueda utilizando el shortcode personalizado
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'custom_widget_load_more', // Usamos la misma acción del infinitescroll.js
                page: 1,
                total: totalPosts, // Establecemos total a 0 para evitar errores en la función de búsqueda
                posts_to_load: postsToLoad,
                search_term: searchInput,
                remainingPosts : remainingPosts,
                selectedCategory : selectedCategory
            },
            success: function(response) {
                // Insertar los resultados de búsqueda en la grilla
                $('.custom-widget-grid').html(response.data.content);

                // Restaurar el estado inicial del infinitescroll.js
                isLoading = false;
                currentPage = 1;
                totalPosts = response.data.remainingPosts;

                // Reiniciar el scroll infinito
                $(window).scrollTop(0);
                $('.loading-overlay').hide();
            }
        });
    });
    
});
