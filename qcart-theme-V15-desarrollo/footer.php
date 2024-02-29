<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package qcart-theme
 */

?>

	<footer id="colophon" class="site-footer">
		<div class="site-info">

		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php
wp_enqueue_script('custom-search', get_template_directory_uri() . '/js/custom-search.js', array('jquery'), '1.0', true);

wp_localize_script('custom-search', 'ajax_object', array(
	'ajax_url' => admin_url('admin-ajax.php'),
));


wp_enqueue_script('custom-search-script', get_template_directory_uri() . '/scripts/search.js', array('jquery'), '1.0', true);
wp_enqueue_script('custom-search-script', get_template_directory_uri() . '/scripts/menu.js', array('jquery'), '1.0', true);

wp_footer(); 

?>
<div class="loading-overlay">
  <div class="loading-spinner"></div>
</div>

<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>



<script>
    var loading = false;
    var total = <?php echo $wp_query->max_num_pages; ?>;
    var threshold = 3; // Número de pantallas a cargar

    $(document).ready(function() {

		if ($('.post-alone').length == 0) {
			$('<div class="grid"></div>').appendTo('.site-main');
		}

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


        $(document).ready(function() {
            $('#logoCarousel').carousel();
        });

        loadArticle(1, function() {
            loadArticle(2);
        });

        $(window).on("scroll", function() {
            if (!loading && $(window).scrollTop() + ($(window).height())*3 >= $(document).height() - 100) {
                loading = true;
                loadArticle(getNextPage(), function() {
                    loading = false;
                });
            }
        });
    });

    function getNextPage() {
        var currentPage = getNextPage.page || 3;
        getNextPage.page = currentPage + 1;
        return currentPage;
    }

    function loadArticle(pageNumber, callback) {
        var $container = $('.masonry-container');
        $('a#inifiniteLoader').show('fast');
        var searchQuery = $('#s').val(); // Obtener el valor del campo de búsqueda
			$.ajax({
            url: "<?php echo admin_url(); ?>admin-ajax.php",
            type: 'POST',
            data: {
                action: 'infinite_scroll',
                page_no: pageNumber,
                loop_file: 'loop',
                s: searchQuery, // Pasar el valor de búsqueda como un parámetro en la consulta Ajax
				what:'category_name',
				value:'<?php if(get_queried_object()!=null){ echo get_queried_object()->slug;} ?>'
            },
            success: function(html) {
                $('li#inifiniteLoader').hide('1000');
                //$("#primary").append(html);
                if (callback) callback();
                
                //$(".grid").append(html);
                
                var $newPosts = $(html); // Convierte la respuesta en elementos jQuery
            
                // Agrega los nuevos posts al contenedor Masonry
                $container.append($newPosts).masonry('appended', $newPosts);
            
                // Layout Masonry después de agregar nuevos elementos
                $container.masonry('layout');
                
            }
        });

		
        return false;
    }

    
    function handleCheckboxChange() {

    if ($('.checkbox').prop('checked')) {
        document.body.style.overflow = 'hidden';
        document.querySelector('.menu-items-list').style.overflow = 'auto';
    }else{
        // Restablecer el desplazamiento de la ventana principal
        document.body.style.overflow = 'auto';
        document.querySelector('.menu-items-list').style.overflow = 'scroll';
    }

    }


    document.querySelector('#scrollCheckbox').addEventListener('change', handleCheckboxChange);


    function handleSearchChange() {
        document.body.style.overflow = 'hidden';
    }


    document.querySelector('.search-btn').addEventListener('click', handleSearchChange);



    function handleSearchClose() {
        document.body.style.overflow = 'auto';
    }


    document.querySelector('.fa-window-close').addEventListener('click', handleSearchClose);

    function EliminarCategoryTips(){
	    console.log("DOMContentLoaded ha sido disparado");
	    if (window.location.href === 'https://sanjose.qcart.app/') {
	        var articulos = document.querySelectorAll('.col-lg-4.col-md-6.col-6.masonry-item');
            console.log('Si entró acá');
	        articulos.forEach(function(articulo) {
	            if (articulo.querySelector('.category-tips')) {
	                articulo.parentNode.removeChild(articulo);

	            }
	        });
	    }
	};

</script>


</body>
</html>
