<?php
/**
 * Template for displaying single posts.
 *
 * @package qcart-theme
 */

get_header();
echo do_shortcode('[custom_mobile_menu]');
?>

<div class="container-fluid bg-light volver-atras">
    <div class="row">
        <div class="col-2">
            <a href="javascript:history.back()" class="back-link">
                <i class="fas fa-arrow-left"></i>
                Atrás
            </a>
        </div>
        <div class="col-8 text-center">
          <h2 class="category-title"></h2>
        </div>
    </div>
</div>

<div class="container">
    <div class="row align-items-center">
        <div id="primary" class="site-main post-alone">
            <div class="col-md-5">
                <?php
                while (have_posts()) :
                    the_post();

                    ?>
                    <div class="title-box p-2 mb-2 rounded d-md-none" style="background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);font-family: 'Nunito Sans', sans-serif;">
                    <?php
					echo '<h1 class="entry-title text-center d-md-none" style="font-size: 1.5rem; font-weight: 400;">' . get_the_title() . '</h1>';
                    ?>
                    </div>
                    <?php
                    $post_content = get_the_content();
					$video_url = '';


					$pattern = '/(https?:\/\/[^\s]+\b\.mp4\b)/i';
					if (preg_match($pattern, $post_content, $matches)) {

						$video_url = esc_url($matches[0]);
	

						$post_content = preg_replace($pattern, '', $post_content);
					}

					
                    if (!empty($video_url)) {
                        echo '<div style="display:flex;justify-content:center;" class="embed-responsive embed-responsive-9by16 mt-4 mb-4 ml-auto text-md-right">';
                        echo '<div style="width: 80%; height: 0; padding-bottom: 100%; position: relative;">';
                        echo '<video class="video-post-alone embed-responsive-item rounded" controls style="position: absolute; width: 100%; height: 100%;">';
                        echo '<source src="' . $video_url . '" type="video/mp4">';
                        echo '</video>';
                        echo '</div>';
                        echo '</div>';
                    } else {
                        // Mostrar la imagen del post
                        if (has_post_thumbnail()) :
                            echo '<div class="post-thumbnail text-center mb-4">';
                            the_post_thumbnail('large', ['class' => 'w-75 img-fluid rounded']);
                            echo '</div>';
                        endif;
                    }
                endwhile;
                ?>
            </div><!-- .col-md-5 -->

            <div class="col-md-7">
                <div class="title-box p-2 mb-2 rounded d-none d-md-block" style="background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);font-family: 'Nunito Sans', sans-serif;">

                <?php
                    echo '<h1 class="entry-title text-center mb-0" style="font-size: 1.5rem; font-weight: 400;">' . get_the_title() . '</h1>';
                ?>
                </div>
                <main>
                    <?php
                    while (have_posts()) :
                        the_post();
                        // Divider
                        echo '<hr class="divider bg-madison hr-left-0">';
                        // Display the content of the post (description)
                        echo '<div class="entry-content">';
                        //$post_content = preg_replace('/<figure[^>]+>/', '', $post_content);
                        echo apply_filters('the_content', $post_content);
                        echo '</div>';
                    endwhile;
                    ?>
                </main>
            </div><!-- .col-md-7 -->
		</div>
    </div><!-- .row -->
</div><!-- .container -->

<?php
get_footer();