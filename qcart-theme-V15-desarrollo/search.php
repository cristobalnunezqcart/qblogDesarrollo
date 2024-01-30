<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package qcart-theme
 */

get_header();

//get_search_form();
echo do_shortcode( '[custom_search_form]' );
?>

<main id="primary" class="site-main">

<header class="page-header">
				<h1 class="page-title">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Resultados de busqueda para: %s', 'qcart-theme' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</header>
</main>

<?php
get_footer();
?>

<script type="text/javascript">
loadArticle(1, function(){
	loadArticle(2);
});

document.addEventListener("DOMContentLoaded", function(event) {
   var count = 3;
   var total = <?php echo $wp_query->max_num_pages; ?>;
   $(window).scroll(function(){
     if ($(window).scrollTop() == $(document).height() - $(window).height()){
      if (count > total){
        return false;
      }else{
        loadArticle(count);
      }
      count++;
     }
   });
 });

function loadArticle(pageNumber, callback){
    $('a#inifiniteLoader').show('fast');
    $.ajax({
       url: "<?php echo admin_url(); ?>admin-ajax.php",
       type:'POST',
       data: "action=infinite_scroll&page_no="+ pageNumber + '&loop_file=loop&what=search&value=' + encodeURIComponent('<?php echo get_search_query(); ?>'),       success: function (html) {
         $('li#inifiniteLoader').hide('1000');
        //  $("ul.timeline").append(html);
		$("#primary").append(html);
		if(callback) callback();
       }
    });
    return false;
}
</script>
