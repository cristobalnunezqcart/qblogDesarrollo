jQuery(document).ready(function($) {
    // Mostrar submenú al hacer hover en "Recetas"
    $('.custom-menu-item').hover(function() {
        $(this).find('.sub-menu').slideDown();
    }, function() {
        $(this).find('.sub-menu').slideUp();
    });

    // Manejar clic en una categoría del menú
    $('.custom-menu .sub-menu li a').on('click', function(e) {
        e.preventDefault();
        var selectedCategory = $(this).data('category');
        $('#search-form').submit(); // Hacer una nueva búsqueda al seleccionar una categoría
    });
});
