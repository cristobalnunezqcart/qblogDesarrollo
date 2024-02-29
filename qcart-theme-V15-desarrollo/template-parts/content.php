<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package qcart-theme
 */
?>

<div class="col-lg-4 col-md-6 col-6 masonry-item">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="card">
                <?php
                if (!is_singular()) {
                    ?>
                    <a href="<?php echo esc_url(get_permalink()); ?>">
                        <?php
                }
                ?>
                <?php
                $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
                ?>
                <img src="<?php echo esc_url($thumbnail[0]); ?>" class="card-img-top" alt="<?php the_title_attribute(); ?>">
                <i class="imagen-superpuesta fa fa-play-circle" style="font-size:36px;"></i>
                
                <div class="card-body">
                    <?php
                    if (is_singular()) :
                        the_title('<h1 class="card-title">', '</h1>');
                    else :
                        the_title('<h2 class="card-title"><a class="text-decoration-none text-reset" href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                    endif;

                    if ('post' === get_post_type()) :
                        ?>
                        <div class="card-meta text-end">
                            <?php
                            if ('post' === get_post_type()) :
                                $categories = get_the_category();
                                if (!empty($categories)) {
                                    $category = $categories[0]; // Tomamos solo la primera categoría, puedes ajustar esto según tus necesidades.
                                    ?>
                                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" style="white-space: normal; display: inline-block; color:#000;"  class="rounded btn-category btn-sm"><?php echo esc_html($category->name); ?></a>
                                    <?php
                                }
                                //qcart_theme_posted_on();
                                //qcart_theme_posted_by();
                            endif;
                            ?>
                        </div><!-- .card-meta -->
                    <?php endif; ?>
                </div><!-- .card-body -->
                <?php
                if (!is_singular()) {
                    ?>
                    </a>
                    <?php
                }
                ?>
            </div><!-- .card -->
			</article><!-- #post-<?php the_ID(); ?> -->
        </div><!-- .masonry-item -->
